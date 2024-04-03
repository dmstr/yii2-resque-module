<?php

namespace hrzg\resque\models;

use hrzg\resque\components\QueueCommand;
use Yii;
use yii\base\Model;
use yii\queue\Queue;

/**
 * @property-read null|string $jobId
 */
class QueueForm extends Model
{
    public $command = 'yii';
    private $_jobId;
    private Queue $_queue;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [
            'command',
            'required'
        ];
        $rules[] = [
            'command',
            'string',
            'max' => 200
        ];
        return $rules;
    }

    /**
     * @return bool
     */
    public function sendJobToQueue()
    {
        if ($this->validate()) {
            $this->_jobId = $this->_queue->push(new QueueCommand([
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

    public function setQueue(Queue $queue): void
    {
        $this->_queue = $queue;
    }

    /**
     * @return string|null
     */
    public function getJobId()
    {
        return $this->_jobId;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['command'] = Yii::t('resque', 'Command');
        return $attributeLabels;
    }
}
