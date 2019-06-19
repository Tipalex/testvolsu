<?php
/* @var $this yii\web\View */

$this->title = 'Пользователи';
?>
<div class="row teacher-createanswer">
<a href = '?r=admin/viewgroups' style="padding-left: 8px;"><button type='button' class='btn btn-primary'> Группы студентов </button> </a>
	<table class="table">
		<thead>
			<tr>
				<th scope="col"> <h3>Логин</h3></th>
				<th scope="col"> <h3>ФИО</h3></th>
				<th scope="col"> <h3>Статус</h3></th>
				<th scope="col"> </th>
				<th scope="col"> </th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($users as $user){ 
				switch($user['role']){
					case 'teacher':
						$user['role'] = 'Преподаватель';
						break;
					case 'student':
						$user['role'] = 'Студент';
						break;
					case 'admin': 
						$user['role'] = 'Администратор';
						break;
					default:
						$user['role'] = 'Преподаватель';
						break;
				}
				?>

				<tr>
					<?php
					if($user['role'] == 'Преподаватель')
						echo "<td><a href = '?r=admin/viewuser&id=".$user['id']."'><h3>". $user['login'] ."</h3></a></td>";
					else 
						echo "<td><h3>". $user['login'] ."</h3></td>";
					echo "<td><h3> ".$user['lastname']." ".$user['firstname']." ".$user['middlename']."</h3></td>";
					echo "<td><h3> ".$user['role']."</h3></td>";
					echo "<td><div style='padding-top:16px'><a href = '?r=admin/createuser&id=".$user['id']."' style='padding-top:8px'><button type='button' class='btn btn-primary'> Редактировать </button> </a></div> </td>";
					echo "<td><div style='padding-top:16px'> <a href = '?r=admin/deleteuser&id=".$user['id']."' ><button type='button' class='btn btn-danger'> Удалить </button> </a> </div> </td>";
					?>
				</tr>
			<?php } ?>
		</tbody>

	</table>
	<?php echo "<a href = '?r=admin/createuser' style='padding-left: 8px;'><button type='button' class='btn btn-primary'> Добавить </button> </a>"; ?>

</div>