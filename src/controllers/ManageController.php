<?php
/**
 * Created by PhpStorm.
 * User: tobias
 * Date: 18.06.15
 * Time: 22:48
 */

namespace hrzg\resque\controllers;

use hrzg\resque\components\QueueCommand;
use hrzg\resque\models\QueueForm;
use Yii;
use yii\web\Controller;

class ManageController extends Controller
{
    public function actionIndex()
    {
        $model = new QueueForm();

        if ($model->load($this->request->post())) {

            Yii::$app->queue->push(new QueueCommand([
                'command' => $model['command'],
                'sessionId' => Yii::$app->getSession()->getId()
            ]));
        }

        return $this->render('index', [
            'model' => $model
        ]);

    }
}
