<?php

namespace hrzg\resque\models;

use hrzg\resque\components\QueueCommand;
use Yii;

class QueueForm extends \yii\base\Model
{
    public $queue;
    public $job = [];
    public $command = 'yii';
    public $params = '{}';

    private $_jobId;

    public function rules()
    {
        return [
            [['job', 'queue', 'command', 'params'], 'required'],
        ];
    }

    /**
     * @return bool
     */
    public function sendJobToQueue()
    {

        var_dump($this->attributes);exit;

        if ($this->validate()) {
            $this->_jobId = Yii::$app->queue->push(new QueueCommand([
                'command' => $this->command,
                // Only set session id if session exists
                'sessionId' => Yii::$app->has('session') ? Yii::$app->getSession()->getId() : null
            ]));
            // If push returns a valid job id, the queue is working on the job
            if (!is_null($this->_jobId)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return string|null
     */
    public function getJobId()
    {
        return $this->_jobId;
    }


}
