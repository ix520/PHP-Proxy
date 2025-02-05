<?php
// 获取 URL 参数
$url_path = isset($_GET['url']) ? $_GET['url'] : '';

if (empty($url_path)) {
    die("请使用正确的路径格式");
}

// 构建完整的目标 URL
$url = 'https://Github.com/' . $url_path;

// 获取文件扩展名
$file_extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);

// 根据扩展名判断 `Content-Type`
$content_types = [
    'html' => 'text/html', 'htm' => 'text/html', 'css' => 'text/css', 'js' => 'application/javascript',
    'json' => 'application/json', 'xml' => 'application/xml', 'csv' => 'text/csv', 'txt' => 'text/plain',
    'md' => 'text/markdown', 'yaml' => 'text/yaml', 'yml' => 'text/yaml', 'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif', 'svg' => 'image/svg+xml',
    'webp' => 'image/webp', 'ico' => 'image/vnd.microsoft.icon', 'bmp' => 'image/bmp', 'tif' => 'image/tiff',
    'tiff' => 'image/tiff', 'avif' => 'image/avif', 'mp4' => 'video/mp4', 'webm' => 'video/webm',
    'ogg' => 'video/ogg', 'ogv' => 'video/ogg', 'mov' => 'video/quicktime', 'avi' => 'video/x-msvideo',
    'flv' => 'video/x-flv', 'mkv' => 'video/x-matroska', 'wmv' => 'video/x-ms-wmv', 'mp3' => 'audio/mpeg',
    'wav' => 'audio/wav', 'flac' => 'audio/flac', 'aac' => 'audio/aac', 'oga' => 'audio/ogg', 'opus' => 'audio/opus',
    'm4a' => 'audio/mp4', 'woff' => 'font/woff', 'woff2' => 'font/woff2', 'ttf' => 'font/ttf',
    'otf' => 'font/otf', 'eot' => 'application/vnd.ms-fontobject', 'pdf' => 'application/pdf',
    'doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'ppt' => 'application/vnd.ms-powerpoint', 'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'xls' => 'application/vnd.ms-excel', 'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'zip' => 'application/zip', 'rar' => 'application/vnd.rar', '7z' => 'application/x-7z-compressed',
    'tar' => 'application/x-tar', 'gz' => 'application/gzip', 'bz2' => 'application/x-bzip2',
    'xz' => 'application/x-xz', 'apk' => 'application/vnd.android.package-archive', 'exe' => 'application/octet-stream',
    'msi' => 'application/octet-stream', 'bat' => 'application/x-msdownload', 'sh' => 'application/x-sh',
    'bin' => 'application/octet-stream', 'rtf' => 'application/rtf', 'wasm' => 'application/wasm'
];

// **使用 cURL 获取远程资源**
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
//自定义Referer解决防盗链问题，如pixiv
$custom_referer = ""; // 自定义的 Referer 值

if (!empty($custom_referer)) {
    // 如果自定义的 Referer 不为空，则使用自定义的 Referer
    curl_setopt($ch, CURLOPT_REFERER, $custom_referer);
} elseif (isset($_SERVER['HTTP_REFERER'])) {
    // 如果自定义的 Referer 为空，但当前请求有 Referer，则使用当前请求的 Referer
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
}


$data_down = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$content_type_remote = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
curl_close($ch);

// **自动获取 `Content-Type` 逻辑**
if (!empty($content_type_remote)) {
    // 如果远程服务器返回了 `Content-Type`，则使用
    header("Content-Type: $content_type_remote");
} else {
    // 远程 `Content-Type` 为空，则回退到本地匹配
    $content_type = $content_types[$file_extension] ?? 'application/octet-stream';
    header("Content-Type: $content_type");
}
/*
// 使用本地Content-Type 仅根据扩展名匹配 `Content-Type`
$content_type = $content_types[$file_extension] ?? 'application/octet-stream';
header("Content-Type: $content_type");
*/

// 直接输出内容
echo $data_down;
?>
