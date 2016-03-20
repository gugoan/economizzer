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

~~~
git clone https://github.com/gugoan/economizzer.git
cd economizzer
composer global require "fxp/composer-asset-plugin:~1.1.1"
composer install
~~~


Configuration
-------------

Create the **economizzer** database and import the file **economizzer.sql**.

In folder **economizzer/config/db.php** set as follows:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=127.0.0.1;dbname=economizzer',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'enableSchemaCache' => true,
];
```

To test, go to **http://yourserver/economizzer/web** with user and password below:

User: joe

Pass: 123456


Contribution
-------------

Please see [CONTRIBUTING.md](CONTRIBUTING.md).


License
-------------

Economizzer is Copyright © 2008-2014 Gustavo G. Andrade. 
It is free software, and may be redistributed under the terms specified in the
[LICENSE](LICENSE.md) file.


Badges
-------------

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)
[![pledgie](https://pledgie.com/campaigns/30857.png?skin_name=chrome)](https://pledgie.com/campaigns/30857/)
