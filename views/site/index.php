<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Авторизация';
?>
<div class="site-index">
<?php $form = ActiveForm::begin(); ?>
    <h1>Личный кабинет</h1>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>

    <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
    <div class="form-group">
             <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div>

