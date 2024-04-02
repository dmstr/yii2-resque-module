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

    <?php
    $form = ActiveForm::begin([
            'successCssClass' => ''
    ]);
    echo $form->field($model, 'command')->textarea()
    ?>

    <div class="form-group">
        <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
