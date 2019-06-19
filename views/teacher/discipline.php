<?php
/* @var $this yii\web\View */
//print_r($students);
$this->title = "Дициплины";
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<div class="row">
	<div class="col-md-3"> <h1>Мои группы</h1>
	<?php
		foreach ($groups as $group) {
			if(isset($_GET['group']) && $_GET['group'] == $group['id']) $class='selected'; else $class='';
			echo "<h2> <a class='".$class."' href='?r=teacher/discipline&id=".$_GET['id']."&group=".$group['id']."'>".$group['name']." </a></h2>";
		}
	?>
	 </div>
	<div class="col-md-4"> <h1>Список студентов</h1>
		<?php
			if($students){
				foreach ($students as $student) {
					if(isset($_GET['student']) && $_GET['student'] == $student['id']) $class='selected'; else $class='';
					echo "<h2> <a class='".$class."'  href='?r=teacher/discipline&id=".$_GET['id']."&group=".$_GET['group']."&student=".$student['id']."'>".$student['firstname']." ".$student['middlename']." ".$student['lastname']." </a></h2>";
				}


			}
		?>
	 </div>
	<div class="col-md-5"> <h1>Контроль</h1>

		<table class="table">
		<thead>
			<tr>
				<th scope="col"> <h3>Задания</h3></th>
				<th scope="col"> <h3>Статус</h3></th>
				<th scope="col"> <h3>Балл</h3></th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($_GET['student'])): ?>
			<?php foreach ($tests as $t):?>
				<tr>
					<?php

					echo "<td><a href='?r=teacher/checktest&id=".$t['test_id']."&user=".$_GET['student']."&discipline=".$_GET['id']."'><h5>". $t['name']."</h5></a></td>";
					echo "<td><h5>". $t['status']."</h5></td>";
					echo "<td><h5>". $t['score']."</h5></td>";
					?>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		</tbody>

		</table>
	</div>

</div>

<div class="row">
<?php
if(empty($materials)) echo "<h3>Для данной дисциплины нет опубликованных материалов.</h3>"; 
else{
	echo "<table class='table' style='margin-top:50px;'>
		<thead>
			<tr>
				<th scope='col'> <h4>Материал</h4></th>
				<th scope='col'> <h3>  </h3></th>
				<th scope='col'> <h3>  </h3></th>
			</tr>
		</thead><tbody>";

	foreach ($materials as $key => $material) {
		echo "<tr>";
		if(!empty($material->filePath))
			echo "<td> <a href='?r=teacher/getfile&name=".$material->filePath."'>".$material->name."</a></td>";
		else
			echo "<td>".$material->name."</td>";
		echo "<td> <a href = '?r=teacher/creatematerial&discipline=".$_GET['id']."&id=$material->id'><button type='button' class='btn btn-primary'> Редактировать </button> </a> </td> ";
		echo "<td> <a href = '?r=teacher/deletematerial&discipline=".$_GET['id']."&id=$material->id'><button type='button' class='btn btn-danger'> Удалить </button> </a> </td> ";
		echo "</tr>";
	}

	echo "</tbody></table>";
}
?>
<a href = "?r=teacher/creatematerial&discipline=<?=$_GET['id']?>" style="margin-left:5px;"><button type='button' class='btn btn-primary'> Добавить </button> </a>
</div>