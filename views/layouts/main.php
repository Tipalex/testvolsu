<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\BackendUser;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrapper" style="display: inline-block; min-width: 100%">
<?php    
if(!Yii::$app->user->isGuest){
echo "<div class='container'>";
//NavBar::begin();



        echo  '<div class="nav-left" style="float: left;"> <h4>'.  htmlspecialchars(BackendUser::findOne(Yii::$app->user->identity->id)->getFIO()) . '</h4></div>';
        

            echo '<div class="nav-right" style="float: right;">'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->login . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</div>';
//NavBar::end();
echo "</div>";   
}
    ?>

<div class="container">
<?= 
   Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
   ]) 
?>

    <?= Alert::widget() ?>
    <?= $content ?>
</div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
