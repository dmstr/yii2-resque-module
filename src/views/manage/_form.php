<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model hrzg\resque\models\QueueForm
 * @var $form ActiveForm
 */
?>
<div class="form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'queue')->dropDownList(
        [
            'default' => 'default',
            'internal' => 'internal',
            'external' => 'external',
        ]
    ) ?>

    <?= $form->field($model, 'command')->textarea(
        [
            'app\\jobs\\ImportJob' => 'Command',
        ]
    ) ?>



    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        <div class="help-block"></div>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- _form -->
