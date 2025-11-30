<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Upload failed']);
    exit;
}

$file = $_FILES['file'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$tmpPath = $file['tmp_name'];
$content = '';

try {
    if ($ext === 'txt') {
        $content = file_get_contents($tmpPath);
    } elseif ($ext === 'pdf') {
        // Use pdftotext (must be installed on server)
        $cmd = "pdftotext -layout " . escapeshellarg($tmpPath) . " -";
        $content = shell_exec($cmd);
        if ($content === null) {
            throw new Exception("Failed to parse PDF. Ensure pdftotext is installed.");
        }
    } elseif ($ext === 'docx') {
        $content = parseDocx($tmpPath);
    } else {
        throw new Exception("Unsupported file type: $ext");
    }

    // Basic extraction: First line is title, rest is content
    $lines = preg_split('/\r\n|\r|\n/', trim($content));
    $title = '';
    $body = '';

    if (!empty($lines)) {
        // Remove empty lines from start
        while (!empty($lines) && trim($lines[0]) === '') {
            array_shift($lines);
        }
        
        if (!empty($lines)) {
            $title = trim(array_shift($lines));
            $body = trim(implode("\n", $lines));
        }
    }

    echo json_encode([
        'success' => true,
        'title' => $title,
        'content' => nl2br(htmlspecialchars($body)) // Convert newlines to <br> for HTML editors
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

function parseDocx($filename) {
    $content = '';
    $zip = new ZipArchive;
    
    if ($zip->open($filename) === TRUE) {
        if (($index = $zip->locateName('word/document.xml')) !== false) {
            $xmlData = $zip->getFromIndex($index);
            $dom = new DOMDocument;
            $dom->loadXML($xmlData, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $dom->encoding = 'utf-8';
            
            $elements = $dom->getElementsByTagName('*');
            foreach ($elements as $element) {
                if ($element->localName == 't') {
                    $content .= $element->nodeValue;
                }
                if ($element->localName == 'p') {
                    $content .= "\n"; // Add newline for paragraphs
                }
            }
        }
        $zip->close();
    } else {
        throw new Exception("Failed to open DOCX file");
    }
    
    return $content;
}
?>
