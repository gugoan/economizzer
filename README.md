![Screen](https://raw.github.com/gugoan/economizzer/master/web/images/favicon-32x32.png) Economizzer
[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com)
=================================

Economizzer is a simple and open source personal finance manager system made in PHP [Yii Framework 2](http://www.yiiframework.com).

It is available in the following languages:  English, Spanish, Portuguese, Russian, Korean, Hungarian and French.

![Screen](https://raw.github.com/gugoan/economizzer/master/web/images/screen.png)

Learn more the features on the official website: [www.economizzer.org](http://www.economizzer.org)

Features
------------
- View monthly revenue and expenses
- Analyze annual performance via monthly trends
- Create expense categories freely
- Input entries into a digital ledger
- Upload billing documents to go alongside entries

Pages
------------
||
|:--:| 
| *The dashboard page allows you to see a general overview of your finances through graphs and charts. Clicking on "Select Dashboard" on the top left allows you to view more in-depth analyses.* |
| ![Screen](https://github.com/FreeedTheDolfin/economizzer/blob/c9aa46f0754074b49df4805326cacc6aacf91661/opensource_ss1.png) |
| *The graph that appears after clicking on "Annual Performance" in the "Select Dashboard" dropdown menu. This shows monthly revenue and expenses over a year.* |
| ![Screen](https://github.com/FreeedTheDolfin/economizzer/blob/c9aa46f0754074b49df4805326cacc6aacf91661/opensource_ss5.png) |
| *The entries page shows a ledger of all income and expenses with an optional description and attached file. Filters can be applied to view only specific entries.* |
| ![Screen](https://github.com/FreeedTheDolfin/economizzer/blob/c9aa46f0754074b49df4805326cacc6aacf91661/opensource_ss2.png) |
| *The categories page allows you to set custom categories for income and expenses, which can then be used to organize the values into graphs and such.* |
| ![Screen](https://github.com/FreeedTheDolfin/economizzer/blob/c9aa46f0754074b49df4805326cacc6aacf91661/opensource_ss3.png) |
| *The profile page allows users to change their display name, language, and default home page (either the dashboard or entries page)* |
| ![Screen](https://github.com/FreeedTheDolfin/economizzer/blob/c9aa46f0754074b49df4805326cacc6aacf91661/opensource_ss4.png) |

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
    'username' => 'USER',
    'password' => 'PASSWORD',
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
