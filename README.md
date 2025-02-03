起因是 jsdelivr 现在在国内并不友好，也不想用网上找的镜像链接，找的很多代理源码也不怎么好用或者不能用，所以就出了现在的教程，和非常简单的代码。
本期使用 serv00 无图教程演示，其他虚拟主机同理。
首先下载源码:
(github)[https://github.com/ix520/PHP-Proxy]

<details class="custom-block details" style="display: block; position: relative; border-radius: 2px; margin: 1.6em 0px; padding: 1.6em; background-color: rgb(238, 238, 238); color: rgb(44, 62, 80); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;"><summary style="outline: none; cursor: pointer;">或者这里复制</summary><pre><code class="language-cpp">
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

</code></pre></details>

<details class="custom-block details" style="display: block; position: relative; border-radius: 2px; margin: 1.6em 0px; padding: 1.6em; background-color: rgb(238, 238, 238); color: rgb(44, 62, 80); font-family: -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, &quot;Helvetica Neue&quot;, sans-serif; font-size: 16px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; letter-spacing: normal; orphans: 2; text-align: start; text-indent: 0px; text-transform: none; white-space: normal; widows: 2; word-spacing: 0px; -webkit-text-stroke-width: 0px; text-decoration-thickness: initial; text-decoration-style: initial; text-decoration-color: initial;"><summary style="outline: none; cursor: pointer;">伪静态</summary><pre><code class="language-cpp">
RewriteEngine On
RewriteRule ^(.*)$ index.php?url=$1 [L,QSA]
</code></pre></details>

下载好源码，把 .htaccess 与 index.php 上传到 serv00 或虚拟主机的目录，就可以通过你的域名进行访问了。
例如原链接是(https://cdn.jsdelivr.net/gh/ix520/images/1719927899066.jpg)[https://cdn.jsdelivr.net/gh/ix520/images/1719927899066.jpg]
把 https://cdn.jsdelivr.net/ 替换为你的域名
现在就可以通过 http(s)://你的域名/gh/ix520/images/1719927899066.jpg 来进行访问。

示例:(https://api.lovenan.me/cdn/gh/ix520/images/1719927899066.jpg)[https://api.lovenan.me/cdn/gh/ix520/images/1719927899066.jpg]

如果你无法配置伪静态，就像有的虚拟主机不支持，你也可以通过 ?url= 参数来访问，
示例:(https://api.lovenan.me/cdn/?url=gh/ix520/images/1719927899066.jpg)[https://api.lovenan.me/cdn/?url=gh/ix520/images/1719927899066.jpg]
同理，你也可以把源码里面的链接替换成其他链接，如 github ，这样就可以代理 github 了。
也可以有更多玩法，例如 github 下载加速等。
好了，这个稀里糊涂的教程就到这里了。
