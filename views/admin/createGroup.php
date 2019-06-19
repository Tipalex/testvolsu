<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\testanswer */
/* @var $form ActiveForm */
$this->title = "Создание группы";
$this->params['breadcrumbs'][] = ['label' => 'Группы'];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="teacher-createanswer">

    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name')?>
        <div class="form-group">
            <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- teacher-createanswer -->
