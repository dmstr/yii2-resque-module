Resque job manager module for Yii 2.0 Framework
===============================================
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

