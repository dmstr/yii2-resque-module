<?php
/**
 * @link http://www.diemeisterei.de/
 * @copyright Copyright (c) 2015 diemeisterei GmbH, Stuttgart
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace hrzg\resque\components;


use yii\helpers\StringHelper;

trait ResqueTrait
{
    private function enqueue($command)
    {
        $sessionId = \Yii::$app->session->id;
        $token = \Resque::enqueue(
            'default',
            'hrzg\resque\components\Job',
            [
                'command' => $command,
                'sessionId' => $sessionId,
                'logFile' => $this->resolveLogFile(),
            ],
            true
        );
        \Yii::$app->session->addFlash('success', "Job <code>$token</code> for <code>$sessionId</code> created.");
        $jobs = \Yii::$app->session->get('__jobs', []);
        $jobs[] = $token;
        \Yii::$app->session->set('__jobs', $jobs);
        return $token;
    }

    private function resolveLogFile()
    {
        @mkdir(\Yii::getAlias('@runtime/jobs'));
        $logDir = realpath(\Yii::getAlias('@runtime/jobs'));
        $logFile = $logDir . '/' . StringHelper::basename(self::className()) . '-' . $this->id . '.log';
        @chmod($logFile, 0666);
        return $logFile;

    }
}