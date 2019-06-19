<?php 
use yii\db\Query;
$this->title = "Ответы";
$this->params['breadcrumbs'][] = ['label' => 'Тестирования', 'url' => "?r=teacher/tests"];
$this->params['breadcrumbs'][] = ['label' => 'Вопросы', 'url' => "?r=teacher/viewquestions&test=".$_GET['test']];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<a href = "?r=teacher/createanswer&quest=<?=$_GET['quest']?>&test=<?=$_GET['test']?>"><button type="button" class="btn btn-primary"> Добавить ответ </button> </a>


<?php


echo yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
    	['header' => 'Ответ', 'attribute' => 'answer'],
        ['attribute' => 'Редактировать',
            'format' => 'raw',
            'value' => function ($model) {
                return "<a href = '?r=teacher/createanswer&quest=".$_GET['quest']."&answer=$model->id&test=".$_GET['test']."'><button type='button' class='btn btn-primary'> Редактировать </button> </a>";
            },

        ],
    	['attribute' => 'Удалить',
            'format' => 'raw',
            'value' => function ($model) {
                return "<a href = '?r=teacher/deleteanswer&id=$model->id'><button type='button' class='btn btn-danger'> Удалить </button> </a>";
            },

        ],
    ]
]);