<?php
/**
 * Created by PhpStorm.
 * User: tobias
 * Date: 18.06.15
 * Time: 22:48
 */

namespace hrzg\resque\controllers;

use hrzg\resque\models\QueueForm;
use yii\web\Controller;
use Yii;

/**
 * @property-read \yii\web\Request $request
 * @property-read \hrzg\resque\Module $module
 */
class ManageController extends Controller
{

    public function actionIndex()
    {
        $model = new QueueForm([
            'queue' => Yii::$app->get($this->module->queue)
        ]);

        if ($model->load($this->request->post()) && $model->sendJobToQueue()) {
            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }
}
