<?php
require('../session-management.php');
require('../../required/db-connection/connection.php');

if (!$con) {
    die("Database connection failed.");
}

if (isset($_GET['id'])) {
    try {
        $fileId = intval($_GET['id']); // No echo

        // Fetch BLOB data
        $stmt = $con->prepare("SELECT plist_sow FROM project_list WHERE plist_id = ?");
        $stmt->bind_param("i", $fileId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $fileData = $row['plist_sow'] ?? null;
        $stmt->close();

        if (!$fileData) {
            die("Error: No file found.");
        }

        // Detect MIME type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($fileData);
        if (!$mimeType) {
            $mimeType = "application/octet-stream"; // Default if unknown
        }

        // Suggest a filename
        $extension = explode('/', $mimeType)[1] ?? 'bin';
        $fileName = "downloaded_file." . $extension;

        // Debug: Write to a file for verification
        file_put_contents("debug_output", $fileData);

        // Send headers for file download
        header("Content-Type: " . $mimeType);
        header("Content-Disposition: attachment; filename=" . $fileName);
        header("Content-Length: " . strlen($fileData));
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Clean any output buffer
        ob_clean();
        flush();

        // Output the file data
        echo $fileData;
        exit;
    } catch (Exception $e) {
        echo json_encode(["error" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request."]);
}
?>
