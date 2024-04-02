<?php
/**
 * @var $model hrzg\resque\models\QueueForm
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="form">
    <?php
    $form = ActiveForm::begin();
    echo $form->field($model, 'command')->textarea();
    ?>

    <div class="form-group">
        <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
