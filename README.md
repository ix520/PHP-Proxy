起因是 jsdelivr 现在在国内并不友好，也不想用网上找的镜像链接，找的很多代理源码也不怎么好用或者不能用，所以就出了现在的教程，和非常简单的代码。
本期使用 serv00 无图教程演示，其他虚拟主机同理。
首先下载源码:
[GitHub](https://github.com/ix520/PHP-Proxy)
[GitHub 直接下载](https://github.com/ix520/PHP-Proxy/archive/refs/heads/main.zip)
[通过本教程代理的GitHub直接下载](https://api.lovenan.me/git/ix520/PHP-Proxy/archive/refs/heads/main.zip)

下载好源码，把 .htaccess 与 index.php 上传到 serv00 或虚拟主机的目录，就可以通过你的域名进行访问了。
例如原链接是[https://cdn.jsdelivr.net/gh/ix520/images/1719927899066.jpg](https://cdn.jsdelivr.net/gh/ix520/images/1719927899066.jpg)
把 https://cdn.jsdelivr.net/ 替换为你的域名
现在就可以通过 http(s)://你的域名/gh/ix520/images/1719927899066.jpg 来进行访问。

示例:[https://api.lovenan.me/cdn/gh/ix520/images/1719927899066.jpg](https://api.lovenan.me/cdn/gh/ix520/images/1719927899066.jpg)

如果你无法配置伪静态，就像有的虚拟主机不支持，你也可以通过 ?url= 参数来访问，
示例:[https://api.lovenan.me/cdn/?url=gh/ix520/images/1719927899066.jpg](https://api.lovenan.me/cdn/?url=gh/ix520/images/1719927899066.jpg)
同理，你也可以把源码里面的链接替换成其他链接，如 github ，这样就可以代理 github 了。
也可以有更多玩法，例如 github 下载加速等。
好了，这个稀里糊涂的教程就到这里了。
