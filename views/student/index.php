<?php
/* @var $this yii\web\View */

$this->title = 'Предметы';
?>
<div class="row">

	<table class="table">
		<thead>
			<tr>
				<th scope="col"> <h3> Мои дисциплины</h3></th>
				<th scope="col"> <h3>Преподаватели</h3></th>
				<th scope="col"> <h3>Баллы</h3></th>
				<th scope="col"> <h3>Форма контроля</h3></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($disciplines as $d){ ?>
				<tr>
					<?php
					echo "<td> <h3> <a href='?r=student/discipline&id=".htmlspecialchars($d['id'])."'>".htmlspecialchars($d['name'])." </a></h3></td>";
					echo "<td><h3> ".htmlspecialchars($d['teacher'])."</h3></td>";
					echo "<td><h3> ".htmlspecialchars($d['score'])."</h3></td>";
					echo "<td><h3> ".htmlspecialchars($d['control'])."</h3></td>";
					?>
				</tr>
			<?php } ?>
		</tbody>

	</table>
	

</div>