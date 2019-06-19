<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\testanswer */
/* @var $form ActiveForm */
$this->title = "Создание дисциплины";
$this->params['breadcrumbs'][] = ['label' => 'Дисциплины'];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div >

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'teacher_name')->textinput(['readonly' => true, 'value' => $FIO])?>
        <?= $form->field($model, 'name')?>
        <?= Html::label('Тип контроля'); ?> <br/>
        <?= Html::activeDropDownList($model, 'control',
            ['зачёт' => 'зачёт', 'зачёт с оценкой' => 'зачёт с оценкой', 'экзамен' => 'экзамен']) ?>
    
        <div class="form-group" style="margin-top:15px">
            <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- teacher-createanswer -->
