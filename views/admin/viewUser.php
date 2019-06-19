<?php
/* @var $this yii\web\View */

$this->title = 'Дисциплины преподавателя';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="row">
<h3> <?= $FIO ?> </h3>
	<table class="table">
		<thead>
			<tr>
				<th scope="col"> <h3>Дисциплины</h3></th>
				<th scope="col"> <h3>Форма контроля</h3></th>
				<th scope="col"></th>
				<th scope="col"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($disciplines as $d){ ?>
				<tr>
					<?php
					echo "<td> <h3>".$d['name']." </a></h3></td>";
					echo "<td><h3> ".$d['control']."</h3></td>";
					echo "<td><a href = '?r=admin/creatediscipline&id=".$d['id']."&teacher=".$_GET['id']."'><button type='button' class='btn btn-primary'> Редактировать </button> </a></td>";
					echo "<td><a href = '?r=admin/deletediscipline&id=".$d['id']."&teacher=".$_GET['id']."'><button type='button' class='btn btn-danger'> Удалить </button> </a></td>";
					?>
				</tr>
			<?php } ?>
		</tbody>

	</table>
	<?php echo "<a href = '?r=admin/creatediscipline&teacher=".$_GET['id']."'><button type='button' class='btn btn-primary'> Добавить </button> </a>"; ?>

</div>