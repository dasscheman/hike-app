<?php
use yii\helpers\Html;
use prawee\widgets\ButtonAjax;
use yii\bootstrap\Modal;

/* @var $this GroupsController */
/* @var $data Groups */

?>


<div class="well">
    <?php
    echo ButtonAjax::widget([
        'name' => $model->user->username,
        'route' => [
            'deelnemers-event/update',
            'deelnemers_ID'=>$model->deelnemers_ID,
        ],
        'modalId' => '#deelnemer-update-modal',
        'modalContent' => '#deelnemer-update-modal',
        'options' => [
            'class' => 'btn btn-link',
            'title' => Yii::t('app', 'Edit player'),
            'disabled' => !Yii::$app->user->identity->isActionAllowed('deelnemers-event', 'update', ['deelnemers_ID' => $model->deelnemers_ID]),
        ]
    ]);
    Modal::begin([
        'id' => 'deelnemer-update-modal',
        'options' => [
            'id' => 'deelnemer-update-modal',
            'tabindex' => false // important for Select2 to work properly
        ],
        'closeButton' => [
            'label' => 'Close',
            'class' => 'btn btn-danger btn-sm pull-right',
        ]]);
    echo '<div id="deelnemer-update-modal"></div>';
    Modal::end(); ?>
    <br/>
    <?php echo Html::encode($model->getRolTextObj()); ?>
</div>
