<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
$this->title = "Тестирование";
$n = 1;
$this->params['breadcrumbs'][] = ['label' => 'Дициплины', 'url' => "?r=student/discipline&id=".$_GET['d']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<div class = "timer" style="width:100%; position: -webkit-sticky; position: sticky; top: 0px; background: rgb(242, 242, 242)">
<?php Pjax::begin(); ?>
<?php if($needToSubmit) $this->registerJs("document.getElementsByClassName('test_form')[0].submit();"); ?>
<?= Html::a("Refresh", ['student/passtest', 'id' => $_GET['id'], 'd' => $_GET['d']], ['id' => 'refreshButton', 'class' => 'btn btn-lg btn-primary', 'style' => 'display: none;']) ?>

  <h3>Осталось времени: <?= $dateLeft ?></h3>

<?php Pjax::end(); ?>
</div>
<h1> <?= $test['name'] ?></h1>
<p> <?php echo $test['description']?></p>
<form method='post' class="test_form" action='?r=student/passtest&passed=true&id=<?= $_GET['id']?>' style="margin-top: 20px;">
<?php
$value = Yii::$app->request->getCsrfToken();
$n = 1;
echo "<input type='hidden' name='_csrf' value='$value' />";
foreach ($model as $key => $question) {
	$result = "<h3>".$n.". ".$question['name']."</h3><br><div class='group_$key'> ";
  if(!empty($question['image'])) {
    $result .= "<div><img src='".$question['image']."' width = '250px'></div></br>";
  }
  echo "<div style='margin-top:15px'></div>";
  if($question['type'] == 'select_single' || $question['type'] == 'yes_no' ){
  	foreach ($question['answers'] as $keyA =>$answers) {
  		$result.= "<input type='radio' name ='qu[".$question['key']."][]' value='".$answers['name']."' > &nbsp; &nbsp;".$answers['name']. "</input></br>";
  	}
  } elseif($question['type'] == 'select_multiple'){
    foreach ($question['answers'] as $keyA =>$answers) {
      $result.= "<input type='checkbox' name ='qu[".$question['key']."][]' value='".$answers['name']."' > &nbsp; &nbsp;".$answers['name']. "</input></br>";
    }

  } 

  else $result.= "<input type='text' name ='qu[".$question['key']."][]' > </input></br>";
	$result .= "</div>";

  

  echo $result;
  $n++;
}


?>
</br>
<button type='submit' class = "btn btn-success"style='margin-bottom: 10px;'>Завершить</button>
</form>
<?php
$script = <<< JS
    $(document).ready(function() {
        interval = setInterval(function(){ $('#refreshButton').click(); }, 1000);
    });

    document.getElementById('submit-button').onclick = function(){
      clearInterval(interval);
    }
JS;
$this->registerJs($script);


?>


