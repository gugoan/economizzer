![Screen](https://raw.github.com/gugoan/economizzer/master/web/images/favicon-32x32.png) Economizzer
[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com)
=================================

Economizzer is a simple and open source personal finance manager system made in PHP [Yii Framework 2](http://www.yiiframework.com).

It is available in the following languages:  English, Spanish, Portuguese, Russian, Korean, Hungarian and French.

![Screen](https://raw.github.com/gugoan/economizzer/master/web/images/screen.png)

Table of Contents
------------
1. [Features](#features)
2. [Pages](#pages)
3. [Live Demo](#demo)
4. [Requirements](#reqs)
5. [Installation](#installation)
6. [Configuration](#config)
7. [Contributions](#contribution)
8. [Troubleshooting](#troubleshooting)
9. [Licenses](#licenses)
10. [Donations](#donations)

Features <a id="features"></a>
------------
- View monthly revenue and expenses
- Analyze annual performance via monthly trends
- Create expense categories freely
- Input entries into a digital ledger
- Upload billing documents to go alongside entries

Learn more about the features on the official website: [www.economizzer.org](http://www.economizzer.org)

Pages <a id="pages"></a>
------------
||
|:--:| 
| The [dashboard page](https://github.com/FreeedTheDolfin/economizzer/tree/9daaf08a530d87cee92ff0f72187daa1701bd179/views/dashboard) allows you to see a general overview of your finances through graphs and charts. Clicking on "Select Dashboard" on the top left allows you to view more in-depth analyses. |
| ![Screen](https://github.com/FreeedTheDolfin/economizzer/blob/c9aa46f0754074b49df4805326cacc6aacf91661/opensource_ss1.png) |
| The graph that appears after clicking on "Annual Performance" in the "Select Dashboard" dropdown menu. This shows monthly revenue and expenses over a year. |
| ![Screen](https://github.com/FreeedTheDolfin/economizzer/blob/c9aa46f0754074b49df4805326cacc6aacf91661/opensource_ss5.png) |
| The [entries page](https://github.com/FreeedTheDolfin/economizzer/tree/9daaf08a530d87cee92ff0f72187daa1701bd179/views/cashbook) shows a ledger of all income and expenses with an optional description and attached file. Filters can be applied to view only specific entries. |
| ![Screen](https://github.com/FreeedTheDolfin/economizzer/blob/c9aa46f0754074b49df4805326cacc6aacf91661/opensource_ss2.png) |
| The [categories page](https://github.com/FreeedTheDolfin/economizzer/tree/9daaf08a530d87cee92ff0f72187daa1701bd179/views/category) allows you to set custom categories for income and expenses, which can then be used to organize the values into graphs and such. |
| ![Screen](https://github.com/FreeedTheDolfin/economizzer/blob/c9aa46f0754074b49df4805326cacc6aacf91661/opensource_ss3.png) |
| The [profile page](https://github.com/FreeedTheDolfin/economizzer/blob/9daaf08a530d87cee92ff0f72187daa1701bd179/views/user/profile.php) allows users to change their display name, language, and default home page (either the dashboard or entries page) |
| ![Screen](https://github.com/FreeedTheDolfin/economizzer/blob/c9aa46f0754074b49df4805326cacc6aacf91661/opensource_ss4.png) |

Live Demo <a id="demo"></a>
------------

You can try: [www.economizzer.org/web](http://www.economizzer.org/web)

> Use the user "joe" and password "123456".


Requirements <a id="reqs"></a>
------------

The minimum requirement by this application that your Web server supports PHP 5.4.0 and either apache2 or nginx.

> Required libraries: libapache2-mod-php, php-mbstring, php-xml, php-curl


Installation <a id="installation"></a>
------------
~~~
git clone https://github.com/gugoan/economizzer.git
cd economizzer
composer install
~~~


Configuration <a id="config"></a>
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


Contribution <a id="contribution"></a>
-------------
Please see [CONTRIBUTING](CONTRIBUTING.md).

Troubleshooting <a id="troubleshooting"></a>
-------------
If there are any problems with the application, please [open an issue](https://github.com/gugoan/economizzer/issues) on Github. For smaller issues, you can contact us on [Twitter](https://twitter.com/economizzer).

License <a id="licenses"></a>
-------------
Economizzer is Copyright © 2014 Gustavo G. Andrade. 
It is free software, and may be redistributed under the terms specified in the
[LICENSE](LICENSE.md) file.


Donations <a id="donations"></a>
-------------
To encourage the developer with new enhancements, [web hosting](http://www.economizzer.org/web/) costs, or even to buy him a good beer, support the project by making a [donation](http://www.economizzer.org/donation.html).
