<?php

namespace hrzg\resque\components;

use mikehaertl\shellcommand\Command;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class QueueCommand extends BaseObject implements JobInterface
{
    public $command;
    public $sessionId;

    public function execute($queue)
    {
        // user session
        $hasSession = Yii::$app->has('session');

        if ($hasSession) {
            $session = Yii::$app->getSession();

            $session->setId($this->sessionId);
            $session->flashParam = '__flash';
            $session->addFlash('info', 'Job started...');
            $session->close();
        }


        // extract command
        $command = new Command($this->command);

        if ($command->execute()) {
            $output = $command->getOutput();
            Yii::info($command->getOutput(), __METHOD__);
            $flashType = 'success';
        } else {
            Yii::error($command->getError(), __METHOD__);
            $output = $command->getError();
            $flashType = 'warning';
            trigger_error($command->getError());
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
