<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\testanswer */
/* @var $form ActiveForm */
$this->title = "Создание";
$this->params['breadcrumbs'][] = ['label' => 'Дисциплины', 'url' => "?r=teacher/discipline&id=".$_GET['discipline']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="teacher-createanswer">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'disc_name')->textinput(['readonly' => true, 'value' => $discipline])?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'file')->fileInput()->label('Файл') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- teacher-createanswer -->
