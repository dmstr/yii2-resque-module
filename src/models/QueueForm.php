<?php

namespace hrzg\resque\models;

class QueueForm extends \yii\base\Model
{
    public $queue;
    public $job = [];
    public $command = 'yii';
    public $params = '{}';

    public function rules()
    {
        return [
            [['job', 'queue', 'command', 'params'], 'required'],
        ];
    }

}
