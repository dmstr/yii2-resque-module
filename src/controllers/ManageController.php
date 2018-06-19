<?php
/**
 * Created by PhpStorm.
 * User: tobias
 * Date: 18.06.15
 * Time: 22:48
 */

namespace hrzg\resque\controllers;


use bedezign\yii2\audit\Audit;
use hrzg\resque\components\Job;
use hrzg\resque\components\QueueCommand;
use hrzg\resque\models\QueueForm;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;

class ManageController extends Controller
{
    public function actionIndex()
    {
        $model = new QueueForm;

        if (\Yii::$app->request->post('QueueForm')) {
            $model->load($_POST);

            \Yii::$app->queue->push(new QueueCommand([
                'command' => $model['command'],
                'sessionId' => \Yii::$app->session->id
            ]));
        }

        return $this->render(
            'index',
            [
                'model' => $model,
            ]
        );

    }
}