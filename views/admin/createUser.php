<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\testanswer */
/* @var $form ActiveForm */
$this->title = "Создание";

$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="teacher-createanswer">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'login')?>
        <?= $form->field($model, 'password')->passwordInput()?>
        <?= $form->field($model, 'lastname') ?>
        <?= $form->field($model, 'firstname')?>
        <?= $form->field($model, 'middlename')?>
        <?= $form->field($model, 'email')?>
        <div id="group" style="display:block" class="form-group field-testquestion-group">
            <label class="control-label" for="testquestion-group">Группа студента</label> <br>
            <?= Html::activeDropDownList($model, 'group', $groups) ?>
        </div>
        
        <div class="form-group field-testquestion-role">
        <label class="control-label" for="testquestion-role">Тип пользователя</label> <br>
        <?= Html::activeDropDownList($model, 'role',
            ['student' => 'Студент', 'teacher' => 'Преподаватель', 'admin' => 'Администратор']) ?>
        </div>
    
        <div class="form-group">
            <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- teacher-createanswer -->

<?php
$script = <<< JS

    document.getElementById('backenduser-role').onchange = function(){
        if(this.value == 'student')
            document.getElementById('group').style.display = 'block';
        else 
            document.getElementById('group').style.display = 'none';
    }
JS;
$this->registerJs($script);