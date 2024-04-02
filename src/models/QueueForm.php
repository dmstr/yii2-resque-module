<?php

namespace hrzg\resque\models;

use hrzg\resque\components\QueueCommand;
use Yii;
use yii\base\Model;

/**
 * @property-read null|string $jobId
 */
class QueueForm extends Model
{
    public $command = 'yii';
    private $_jobId;

    public function rules()
    {
        return [
            ['command', 'required']
        ];
    }

    /**
     * @return bool
     */
    public function sendJobToQueue()
    {
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
