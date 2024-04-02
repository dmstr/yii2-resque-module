<?php

namespace hrzg\resque;

use dmstr\web\traits\AccessBehaviorTrait;
use yii\di\Instance;

class Module extends \yii\base\Module
{
    use AccessBehaviorTrait;

    public $defaultRoute = 'manage';

    /**
     * Name of the queue component
     *
     * @see \yii\queue\Queue
     */
    public $queue = 'queue';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Instance::ensure($this->queue, 'yii\queue\Queue');
    }
}
