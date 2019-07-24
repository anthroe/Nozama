<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
	'driver' => 'mysql',
	'host' => 'remotemysql.com',
	'username' => 'rbHgkgh6TE',
	'password' => 'KEBV9ao1ix',
	'database' => 'rbHgkgh6TE',
	'charset' => 'utf8',
	'collation' => 'utf8_unicode_ci',
	'prefix' => ''
]);

$capsule->bootEloquent();

?>