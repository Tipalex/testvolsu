<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Результат";
$n = 1;
$this->params['breadcrumbs'][] = ['label' => 'Дициплины', 'url' => "?r=teacher/discipline&id=".$_GET['discipline']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="row">

	<h3> <?= $name?> </h3>
<?php $form = ActiveForm::begin(); ?>

		<table class="table">
		<thead>
			<tr>
				<?php if($type == 'test'): ?>
				<th scope="col"> <h3>№</h3></th>
				<th scope="col"> <h3>Вопрос</h3></th>
				<?php endif; ?>
				<?php if($type == 'test'): ?>
				<th scope="col"> <h3>Ответ</h3></th>
				<?php endif; ?>
				<?php if($type == 'tack'): ?>
					<th scope="col"> <h3>Результат</h3></th>
				<?php endif; ?>
				<th scope="col"> <h3>Балл</h3></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($test as $key=>$t):?>
				<tr>
					<?php
					if($type == 'test') $answer = $t['answer'];
					else $answer = "<a href='?r=student/getfile&name=".$t['answer']."'>".substr($t['answer'], 8)." </a>";
					if($type == 'test'){
						echo "<td><h5>". $n."</h5></td>";
						echo "<td><h5>". $t['name']."</h5></td>";
					}
					echo "<td><h5>". htmlspecialchars($answer)."</h5></td>";
					echo "<td><h5>".$form->field($model[$key], "[$key]score")->textInput(['value' => $answer_scores[$key]])->label(false)."</h5></td>";
					$n++;
					?>
				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

        <div class="form-group">
            <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>
        </div>
<?php ActiveForm::end(); ?>
</div>