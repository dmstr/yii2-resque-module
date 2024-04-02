<?php
/**
 * @var $model hrzg\resque\models\QueueForm
 */

use insolita\wgadminlte\SmallBox;
use yii\widgets\Pjax;

?>

<div class="row">
    <div class="col-sm-3">
        <?= SmallBox::widget([
            'head' => '#',
            'text' => Yii::t('resque', 'Workers'),
            'footer' => Yii::t('resque', 'Jobs Status'),
            'footer_link' => ['/queuemanager/default/index']
        ]) ?>
    </div>
    <div class="col-sm-3">
        <?= SmallBox::widget([
            'head' => '#',
            'text' => Yii::t('resque', 'Queues'),
            'type' => SmallBox::TYPE_YEL,
            'footer' => Yii::t('resque', 'Real Time Monitor'),
            'footer_link' => ['/queuemanager/default/stat']]) ?>
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
