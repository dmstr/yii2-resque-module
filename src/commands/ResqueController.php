<?php

namespace hrzg\resque\commands;

use yii\console\Controller;
use yii\helpers\Json;

/**
 * Class ResqueController
 * @package app\commands
 *
 * docker-compose run cli \
 *  ./yii resque/enqueue default app\\commands\\ImportJob '{"modelNames":"Article","offset":"20000","andWhere":"Hersteller_ID=4"}'
 *
 */
class ResqueController extends Controller
{
    public $defaultAction = 'status';

    public function beforeAction($action)
    {
        \Resque::setBackend(
            getenv('REDIS_PORT_6379_TCP_ADDR') . ':' .
            getenv('REDIS_PORT_6379_TCP_PORT')
        );
        return parent::beforeAction($action);
    }

    public function actionStatus()
    {
        $this->stdout("Queues\n");
        foreach (\Resque::queues() as $name) {
            $this->stdout("$name\n");
        }
        $this->stdout("\n");

        $this->stdout("Workers\n");
        foreach (\Resque_Worker::all() as $worker) {
            $this->stdout($worker);
            $this->stdout("\n");
        }

        $this->stdout("\n");
    }

    public function actionDebug()
    {
        $this->stdout("Queues\n");
        var_dump(\Resque::queues());

        $this->stdout("Workers\n");
        var_dump(\Resque_Worker::all());
        var_dump(\Resque::redis()->smembers('workers'));

        echo "xx";
        #var_dump(\Resque_Worker::find($worker));
    }

    public function actionInspect($worker)
    {
        var_dump(\Resque_Worker::find($worker));
    }

    public function actionEnqueue($queue = 'default', $job, $json)
    {
        #var_dump($json);exit;
        $args = Json::decode($json);

        $this->stdout("Enqueueing job...\n");
        // Required if redis is located elsewhere
        \Resque::setBackend(
            getenv('REDIS_PORT_6379_TCP_ADDR') . ':' .
            getenv('REDIS_PORT_6379_TCP_PORT')
        );

        $token = \Resque::enqueue('default', $job, $args);
        $this->stdout("{$token}\n");

        $this->stdout("Done.\n");
    }

    public function actionWork($queue = 'default')
    {
        if (empty($queue)) {
            die("Set QUEUE env var containing the list of queues to work.\n");
        }

        $logLevel = 0;
        $LOGGING  = getenv('RESQUE_LOGGING');
        $VERBOSE  = getenv('RESQUE_VERBOSE');
        $VVERBOSE = getenv('RESQUE_VVERBOSE');
        if (!empty($LOGGING) || !empty($VERBOSE)) {
            $logLevel = \Resque_Worker::LOG_NORMAL;
        } else {
            if (!empty($VVERBOSE)) {
                $logLevel = \Resque_Worker::LOG_VERBOSE;
            }
        }

        $interval = 5;
        $INTERVAL = getenv('RESQUE_INTERVAL');
        if (!empty($INTERVAL)) {
            $interval = $INTERVAL;
        }

        $count = 1;
        $COUNT = getenv('RESQUE_COUNT');
        if (!empty($COUNT) && $COUNT > 1) {
            $count = $COUNT;
        }

        if ($count > 1) {
            for ($i = 0; $i < $count; ++$i) {
                $pid = \pcntl_fork();
                if ($pid == -1) {
                    die("Could not fork worker " . $i . "\n");
                } // Child, start the worker
                else {
                    if (!$pid) {
                        $queues           = explode(',', $queue);
                        $worker           = new \Resque_Worker($queues);
                        $worker->logLevel = $logLevel;
                        fwrite(STDOUT, '*** Starting worker ' . $worker . "\n");
                        $worker->work($interval);
                        break;
                    }
                }
            }
        } // Start a single worker
        else {
            $queues           = explode(',', $queue);
            $worker           = new \Resque_Worker($queues);
            $worker->logLevel = $logLevel;

            $PIDFILE = getenv('RESQUE_PIDFILE');
            if ($PIDFILE) {
                file_put_contents($PIDFILE, getmypid()) or
                die('Could not write PID information to ' . $PIDFILE);
            }

            fwrite(STDOUT, '*** Starting worker ' . $worker . "\n");
            $worker->work($interval);
        }

    }

    public function actionPruneWorkers($queue = 'default')
    {
        $worker = new \Resque_Worker($queue);
        $worker->pruneDeadWorkers();
    }
}