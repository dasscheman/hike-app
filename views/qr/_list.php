<?php
use yii\helpers\Html;
use prawee\widgets\ButtonAjax;
use yii\bootstrap\Modal;

/* @var $this GroupsController */
/* @var $data Groups */

?>

<div class="col-sm-3">
    <div class="view">

    <p>
        <?php
         echo ButtonAjax::widget([
            'name'=>'Create',
            'route'=>['qr/create', 'id' => $model->qr_ID],
            'modalId'=>'#main-modal',
            'modalContent'=>'#main-content-modal',
            'options'=>[
                'class'=>'btn btn-success',
                'title'=>'Button for create application',
            ]
        ]); ?>


        <?php
         echo ButtonAjax::widget([
            'name'=>'Delete',
            'route'=>['qr/delete', 'id' => $model->qr_ID],
                'modalId'=>'#main-modal',
                'modalContent'=>'#main-content-modal',
            'options'=>[
                'class'=>'btn btn-danger',
                'title'=>'Remove this qr',
//                'data' => [
//                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
//                    'method' => 'post',
//
//                ],
            ]
        ]); ?>

    </p>
	<?php echo Html::encode($model->getAttributeLabel('qr_name')); ?> 
	<?php echo Html::encode($model->qr_name); ?> </br>
    <?php echo Html::encode($model->getAttributeLabel('qr_code')); ?>
    <?php echo Html::encode($model->qr_code); ?></br>
    <?php echo Html::encode($model->getAttributeLabel('qr_volgorde')); ?>
    <?php echo Html::encode($model->qr_volgorde); ?></br>
    <?php echo Html::encode($model->getAttributeLabel('score')); ?>
    <?php echo Html::encode($model->score); ?></br>
    <?php echo Html::encode($model->getAttributeLabel('route_ID')); ?>
    <?php echo Html::encode($model->route_ID); ?></br>
        
    </div>
</div>