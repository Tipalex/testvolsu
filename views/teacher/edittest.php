<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Test */
/* @var $form ActiveForm */
$this->title = "Редактирование";
$this->params['breadcrumbs'][] = ['label' => 'Тестирования', 'url' => "?r=teacher/tests"];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="teacher-createTest">

    <?php $form = ActiveForm::begin(); ?>
    	<?= $form->field($model, 'name')->textinput(['value' => $model->name]) ?>
        <label class="control-label" style ="margin-top:5px"> Дисциплина </label></br>
    	<?= Html::activeDropDownList($model, 'discipline',
      		ArrayHelper::map($discipline, 'id', 'name')) ?>
        <?= $form->field($model, 'time')->textinput(['value' => $model->time]) ?>
        <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>
        <?= $form->field($model, 'isPublished')->checkbox() ?>
        <label class="control-label"> Дата начала теста </label></br>
        <?php echo DatePicker::widget([
		    'model' => $model,
		    'attribute' => 'dateOfStart',
		    //'language' => 'ru',
		    'dateFormat' => 'yyyy-MM-dd',
		]);
		?>
	</br>
        <label class="control-label" style ="margin-top:25px"> Дата окончания теста </label></br>
        <?php echo DatePicker::widget([
		    'model' => $model,
		    'attribute' => 'dateOfEnd',
		    //'language' => 'ru',
		    'dateFormat' => 'yyyy-MM-dd',
		]);
		?>
        <?php
        if(isset($model->errors['dateOfEnd'][0])) echo "<div class='help-block' style='color: #a94442;'>".$model->errors['dateOfEnd'][0]."</div>";
        ?>
    
        <div class="form-group" style ="margin-top:25px">
           <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- teacher-createTest -->
