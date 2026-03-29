<?php
// 保存するCSVファイル名
$csvFile = 'index.csv';

// スキャン対象のディレクトリ（現在のディレクトリ）
$dir = './';

// CSVに書き込みたくないファイルやディレクトリ
$exclude = ['.', '..', '.DS_Store', 'index.php', 'index.csv'];

function scanFiles($directory, $level = 0, &$results = []) {
    global $exclude;
    $files = scandir($directory);

    foreach ($files as $file) {
        if (in_array($file, $exclude)) continue;

        $path = $directory . $file;
        // 表示用のタイトル（ファイル名から拡張子を除いたものなど）
        $title = htmlspecialchars($file);
        // 相対パス
        $link = ltrim($path, './');

        if (is_dir($path)) {
            // ディレクトリの場合
            $results[] = [$level, "📁 " . $title, $link . '/'];
            scanFiles($path . '/', $level + 1, $results);
        } else {
            $results[] = [$level, $title, $link];
            
        }
    }
    return $results;
}

// 実行
$data = scanFiles($dir);

// CSVファイルとして保存
$fp = fopen($csvFile, 'w');
foreach ($data as $line) {
    fputcsv($fp, $line);
}
fclose($fp);

echo "index.csv の生成が完了しました！";
?>