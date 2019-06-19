<a href="?r=teacher/tests">


<button class="btn btn-success"> Тесты </button></a> 
<a href="?r=teacher/tasks"><button class="btn btn-success"> Задания </button></a>
<h1> Ваши дисциплины </h1>

<?php 
foreach ($disc as $d) {
	echo "<h2> <a href='?r=teacher/discipline&id=".$d['id']."'>".$d['name']." </a></h2>";
}
//print_r($disc); ?>