<?php
/**
 * Created by PhpStorm.
 * User: tobias
 * Date: 18.06.15
 * Time: 22:48
 */

namespace hrzg\resque\controllers;


use hrzg\resque\models\QueueForm;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;

class ManageController extends Controller
{
    /**
     *
     * @inheritdoc
     * @return unknown
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,

                        /**
                         *
                         */
                        'matchCallback' => function ($rule, $action) {return \Yii::$app->user->can($this->module->id . '_' . $this->id . '_' . $action->id, ['route' => true]);},
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $model = new QueueForm;

        if (\Yii::$app->request->post('QueueForm')) {
            $model->load($_POST);
            $args = Json::decode($model['payload']);
            $args['sessionId'] = \Yii::$app->session->id;
            $token = \Resque::enqueue('default', 'hrzg\resque\components\Job', $args, true);
            $shortId = substr($token,0,6);
            \Yii::$app->session->addFlash('info', "Job <b>$shortId</b> for session <b>{$args['sessionId']}</b> created.");
        }

        $jobData = [];
        $jobs = \Yii::$app->session->get('__jobs', []);
        if (is_array($jobs)) foreach ($jobs AS $job) {
            #echo 'JOB' . $job;
            $status = new \Resque_Job_Status($job);
            #var_dump($status->get());
            $jobData[] = ['id'=>$job, 'status'=>$status->get()];
        }


        (new \Resque_Worker('default'))->pruneDeadWorkers();

        $workers = \Resque::redis()->smembers('workers');
        $queues = \Resque::redis()->smembers('queues');

        echo $this->render(
            'index',
            [
                'model' => $model,
                'workers' => $workers,
                'queues' => $queues,
                'jobs' => $jobData
            ]
        );
    }
}