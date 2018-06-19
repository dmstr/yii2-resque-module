<?php
namespace hrzg\resque\views\import;

use dmstr\modules\prototype\widgets\TwigWidget;
use insolita\wgadminlte\SmallBox;
use Resque;
use Resque_Worker;
use rmrevin\yii\fontawesome\FA;
use rmrevin\yii\fontawesome\FontAwesome;
use yii\bootstrap\Collapse;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\Pjax;

$count = Resque::size('default');

?>

<div class="row">
    <div class="col-sm-3">
        <?= SmallBox::widget([
            'head' => '#',
            'text' => 'Workers',
            'footer' => 'Jobs Status',
            'footer_link' => ['/queuemanager']
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
