<?php

namespace hrzg\resque\components;

use dmstr\helpers\Html;
use mikehaertl\shellcommand\Command;
use yii\helpers\Json;
use yii\helpers\VarDumper;

class Job
{

    public function perform()
    {
        \Yii::info($this->args, __METHOD__);

        // user session
        \Yii::$app->session->setId($this->args['sessionId']);
        \Yii::$app->session->flashParam = '__flash';
        $shortId = substr($this->job->payload['id'],0,6);
        \Yii::$app->session->addFlash('info',"Job <b>{$shortId}</b> started on worker {$this->job->worker->__toString()}...");
        #\Yii::$app->session->addFlash('info',VarDumper::dumpAsString($this->job->payload, 4, true));
        \Yii::$app->session->close();

        // prepare logging
        $logDir = \Yii::getAlias('@runtime/jobs');
        @mkdir($logDir, 0777, true);

        if (!isset($this->args['logFile'])) {
            $logFile = $logDir.'/default.log';
        } else {
            $logFile = $this->args['logFile'];
        }

        // extract command
        $c = $this->args['command'];
        unset($this->args['command']);
        $command = new Command($c);

        // output
        $output = "---JOB-$logFile---\n";
        $output .= VarDumper::export($this->args);
        $output .= "\n";
        file_put_contents($logFile, $output."\n", FILE_APPEND);

        if ($command->execute()) {
            \Yii::info('Done.', __METHOD__);
            $output .= $command->getOutput();
            \Yii::info($command->getOutput(), __METHOD__);
            $output .= "\nJob completed successfully.";
            $flashType = 'success';
        } else {
            \Yii::error($this->args, __METHOD__);
            \Yii::error($command->getError(), __METHOD__);
            $output .= $command->getError();
            $output .= "\nJob failed.";
            $flashType = 'warning';
        }

        // remove blank lines
        $output = '<p style="font-family: monospace">'.Html::encode(preg_replace('/\n{2,}/', "\n", $output)).'</p>';

        // file
        file_put_contents($logFile, $output."\n", FILE_APPEND);

        // user session
        \Yii::$app->session->setId($this->args['sessionId']);
        \Yii::$app->session->flashParam = '__flash';
        \Yii::$app->session->addFlash('trace',nl2br($output));
        \Yii::$app->session->addFlash($flashType,"Job <b>{$shortId}</b> completed on worker {$this->job->worker->__toString()}...");

        // stdout
        echo $output;

        // TODO: add possiblity to abort job; before enabling loop
        /*if ($this->args['loop']) {
            sleep($this->args['sleep']);
            \Yii::$app->session->addFlash('info',"Loop...".get_class($this));
            //\Yii::$app->session->addFlash('info',Json::encode($this->job->payload['args'][0]));
            \Resque::enqueue('default', get_class($this), $this->job->payload['args'][0]);
        }*/

        \Yii::$app->session->close();

        // flush logs, eg. db
        \Yii::$app->log->getLogger()->flush(true);
    }

}