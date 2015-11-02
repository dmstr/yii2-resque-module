<?php

namespace hrzg\resque\models;

class QueueForm extends \yii\base\Model
{
    public $queue;
    public $job = [];
    public $payload;


    public function rules()
    {
        return [
            [['job','queue', 'payload'], 'required'],
        ];
    }

}
