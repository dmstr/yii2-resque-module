<?php
/**
 * @var hrzg\resque\models\QueueForm $model
 * @var \yii\queue\db\StatisticsProvider|\yii\queue\file\StatisticsProvider|\yii\queue\redis\StatisticsProvider $statisticsProvider
 */

use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="row">
    <div class="col-xs-12">
        <?php echo $this->render('_statistics', ['statisticsProvider' => $statisticsProvider]); ?>
    </div>
</div>

<?php Pjax::begin(['formSelector' => 'form']) ?>

<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <?php echo Yii::t('resque', 'Debug') ?>
            </div>
            <div class="panel-body">
                <?php echo $this->render('_form', ['model' => $model]); ?>
            </div>
        </div>
    </div>
</div>

<?php Pjax::end() ?>
