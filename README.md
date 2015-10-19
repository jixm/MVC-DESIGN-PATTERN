#READEME
@[local]

**一个简单的MVC框架,代码逻辑很简单,主要是回顾下MVC的思想逻辑.简单说一下需要注意的点**

[TOC]


###目录结构
>Public
		>>project_name
			>>>index.php  入口文件
			 >>>.htaccess   重写规则
			 
>Application
>>project_name
>>>Controller
>>>Model
>>>Module 

>Config
>>project_name.inc.php  对应项目的配置文件

>Library  本地类库,自动加载
>System  核心类库
>Views    视图

###入口文件

```
define('PUBLIC_PATH',__DIR__);      //当前项目入口路径

define('SITE','Demo');              //定义项目名,必须

require_once  '../../Autoload.php'; //加载类

require_once  '../../setting.php';  //常量定义,其他设置

new System\Core\Bootstrap();

```
###重写规则
```
server {
  listen ****;
  server_name  domain.com;
  root   document_root;
  index  index.php index.html index.htm;

  if (!-e $request_filename) {
    rewrite ^/(.*)  /index.php/$1 last;
  }

```

###配置文件
>Demo.inc.php 为数组形式做配置文件,命名方式:项目名.inc.php
>Database.inc.php 数据库配置文件为共用
>以上两个数组都会整合到统一静态变量形式存放,如下

```
Y::get($name)  //$name为空返回整个配置数组,不为空返回对应key的值
```

###控制器
####GET,POST参数获取
####Model调用
####数据库连接

###视图文件

###运行

###Tips
		





