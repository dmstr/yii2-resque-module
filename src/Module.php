<?php

namespace hrzg\resque;

use dmstr\web\traits\AccessBehaviorTrait;
use yii\base\Exception;

class Module extends \yii\base\Module
{
    use AccessBehaviorTrait;

    public $controllerNamespace = 'hrzg\resque\controllers';
    public $defaultRoute = 'manage';
}
