<?php

namespace hrzg\resque\components;

use mikehaertl\shellcommand\Command;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\web\Session;

class QueueCommand extends BaseObject implements JobInterface
{
    public $command;
    public $sessionId;

    public function execute($queue)
    {
        // user session
        $session = Yii::$app->get('session', false);
        $hasSession = $session instanceof Session;

        if ($hasSession) {
            $session->setId($this->sessionId);
            $session->flashParam = '__flash';
            $session->addFlash('info', 'Job started...');
            $session->close();
        }

        // extract command
        $command = new Command($this->command);

        if ($command->execute()) {
            $output = $command->getOutput();
            Yii::info($output, __METHOD__);
            $flashType = 'success';
        } else {
            $output = $command->getError();
            Yii::error($output, __METHOD__);
            trigger_error($output);
            $flashType = 'warning';
        }
        if ($hasSession) {
            $session->addFlash($flashType, 'Job completed');
        }

        echo $output;

        if ($hasSession) {
            $session->close();
        }

        // flush logs, eg. db
        if (Yii::$app->has('log')) {
            Yii::$app->getLog()->getLogger()->flush(true);
        }

        return $output;
    }
}
