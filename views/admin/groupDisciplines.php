<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Дисциплины';
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => "?r=admin/viewgroups"];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="row">
	<table class="table">
		<thead>
			<tr>
				<th scope="col"> <h3>Дициплины</h3></th>
				<th scope="col"> </th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($gd as $d){ 
				?>

				<tr>
					<?php
					echo "<td><h3>". $d->discipline_name ."</h3></td>";
					echo "<td><a href = '?r=admin/deletegd&id=".$d->id."&group=".$_GET['id']."'><button type='button' class='btn btn-danger link' style='margin-top:15px'> Удалить </button> </a></td>";
					?>
				</tr>
			<?php } ?>
		</tbody>

	</table>

	<div class="teacher-createanswer">

<?php $form = ActiveForm::begin(); ?>

        <?php
         echo $form->field($modelGD, 'discipline')->dropDownList($model)->label('Дисциплина'); ?>
    
        <div class="form-group">
            <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>

</div>