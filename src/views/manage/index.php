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

<?php Pjax::begin(['formSelector'=>'form']) ?>


<div class="row">
    <div class="col-sm-3">
        <?= SmallBox::widget(['head' => count($workers), 'text' => 'Workers']) ?>
    </div>
    <div class="col-sm-3">
        <?= SmallBox::widget(['head' => count($queues), 'text' => 'Queues', 'type' => SmallBox::TYPE_YEL]) ?>
    </div>
    <div class="col-sm-3">
        <?= SmallBox::widget(['head' => 'n/a', 'text' => 'Succeeded', 'type' => SmallBox::TYPE_GREEN]); ?>

    </div>
    <div class="col-sm-3">
        <?= SmallBox::widget(['head' => 'n/a', 'text' => 'Failed', 'type' => SmallBox::TYPE_RED]); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                Create Job
            </div>
            <div class="panel-body">
                <?= $this->render('_form', ['model' => $model]); ?>
            </div>
            <div class="panel-footer">

                <?= TwigWidget::widget(['position'=>'form-panel-footer', 'registerMenuItems'=>true, 'queryParam'=>false, 'renderEmpty'=>false]) ?>

            </div>
        </div>


        <div class="panel panel-info">
            <div class="panel-heading">
                Jobs <span class="badge"><?= count($jobs) ?></span>
            </div>
            <div class="panel-body">
                <?php
                $allModels = [];
                foreach ($jobs AS $key => $job) {
                    $allModels[$key] = ['id' => $job['id'], 'status' => $job['status']];
                    #$workers[] = (string)$worker;
                }

                $dataProvider = new \yii\data\ArrayDataProvider(['allModels' => $allModels]);
                echo \yii\grid\GridView::widget(['dataProvider' => $dataProvider]);


                ?>
            </div>
        </div>


    </div>

    <div class="col-sm-4">

        <?php foreach ($queues AS $queue): ?>

            <div class="panel panel-success">
                <div class="panel-heading">
                    Running jobs in queue <b><?= $queue ?></b> <span class="badge"><?= $count ?></span>
                    <?= Html::a('Reload', [''], ['class' => 'btn btn-default btn-xs pull-right']) ?>

                </div>
                <div class="panel-body overflow-scroll">


                    <?php
                    $items = [];
                    for ($i = 0; $i < $count; $i++) {

                        $worker = \yii\helpers\Json::decode(Resque::redis()->lindex('queue:default', $i));
                        $content = VarDumper::dumpAsString($worker['args'], 10, true);

                        $icon = FontAwesome::icon(FA::_REMOVE).' Remove Job';
                        $deleteButton = Html::tag(
                            'div',
                            Html::a($icon, '', ['class' => 'btn btn-danger btn-sm pull-right'])
                        );
                        $content .= $deleteButton;

                        $status = new \Resque_Job_Status($worker['id']);
                        $status->create($worker['id']);

                        $statusCssClass = ($status->get()) ? 'warning' : 'default';
                        $items[] = [
                            'label' => "<span class='pull-right badge badge-{$statusCssClass}'>#{$i}</span> {$worker['class']} <small>{$worker['id']}</small> ",
                            'encode' => false,
                            'content' => $content,
                            #'class'=>'out'
                        ];
                    }

                    echo Collapse::widget(
                        [
                            'items' => $items
                        ]
                    );


                    ?>
                </div>
            </div>
        <?php endforeach; ?>


        <div class="panel panel-info">
            <div class="panel-heading">
                Workers <span class="badge"><?= count($workers) ?></span>
            </div>
            <div class="panel-body">
                <?php
                $allModels = [];
                foreach ($workers AS $worker) {
                    $allModels[$worker] = ['id' => Resque_Worker::find($worker)];
                    #$workers[] = (string)$worker;
                }

                $dataProvider = new \yii\data\ArrayDataProvider(['allModels' => $allModels]);
                echo \yii\grid\GridView::widget(['dataProvider' => $dataProvider]);


                ?>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-6">


    </div>

</div>


<?php Pjax::end() ?>
