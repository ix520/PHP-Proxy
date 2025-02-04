<?php
// 获取 URL 参数
$url_path = isset($_GET['url']) ? $_GET['url'] : '';

if (empty($url_path)) {
    die("请使用正确的路径格式");
}

// 构建完整的目标 URL
$url = 'https://cdn.jsdelivr.net/' . $url_path;

// 获取文件扩展名
$file_extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);

// 根据扩展名判断 `Content-Type`
$content_types = [
    'html' => 'text/html',
    'htm' => 'text/html',
    'css' => 'text/css',
    'js' => 'application/javascript',
    'json' => 'application/json',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
    'svg' => 'image/svg+xml',
    'txt' => 'text/plain',
];

$content_type = $content_types[$file_extension] ?? 'application/octet-stream';

// **重点修改**：只有文件时才设置 `Content-Type`，如果是目录请求，则不处理 `Content-Type`
if (!empty($file_extension)) {
    header('Content-Type: ' . $content_type . '; charset=utf-8');
}

// 使用 cURL 获取远程资源
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

if (isset($_SERVER['HTTP_REFERER'])) {
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
}

$data_down = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$content_type_remote = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

// **重点修改**：如果是 HTML 类型但没有文件扩展名，则手动设置 `Content-Type`
if (empty($file_extension) && strpos($content_type_remote, 'text/html') !== false) {
    header('Content-Type: text/html; charset=utf-8');
}

// 直接输出内容
echo $data_down;
?>
