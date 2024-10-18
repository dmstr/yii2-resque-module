Resque job manager module for Yii 2.0 Framework
===============================================

[![Latest Stable Version](https://poser.pugx.org/dmstr/yii2-resque-module/v/stable.svg)](https://packagist.org/packages/dmstr/yii2-resque-module) 
[![Total Downloads](https://poser.pugx.org/dmstr/yii2-resque-module/downloads.svg)](https://packagist.org/packages/dmstr/yii2-resque-module)
[![License](https://poser.pugx.org/dmstr/yii2-resque-module/license.svg)](https://packagist.org/packages/dmstr/yii2-resque-module)


Resque job manager module with backend UI

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist hrzg/yii2-resque-module "*"
```

or add

```
"hrzg/yii2-resque-module": "*"
```

to the require section of your `composer.json` file.


Setup
-----

Module configuration
```php
'resque' => [
    'class' => 'hrzg\resque\Module',
    'layout' => '@admin-views/layouts/main',
]
```

