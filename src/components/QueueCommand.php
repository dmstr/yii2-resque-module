<?php

namespace hrzg\resque\components;

use bedezign\yii2\audit\Audit;
use dmstr\helpers\Html;
use mikehaertl\shellcommand\Command;
use yii\base\BaseObject;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\queue\JobInterface;

class QueueCommand extends BaseObject implements JobInterface
{
    public $command;
    public $sessionId;

    public function execute($queue)
    {
        // user session
        \Yii::$app->session->setId($this->sessionId);
        \Yii::$app->session->flashParam = '__flash';
        \Yii::$app->session->addFlash('info', "Job started...");
        \Yii::$app->session->close();

        // extract command
        $command = new Command($this->command);

        if ($command->execute()) {
            $output = $command->getOutput();
            \Yii::info($command->getOutput(), __METHOD__);
            $flashType = 'success';
        } else {
            \Yii::error($command->getError(), __METHOD__);
            $output = $command->getError();
            $flashType = 'warning';
            trigger_error($command->getError());
        }

        \Yii::$app->session->addFlash($flashType, "Job completed");

        echo $output;

        \Yii::$app->session->close();

        // flush logs, eg. db
        \Yii::$app->log->getLogger()->flush(true);

        return $output;
    }

}