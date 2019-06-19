<?php
/* @var $this yii\web\View */

$this->title = 'Группы';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class="row">
	<table class="table">
		<thead>
			<tr>
				<th scope="col"> <h3>Группа</h3></th>
				<th scope="col"> </th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($groups as $group){ 
				?>

				<tr>
					<?php
					echo "<td><a href = '?r=admin/groupdisciplines&id=".$group['id']."'><h3>". $group['name'] ."</h3></a></td>";
					echo "<td><a href = '?r=admin/deletegroup&id=".$group['id']."'><button type='button' class='btn btn-danger'> Удалить </button> </a></td>";
					?>
				</tr>
			<?php } ?>
		</tbody>

	</table>
	<?php echo "<a href = '?r=admin/creategroup'><button type='button' class='btn btn-primary'> Добавить </button> </a>"; ?>

</div>