<?php
// 获取 URL 参数
$url_path = isset($_GET['url']) ? $_GET['url'] : '';

if (empty($url_path)) {
    die("请使用正确的路径格式");
}

// 构建完整的目标 URL
$url = 'https://cdn.jsdelivr.net/' . $url_path;

// 设置响应头部
header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: inline; filename="' . basename($url) . '"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');

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
if ($data_down === false) {
    die("代理时发生错误");
}

curl_close($ch);

// 直接输出内容
echo $data_down;
?>
