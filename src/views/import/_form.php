<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model hrzg\resque\models\QueueForm */
/* @var $form ActiveForm */
?>
<div class="form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'queue')->dropDownList(
        [
            'default' => 'default',
        ]
    ) ?>

    <?= $form->field($model, 'job')->dropDownList(
        [
            'app\\jobs\\ImportJob' => 'Import',
        ]
    ) ?>

    <?=
    '<div class="field-widget-{$attribute}">' .
    \devgroup\jsoneditor\Jsoneditor::widget(
        [
            'editorOptions' => [
                'modes' => ['code', 'form', 'text', 'tree', 'view'], // available modes
                'mode'  => 'code', // current mode
            ],
            'model'         => $model,
            'attribute'     => 'payload',
            'options'       => [
                'id'    => 'widget-payload',
                'class' => 'form-control',
            ],
        ]
    ) .
    '</div>'
    ?>


    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        <div class="help-block"></div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- _form -->
