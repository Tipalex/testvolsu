<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Результат";
$n = 1;
$this->params['breadcrumbs'][] = ['label' => 'Дициплины', 'url' => "?r=student/discipline&id=".$_GET['d']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="row">

	<h3> <?= $name?> </h3>

	<p> <?php echo $description ?></p>
        
	<div class="col-md-5"> <h1><?php if($type == 'test') echo "Ответы"; else echo "Результат"; ?></h1>

		<table class="table">
		<thead>
			<tr>
				<?php if($type == 'test'): ?>
				<th scope="col"> <h3>№</h3></th>
				<th scope="col"> <h3>Вопрос</h3></th>			
				<th scope="col"> <h3>Ответ</h3></th>
				<?php endif; ?>
				<?php if($type == 'tack'): ?>
				<th scope="col"> <h3>Вступление</h3></th>	
				<th scope="col"> <h3>Результат</h3></th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($test as $key=>$t):?>
				<tr>
					<?php
					if($type == 'test') $answer = $t['answer'];
					else $answer = "<a href='?r=student/getfile&name=".$t['answer']."'>".htmlspecialchars(substr($t['answer'], 8))." </a>";
					if($type == 'test'){
						echo "<td><h5>". htmlspecialchars($n)."</h5></td>";
						echo "<td><h5>". htmlspecialchars($t['name'])."</h5></td>";
					} else echo "<td><h5>". htmlspecialchars($description)."</h5></td>";
					echo "<td><h5>". htmlspecialchars($answer)."</h5></td>";
					$n++;
					?>
				</tr>
			<?php endforeach; ?>
		</tbody>

	</table>

</div>