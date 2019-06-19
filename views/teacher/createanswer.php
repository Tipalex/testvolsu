<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\testanswer */
/* @var $form ActiveForm */
$this->title = "Создание";
$this->params['breadcrumbs'][] = ['label' => 'Тестирования', 'url' => "?r=teacher/tests"];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы', 'url' => "?r=teacher/viewquestions&test=".$_GET['test']];
$this->params['breadcrumbs'][] = ['label' => 'Ответы', 'url' => "?r=teacher/viewanswers&quest=".$_GET['quest']."&test=".$_GET['test']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="teacher-createanswer">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'question')->textinput(['readonly' => true, 'value' => $question])?>
        <?= $form->field($model, 'answer') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- teacher-createanswer -->
