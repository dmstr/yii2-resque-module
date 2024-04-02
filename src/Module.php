<?php

namespace hrzg\resque;

use dmstr\web\traits\AccessBehaviorTrait;

class Module extends \yii\base\Module
{
    use AccessBehaviorTrait;

    public $defaultRoute = 'manage';
}
