<?php
// 指定要扫描的目录，这里以 '/assets/' 目录为例
$directoryName = '/assets/';
$directory = __DIR__ . DIRECTORY_SEPARATOR . $directoryName;

// 用于存储文件信息的数组
$fileList = [];

// 要排除的文件列表
$excludeFiles = ['index.html', 'scan.php', 'scan.js'];

// 检查目录是否存在
if (is_dir($directory)) {
    // 打开目录
    if ($dirHandle = opendir($directory)) {
        // 遍历目录中的每一项
        while (($file = readdir($dirHandle)) !== false) {
            // 排除当前目录和上一级目录的链接，以及特定的文件
            if ($file !== '.' && $file !== '..' && !in_array($file, $excludeFiles)) {
                // 构建文件的完整路径
                $filePath = $directory . DIRECTORY_SEPARATOR . $file;
                // 确保只列出文件，不列出目录
                if (is_file($filePath)) {
                    // 添加文件信息到数组中
                    $fileList[] = [
                        "name" => $file,
                        // 直接使用相对于网站根目录的路径
                        "url" => "/$directoryName/$file"
                    ];
                }
            }
        }
        // 关闭目录句柄
        closedir($dirHandle);
    } else {
        // 无法打开目录
        http_response_code(500);
        echo json_encode(["error" => "Unable to open directory."]);
        exit;
    }
} else {
    // 目录不存在
    http_response_code(404);
    echo json_encode(["error" => "Directory not found."]);
    exit;
}

// 设置响应头为JSON
header('Content-Type: application/json');
// 输出文件列表的JSON表示
echo json_encode($fileList);
?>
