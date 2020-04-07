# laravel-rsa
基于laravel框架封装RSA算法类

#### 简介
这人比较懒，懒得写了。。。。

#### 环境条件
 - PHP >= 7.2
 - laravel/Lumen >= 5.7
 - 开启php的openssl扩展

#### 安装
```composer
    composer require xiaowu/laravel-rsa
```

#### config
生成`config/lararsa.php`配置文件。
```php
    php artisan lararsa:config
```
#### 使用
```php
    $data = '待处理数据';
   
    方式一：
    $sign = LaraRsa::createdSign($data);                // 生成签名

    $result = LaraRsa::verifySign($data, $sign);        // 验证签名
    
    $result = LaraRsa::encrypt($data);                  // 加密

    $result = LaraRsa::decrypt($data);                  // 解密
    
    方式二：
    $LaraRsa = new LaraRsa();

    $sign = $LaraRsa->createdSign($data);                // 生成签名

    $result = $LaraRsa->verifySign($data, $sign);        // 验证签名
    
    $result = $LaraRsa->encrypt($data);                  // 加密

    $result = $LaraRsa->decrypt($data);                  // 解密

```

#### 异常处理
异常类：`RsaKeyException.php`。

#### 更新
- 2020-03-14 create
- 2020-03-16 更新调用
- 2020-04-01 简单优化
- 2020-04-07 代码优化