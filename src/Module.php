<?php

namespace hrzg\resque;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'hrzg\resque\controllers';

    public function init()
    {
        parent::init();

        \Resque::setBackend(
            getenv('REDIS_PORT_6379_TCP_ADDR') . ':' .
            getenv('REDIS_PORT_6379_TCP_PORT')
        );

        // custom initialization code goes here
    }
}
