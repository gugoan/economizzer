![Screen](https://raw.github.com/gugoan/economizzer/master/web/images/favicon-32x32.png) Economizzer
=================================

Economizzer is a simple and open source personal finance manager system made in PHP [Yii Framework 2](http://www.yiiframework.com).

It is available in the following languages:  English, Spanish, Portuguese, Russian, Korean, Hungarian and French.

![Screen](https://raw.github.com/gugoan/economizzer/master/web/images/screen.png)

Learn more the features on the official website: [www.economizzer.org](http://www.economizzer.org)


Live Demo
------------

You can try: [www.economizzer.org/web](http://www.economizzer.org/web)

> Use the user "joe" and password "123456".


Requirements
------------

The minimum requirement by this application that your Web server supports PHP 5.4.0 and either apache2 or nginx.

> Required libraries: libapache2-mod-php, php-mbstring, php-xml, php-curl


Installation
------------
~~~
git clone https://github.com/gugoan/economizzer.git
cd economizzer
composer install
~~~


Configuration
-------------

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

And import the database sql file

> economizzer.sql


To test, go to **http://yourserver/economizzer/web** with user and password below:

> Use the user "joe" and password "123456".


Contribution
-------------
Please see [CONTRIBUTING](CONTRIBUTING.md).


License
-------------
Economizzer is Copyright © 2014 Gustavo G. Andrade. 
It is free software, and may be redistributed under the terms specified in the
[LICENSE](LICENSE.md) file.


Donations
-------------
To encourage the developer with new enhancements, [web hosting](http://www.economizzer.org/web/) costs, or even to buy him a good beer, support the project by making a [donation](http://www.economizzer.org/donation.html).


Thanks to
-------------
[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com)
