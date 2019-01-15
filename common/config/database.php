<?php
// db config
return [
	'db' => [
		'class' => 'yii\db\Connection',
		// master
		'dsn' => 'mysql:host=127.0.0.1;dbname=jujube',
		'username' => 'root',
		'password' => 'nimabi1989',
		'charset' => 'utf8mb4',
		'tablePrefix' => 'j_',
		// slave
		'slaveConfig' => [
			'username' => 'root',
			'password' => 'nimabi1989',
			'charset' => 'utf8mb4',
			'tablePrefix' => 'j_',
			'attributes' => [
				// 使用更小的链接超时
				PDO::ATTR_TIMEOUT => 10,
			],
		],
		// slave config
		'slaves' => [
			['dsn' => 'mysql:host=127.0.0.1;dbname=jujube'],
		],
	],
];
