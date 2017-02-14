<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use kartik\widgets\AlertBlock;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Route */

?>
<div class="tbl-open-nood-envelop-view">
    <h3> <?php echo Yii::t('app', 'Hints') ?> </h3>
    <p>
        <?php
        Pjax::begin(['id' => 'nood-envelop-view-dashboard', 'enablePushState' => false]);
        ?>
    </p>
    <?php
        echo ListView::widget([
            'summary' => FALSE,
            'pager' => [
                'prevPageLabel' => Yii::t('app', 'previous'),
                'nextPageLabel' => Yii::t('app', 'next'),
                'maxButtonCount' => 0,
                'options' => [
                   'class' => 'pagination pagination-sm',
                ],
            ],
            'dataProvider' => $model,
            'itemView' => '/open-nood-envelop/_list-dashboard',
            'emptyText' => Yii::t('app', 'No hints that can be opened.'),
        ]);
    ?>
    <?php Pjax::end(); ?>
</div>