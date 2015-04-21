<?php

//php内置变量($_POST;$_GET;$_REQUEST;$_COOKIE;$_SESSION;$_SERVER)的使用


//一、$_POST     // 获取http_post请求的数据:
//$value_name = $_POST["input_name"];
//为了防止为空:
$value_name = (isset($_POST["input_name"])? trim($_POST["input_name"]) : "");
var_dump($_POST);
//备注：
//$_POST并非是HTTP POST过来的数据；
//如json格式的数据就没法接受，这是由于历史原因，PHP只能解析Content-Type为 application/x-www-form-urlencoded 或 multipart/form-data 的http请求，只不过现在json流行了，如下处理即可：
//$_POST = json_decode(file_get_contents('php://input'), true);


//二、$_GET      //获取http_get请求的数据:
//$value_name = $_GET["input_name"];
//为了防止为空:
$value_name = (isset($_GET["input_name"])? trim($_GET["input_name"]) : "");
var_dump($_GET);


//三、$_REQUEST   //默认情况下包含了 $_GET，$_POST 和 $_COOKIE 的数组。
var_dump($_REQUEST);

//四、$_COOKIE      
//通过 HTTP Cookies 方式传递给当前脚本的变量的数组，cookie在http头部，存放在客户端(由于http是无状态的，所以可以通过cookie记录之前状态信息)。

//如何创建 cookie？                                   
//setcookie()   //设置 cookie。 注释：setcookie() 函数必须位于 <html> 标签之前。 
//语法：setcookie(name, value, expire, path, domain);
//例子：在下面的例子中，我们将创建名为 "user" 的 cookie，把为它赋值 "Alex Porter"。我们也规定了此 cookie 在一小时后过期：
setcookie("user", "Alex Porter", time()+3600);
//<html> <body></body> </html>
//注释：在发送 cookie 时，cookie 的值会自动进行 URL 编码，在取回时进行自动解码（为防止 URL 编码，请使用 setrawcookie() 取而代之，setrawcookie() 函数不对 cookie 值进行 URL 编码，发送一个 HTTP cookie）。

//如何删除 cookie？
//当删除 cookie 时，您应当使过期日期变更为过去的时间点或0。
//删除的例子：
setcookie("user", "", time()-3600);

//如何取回 Cookie 的值？
//PHP 的 $_COOKIE 变量用于取回 cookie 的值。 在下面的例子中，我们取回了名为 "user" 的 cookie 的值，并把它显示在了页面上：
echo $_COOKIE["user"];
print_r($_COOKIE);

//在下面的例子中，我们使用 isset() 函数来确认是否已设置了 cookie：
if (isset($_COOKIE["user"])) {
    echo "Welcome " . $_COOKIE["user"] . "\n";
} else {
    echo "Welcome guest";
}

//五、$_SESSION      
//通过SESSION方式传递给当前脚本的变量的数组，session记录在服务端。
var_dump($_SESSION);

//六、$_SERVER          
//包含了诸如: 头信息(header)、路径(path)、以及脚本位置(script locations)等等信息的数组，这个数组中的项目由 Web 服务器创建。

//'SERVER_ADDR'             当前运行脚本所在的服务器的 IP 地址。 
//'SERVER_PORT'             当前运行脚本所在的服务器的 PORT。 
//'SERVER_NAME'             当前运行脚本所在的服务器的主机名。如果脚本运行于虚拟主机中，该名称是由那个虚拟主机所设置的值决定。 
//'SERVER_SOFTWARE'         服务器标识字符串，在响应请求时的头信息中给出。 
//'SERVER_PROTOCOL'         请求页面时通信协议的名称和版本。例如，“HTTP/1.0”。 
//'REQUEST_METHOD'          访问页面使用的请求方法；例如，“GET”, “HEAD”，“POST”，“PUT”。
//'REQUEST_TIME'            请求开始时的时间戳。从 PHP 5.1.0 起可用。 
//'QUERY_STRING'            query string（查询字符串），如果有的话，通过它进行页面访问(http通过GET放是访问时带进来的参数)。 
//'DOCUMENT_ROOT'           当前运行脚本所在的文档根目录。在服务器配置文件中定义。 
//'HTTP_ACCEPT'             当前请求头中 Accept: 项的内容，如果存在的话。 
//'HTTP_ACCEPT_CHARSET'     当前请求头中 Accept-Charset: 项的内容，如果存在的话。例如：“iso-8859-1,*,utf-8”。 
//'HTTP_ACCEPT_ENCODING'    当前请求头中 Accept-Encoding: 项的内容，如果存在的话。例如：“gzip”。  'HTTP_ACCEPT_LANGUAGE' 当前请求头中 Accept-Language: 项的内容，如果存在的话。例如：“en”。 
//'HTTP_CONNECTION'         当前请求头中 Connection: 项的内容，如果存在的话。例如：“Keep-Alive”。 
//'HTTP_HOST'               当前请求头中 Host: 项的内容，如果存在的话。 
//'HTTP_REFERER'            引导用户代理到当前页的前一页的地址（如果存在）。curl -e xxxx  http://localhost/index.html         // -e 设定REFERER
//'HTTP_USER_AGENT'         当前请求头中 User-Agent: 项的内容，如果存在的话。该字符串表明了访问该页面的用户代理的信息。一个典型的例子是：Mozilla/4.5 [en] (X11; U; Linux 2.2.9 i586)。除此之外，你可以通过 get_browser() 来使用该值，从而定制页面输出以便适应用户代理的性能。       curl -A 'Mozilla/4.5 [en] (X11; U; Linux 2.2.9 i586)'  http://localhost/index.html   // -A 设定USER_AGENT
//'REQUEST_URI'              URI 用来指定要访问的页面。例如 “/index.html”。
//'REMOTE_ADDR'              浏览当前页面的用户的 IP 地址。  (获取客户端IP靠谱方法：http://www.coridc.com/archives/2122.html)
//'REMOTE_HOST'              浏览当前页面的用户的主机名。DNS 反向解析不依赖于用户的 REMOTE_ADDR。 
//'HTTPS'                    如果脚本是通过 HTTPS 协议被访问，则被设为一个非空的值。 
//'REMOTE_PORT'              用户机器上连接到 Web 服务器所使用的端口号。 
//'SCRIPT_FILENAME'          当前执行脚本的绝对路径。
//'SCRIPT_NAME'              包含当前脚本的路径。这在页面需要指向自己时非常有用。__FILE__ 常量包含当前脚本(例如包含文件)的完整路径和文件名。 

var_dump($_SERVER);


?>
