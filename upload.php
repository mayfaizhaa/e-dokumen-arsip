<?php
require './config/init.php';
require_login();

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $category = $_POST['category_id'] ?? null;
    $tags_raw = $_POST['tags'] ?? '';
    $file = $_FILES['file'] ?? null;

    if (!$title || !$file || !$file['name']) {
        $error = "Judul & file wajib diisi.";
    } else {
        $allowed = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        ];

        $mime = mime_content_type($file['tmp_name']);
        if (!in_array($mime, $allowed)) {
            $error = "Hanya boleh upload PDF/DOC/DOCX";
        } elseif ($file['size'] > 10 * 1024 * 1024) { 
            $error = "File terlalu besar (maks 10MB)";
        } else {
            try {
                global $pdo, $config;

                $pdo->beginTransaction();

                $stmt = $pdo->prepare("INSERT INTO documents (title, description, category_id, created_by) VALUES (?, ?, ?, ?)");
                $stmt->execute([$title, $desc, $category, current_user()['id']]);
                $doc_id = $pdo->lastInsertId();

                $upload_dir = $config['upload_dir'];
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $stored = bin2hex(random_bytes(16)) . "." . $ext;
                $dest = rtrim($upload_dir, '/') . '/' . $stored;

                if (!move_uploaded_file($file['tmp_name'], $dest)) {
                    throw new Exception("Gagal menyimpan file.");
                }

                $stmt = $pdo->prepare("INSERT INTO document_versions (document_id, filename, original_name, mime, size, uploaded_by, notes) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $doc_id, $stored, $file['name'], $mime, $file['size'], current_user()['id'], "Initial upload"
                ]);
                $ver_id = $pdo->lastInsertId();

                $stmt = $pdo->prepare("UPDATE documents SET current_version_id = ? WHERE id = ?");
                $stmt->execute([$ver_id, $doc_id]);

                if ($tags_raw) {
                    $tags = array_filter(array_map('trim', explode(',', $tags_raw)));
                    foreach ($tags as $t) {
                        $s = $pdo->prepare("SELECT id FROM tags WHERE name=?");
                        $s->execute([$t]);
                        $tid = $s->fetchColumn();

                        if (!$tid) {
                            $ins = $pdo->prepare("INSERT INTO tags (name) VALUES (?)");
                            $ins->execute([$t]);
                            $tid = $pdo->lastInsertId();
                        }

                        $pt = $pdo->prepare("INSERT IGNORE INTO document_tags (document_id, tag_id) VALUES (?, ?)");
                        $pt->execute([$doc_id, $tid]);
                    }
                }

                $pdo->commit();
                log_action($pdo, current_user()['id'], 'upload', "Uploaded document id=$doc_id");

                header("Location: documents.php?msg=uploaded");
                exit;

            } catch (Exception $e) {
                $pdo->rollBack();
                if (isset($dest) && file_exists($dest)) unlink($dest);
                $error = "Gagal menyimpan dokumen: " . $e->getMessage();
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
<title>Upload Dokumen</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Upload Dokumen</h2>

<?php if(!empty($error)) echo '<p class="error">'.htmlspecialchars($error)."</p>"; ?>

<form method="post" enctype="multipart/form-data">
<label>Judul<br><input name="title" required></label><br>
<label>Deskripsi<br><textarea name="description"></textarea></label><br>
<label>Kategori (id)<br><input name="category_id"></label><br>
<label>Tags (pisah koma)<br><input name="tags"></label><br>
<label>File (PDF/DOC/DOCX)<br><input type="file" name="file" required></label><br>
<button>Upload</button>
</form>

<p><a href="documents.php">Kembali ke daftar</a></p>
</body>
</html>
