<?php
// 默认放在storage文件下面
return [
    // 私钥文件
    "private_key_file"=>env("PRIVATE_KEY", "key/private_key.pem"),
    // 公钥文件
    "public_key_file"=>env("PUBLIC_KEY", "key/public_key.pem"),
];