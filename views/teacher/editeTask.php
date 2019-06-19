<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Test */
/* @var $form ActiveForm */

$this->title = "Редактирование";
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => "?r=teacher/tasks"];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>


<div class="teacher-createTest">

    <?php $form = ActiveForm::begin(); ?>
    	<label class="control-label" style ="margin-top:25px"> Дисциплина </label></br>
    	<?= Html::activeDropDownList($model, 'discipline',
      		ArrayHelper::map($discipline, 'id', 'name')) ?>
        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'description')->textarea(['rows' => '6']) ?>
        <?= $form->field($model, 'isPublished')->checkbox() ?>
        <?= $form->field($model, 'file')->fileInput()->label('Файл') ?>
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
