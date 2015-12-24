![Screen](https://raw.github.com/gugoan/economizzer/master/web/images/favicon-32x32.png) Economizzer
=================================

Economizzer is a simple and open source personal finance manager system made in PHP (Yii Framework 2.0).

It is available in the following languages: **English**, **Brazilian Portuguese** and **Russian**.

![Screen](https://raw.github.com/gugoan/economizzer/master/web/images/screen.png)



Requirements
------------

The minimum requirement by this application that your Web server supports PHP 5.4.0.


Installation
------------

### Composer way: 
~~~
git clone https://github.com/gugoan/economizzer.git
cd economizzer
composer require "fxp/composer-asset-plugin:~1.0"
~~~


Configuration
-------------

Create the **economizzer** database and import the file **economizzer.sql**.

In folder **economizzer/config/db.php**

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=economizzer',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'tablePrefix' => 'tb_',
    'enableSchemaCache' => true,
];
```

Access **http://economizzer/web** with user and password below:

User: joe

Pass: 123456


Contribution
-------------

Please see the documentation on Contribution.

-------------

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)
[![pledgie](https://pledgie.com/campaigns/30857.png?skin_name=chrome)](https://pledgie.com/campaigns/30857/)