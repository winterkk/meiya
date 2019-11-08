<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,

    /* 上传文件 */
    'upload' => [
        //'path' => Yii::getAlias('@base/web/storage/image/'), // 服务器解析到/web/目录时，上传到这里
        'image' => Yii::getAlias('@storage/web/images/'),
        'file' => Yii::getAlias('@storage/web/files/'),
        'imageUrl' => Yii::getAlias('@storageUrl/'),
    ],

];
