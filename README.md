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

### 应用
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
