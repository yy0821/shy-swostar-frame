# shy-swostar-frame
基于swoole的简易服务器框架

## 安装
路由服务器下载地址 
```shell
composer create-project shy/swocloud:dev-master swocloud
```
框架下载地址 
```shell
composer create-project shy/swostar-frame:dev-master swostar-frame
```

## 应用
配置服务器信息
```php
config/server.php
```

首先启动路由服务器 
```php
php bin/swocloud
```

在启动IM服务器
http服务器
```php
php bin/swostar http
```
webSocket服务器
```php
php bin/swostar ws
```

## 目录结构
www  部署目录（或者子目录）\
├─app           应用目录\
│  ├─Http             HTTP服务\
│  │  ├─Controllers   控制器\
│  ├─WebSocket        WebSocket服务\
│  │  ├─Controllers   控制器\
│  ├─Listeners        监听事件\
│\
├─bin                 启动目录\
│  ├─swostar          启动服务入口\
│\
├─common              公共目录\
│  ├─common.php       公共函数文件\
│\
├─config              配置文件目录\
│  ├─database.php     数据库配置文件\
│  ├─server.php       服务器配置文件\
│\
├─route               路由文件目录\
│  ├─http.php         http路由\
│  ├─webSocket.php    webSocket路由\
│\
├─tests               测试目录\
