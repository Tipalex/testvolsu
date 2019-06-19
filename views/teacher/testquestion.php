<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\testquestion */
/* @var $form ActiveForm */
$this->title = "Создание";
$this->params['breadcrumbs'][] = ['label' => 'Тестирования', 'url' => "?r=teacher/tests"];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы', 'url' => "?r=teacher/viewquestions&test=".$_GET['test']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="teacher-testquestion">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'test')->textinput(['readonly' => true, 'value' => $name]) ?>
        <?= $form->field($model, 'question')?>

        <div class="form-group field-testquestion-type">
        <label class="control-label" for="testquestion-type">Тип ответ</label> <br>
        <?= Html::activeDropDownList($model, 'type',
            ['select_single' => 'Выбрать один вариант ответа', 'select_multiple' => 'Выбрать несколько вариантов ответов', 'write' => 'Ввод ответа вручную', 'yes_no' => 'Верно/Не верно']) ?>
         </div>

        <?= $form->field($model, 'file')->fileInput()->label('Приложение') ?>
        <div class="form-group" style = "margin-top:15px;">
            <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- teacher-testquestion -->

