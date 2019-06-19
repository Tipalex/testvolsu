<?php
/* @var $this yii\web\View */
$this->title = 'Задания';
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="row">
<div class="col-md-4"><h3> <?= $discipline['teacher']?> </h3></div>
<div class="col-md-2"> </div>
<div class="col-md-4"> <h3><?= $discipline['name']?></h3> </div>

</div>
<div class="row" style = "margin-top: 10px">

	<table class="table">
		<thead>
			<tr>
				<th scope="col"> <h3> Дата добавления</h3></th>
				<th scope="col"> <h3>Название</h3></th>
				<th scope="col"> <h3>Срок</h3></th>
				<th scope="col"> <h3>Статус</h3></th>
				<th scope="col"> <h3>Баллов</h3></th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($discipline['test'])): ?>
				<?php foreach ($discipline['test'] as $t):?>
					<tr>
						<?php
						echo "<td> <h5>" .htmlspecialchars($t['dateOfStart'])."</h5></td>";
						if($t['status'] == 'Не выполнено' && $t['type'] == 'test') 
							echo "<td><h5><a href='?r=student/passtest&id=".htmlspecialchars($t['id'])."&d=".htmlspecialchars($_GET['id'])."'>".htmlspecialchars($t['name'])."</a></h5></td>";
						elseif($t['status'] == 'Не выполнено' && $t['type'] == 'tack') 
							echo "<td><h5><a href='?r=student/passtask&id=".htmlspecialchars($t['id'])."&d=".htmlspecialchars($_GET['id'])."'>".htmlspecialchars($t['name'])."</a></h5></td>";
						elseif($t['status'] == 'Проверено')
							echo "<td><h5><a href='?r=student/checktest&id=".htmlspecialchars($t['id'])."&d=".htmlspecialchars($_GET['id'])."'>".htmlspecialchars($t['name'])."</a></td>";
						else 
							echo "<td><h5>".htmlspecialchars($t['name'])."</td>";	
						echo "<td><h5> ".htmlspecialchars($t['dateOfEnd'])."</h5></td>";
						echo "<td><h5>". htmlspecialchars($t['status'])."</h5></td>";
						echo "<td><h5>". htmlspecialchars($t['score'])."</h5></td>";
						?>
					</tr>
				<?php endforeach; ?>
			<?php endif;?>
		</tbody>

	</table>
	

</div>

<div class="row">
<?php
if(empty($materials)) echo "<h3>Для данной дисциплины нет опубликованных материалов.</h3>"; 
else{
	echo "<table class='table' style='margin-top:50px;'>
		<thead>
			<tr>
				<th scope='col'> <h4>Материал</h4></th>
			</tr>
		</thead><tbody>";

	foreach ($materials as $key => $material) {
		echo "<tr>";
		if(!empty($material->filePath))
			echo "<td> <a href='?r=teacher/getfile&name=".$material->filePath."'>".$material->name."</a></td>";
		else
			echo "<td>".$material->name."</td>";
		echo "</tr>";
	}

	echo "</tbody></table>";
}
?>
</div>