<?php

namespace hrzg\resque;

use yii\base\Exception;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'hrzg\resque\controllers';
    public $defaultRoute = 'manage';

    public function init()
    {
        parent::init();

        if (empty(getenv('REDIS_PORT_6379_TCP_ADDR'))) {
            throw new Exception('Redis connection from environment variables (REDIS_PORT_6379_TCP_ADDR, REDIS_PORT_6379_TCP_PORT) not found.');
        }

    }
}
