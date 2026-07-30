<?php
// Simple docx text extractor without ZipArchive
$file = 'd:/Kampus/Skripsi/kartu-ibu/Muhammad Idlal Hafizd.docx';
$cmd = 'powershell -Command "Add-Type -AssemblyName System.IO.Compression.FileSystem; $z = [System.IO.Compression.ZipFile]::OpenRead(\"' . $file . '\"); $entry = $z.GetEntry(\"word/document.xml\"); $stream = $entry.Open(); $reader = New-Object System.IO.StreamReader($stream); $reader.ReadToEnd(); $reader.Close(); $z.Dispose()"';
$output = shell_exec($cmd);
$text = strip_tags(str_replace('<', ' <', $output));
$text = preg_replace('/\s+/', ' ', $text);
file_put_contents('d:/Kampus/Skripsi/kartu-ibu/thesis_text.txt', $text);
echo "Done - " . strlen($text) . " chars\n";
