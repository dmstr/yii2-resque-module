<?php

namespace hrzg\resque\components;

use mikehaertl\shellcommand\Command;
use yii\helpers\VarDumper;

class Job
{

    public function perform()
    {
        \Yii::info($this->args, __METHOD__);

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
        $output = '<p style="font-family: monospace">'.preg_replace('/\n{2,}/', "\n", $output).'</p>';

        // stdout
        echo $output;

        // file
        file_put_contents($logFile, $output."\n", FILE_APPEND);

        // user session
        \Yii::$app->session->setId($this->args['sessionId']);
        \Yii::$app->session->flashParam = '__flash';
        \Yii::$app->session->addFlash($flashType,nl2br($output));
        \Yii::$app->session->close();

        // flush logs, eg. db
        \Yii::$app->log->getLogger()->flush(true);
    }

}