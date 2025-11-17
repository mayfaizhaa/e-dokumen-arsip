<?php

return [
'db' => [
'host' => '127.0.0.1',
'name' => 'e_arsip',
'user' => 'root',
'pass' => ''
],
'upload_dir' => __DIR__ . '/uploads',
'max_upload_bytes' => 15 * 1024 * 1024, 
'allowed_mime' => [
'application/pdf',
'application/msword',
'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
]
];