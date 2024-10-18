<?php
/**
 * @var \yii\queue\db\StatisticsProvider|\yii\queue\file\StatisticsProvider|\yii\queue\redis\StatisticsProvider
 *     $statisticsProvider
 */

use yii\helpers\Html;
use yii\queue\interfaces\DelayedCountInterface;
use yii\queue\interfaces\DoneCountInterface;
use yii\queue\interfaces\ReservedCountInterface;
use yii\queue\interfaces\WaitingCountInterface;

if ($statisticsProvider instanceof WaitingCountInterface) {
    echo Html::tag('p', Yii::t('resque', 'Waiting: {count}', [
        'count' => $statisticsProvider->getWaitingCount()
    ]));
}

if ($statisticsProvider instanceof ReservedCountInterface) {
    echo Html::tag('p', Yii::t('resque', 'Reserved: {count}', [
        'count' => $statisticsProvider->getReservedCount()
    ]));
}

if ($statisticsProvider instanceof DelayedCountInterface) {
    echo Html::tag('p', Yii::t('resque', 'Delayed: {count}', [
        'count' => $statisticsProvider->getDelayedCount()
    ]));
}

if ($statisticsProvider instanceof DoneCountInterface) {
    echo Html::tag('p', Yii::t('resque', 'Done: {count}', [
        'count' => $statisticsProvider->getDoneCount()
    ]));
}
?>

<div class="form-group"><?php echo Html::a(Yii::t('resque', 'Refresh'), '', ['class' => 'btn btn-primary']) ?></div>
