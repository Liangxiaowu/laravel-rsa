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
生成`lararsa.php`配置文件。
```php
    php artisan lararsa:config

    return [
        /*
         * 目前文件只支持存放storage/app下面
         */
        "private_key_file"=>"key/private_key.pem",  // 私钥地址
        "public_key_file"=>"key/public_key.pem",    // 公钥地址
    ];

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
目前只有一个异常类`RsaKeyException`，你可以通以下方式处理异常类的返回。
- 方式一：调用的时候处理。
```php
     try{
         // 程序体
     }catch (RsaKeyException $exception){
         return [
             "status_code"=>500,
             "message"=>$exception->getMessage()
         ];
     }
```
- 方式二：全局处理，需要在项目的`app/Exceptions/Handler.php`文件里的`render`方法加入以下代码。
```php
    public function render($request, Exception $exception)
    {
        if ($exception instanceof RsaKeyException)  {
            return $exception->render($request);
        }
        return parent::render($request, $exception);
    }
```

#### 更新
- 2020-03-14 create
- 2020-03-16 更新调用

