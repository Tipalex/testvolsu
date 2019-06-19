<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Test */
/* @var $form ActiveForm */
$this->title = "Задание";
$n = 1;
$this->params['breadcrumbs'][] = ['label' => 'Дициплины', 'url' => "?r=student/discipline&id=".$_GET['d']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>
<h1> <?= $test['name'] ?></h1>
<p> <?php echo $test['description']?></p>
<?php if(isset($file)): ?>
<a href='?r=student/getfile&name=<?=$file?>'><button class="btn btn-primary"> Вложение</button></a>

<?php endif; ?>
<div style="margin-top:25px;">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $form->field($model, 'file')->fileInput() ?>

</br>
<div class="form-group">
            <?= Html::submitButton('Завершить', ['class' => 'btn btn-primary']) ?>
        </div>
<?php ActiveForm::end(); ?>
</div>
