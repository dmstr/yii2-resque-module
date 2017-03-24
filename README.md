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
php composer.phar require --prefer-dist hrzg/yii2-resque-module "*"
```

or add

```
"hrzg/yii2-resque-module": "*"
```

to the require section of your `composer.json` file.


Setup
-----

Once the extension is installed, simply use it in your code by  :


Docker containers
```
redis:
  image: redis:3

appworker:
  build: .
  command: yii resque/work
  volumes:
    - '.:/app'
  links:
    - 'redis:REDIS'
    - 'mariadb:DB'
```

Module configuration
```php
'resque' => [
    'class' => 'hrzg\resque\Module',
    'layout' => '@admin-views/layouts/main',
]
```

