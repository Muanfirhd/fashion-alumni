<?php
// functions.php — Fungsi bantuan (upload gambar, dsb.)

// Upload gambar dengan validasi. Pulangkan nama fail atau null.
function upload_gambar($field, $folder) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return null; // tiada fail dimuat naik
    }
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return false;
    }
    $dibenarkan = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $dibenarkan)) {
        return false;
    }
    if ($_FILES[$field]['size'] > 2 * 1024 * 1024) { // had 2MB
        return false;
    }
    $namaBaru = uniqid('img_', true) . '.' . $ext;
    $dest = __DIR__ . '/uploads/' . $folder . '/' . $namaBaru;
    if (move_uploaded_file($_FILES[$field]['tmp_name'], $dest)) {
        return $namaBaru;
    }
    return false;
}

// Padam fail gambar lama jika wujud
function padam_gambar($folder, $namaFail) {
    if ($namaFail) {
        $path = __DIR__ . '/uploads/' . $folder . '/' . $namaFail;
        if (file_exists($path)) {
            unlink($path);
        }
    }
}

// Escape output (ringkas)
function e($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}
