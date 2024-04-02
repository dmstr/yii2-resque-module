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
            'text' => 'Workers',
            'footer' => 'Jobs Status',
            'footer_link' => ['/queuemanager/default/index']
        ]) ?>
    </div>
    <div class="col-sm-3">
        <?= SmallBox::widget([
            'head' => '#',
            'text' => 'Queues',
            'type' => SmallBox::TYPE_YEL,
            'footer' => 'Real Time Monitor',
            'footer_link' => ['/queuemanager/default/stat']]) ?>
    </div>
</div>

<?php Pjax::begin(['formSelector' => 'form']) ?>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-warning">
            <div class="panel-heading">
                Debug
            </div>
            <div class="panel-body">
                <?= $this->render('_form', ['model' => $model]); ?>
            </div>
        </div>
    </div>
</div>

<?php Pjax::end() ?>
