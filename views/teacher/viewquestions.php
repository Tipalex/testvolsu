<?php 
use yii\db\Query;

$this->title = "Вопросы";
$this->params['breadcrumbs'][] = ['label' => 'Тестирования', 'url' => "?r=teacher/tests"];
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>


<?php

echo yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
    	['header' => 'Вопрос', 'attribute' => 'question'],
        ['header' => 'Тип ответа',
         'attribute' => 'type',
         'value' => function ($model) {
                switch($model->type){
                  case 'select_single':
                   $ret = 'Выбор одного ответа';
                   break;
                  case 'single_multiple':
                   $ret = 'Выбор несколько ответов';
                   break;
                  case 'yes_no':
                   $ret = 'Выбор одного ответа';
                   break;
                  default :
                    $ret ='Ввод ответа вручную';
                    break;
                  }
                  return $ret;
        },
        ],
    	['attribute' => 'Варианты ответов',
    		'format' => 'raw',
    		'value' => function ($model) {if($model->type !='write')
        		return "<a href = '?r=teacher/viewanswers&quest=$model->id&test=".$_GET['test']."'><button type='button' class='btn btn-primary'> Просмотр </button> </a>";
            else return "Нет вариантов ответа";
      		},

    	],

        ['attribute' => 'Редактировать',
            'format' => 'raw',
            'value' => function ($model) {
                return "<a href = '?r=teacher/createquestion&test=".$_GET['test']."&question=$model->id'><button type='button' class='btn btn-primary'> Редактировать </button> </a>";
            },

        ],

        ['attribute' => 'Удалить',
            'format' => 'raw',
            'value' => function ($model) {
                return "<a href = '?r=teacher/deletequestion&id=$model->id'><button type='button' class='btn btn-danger'> Удалить </button> </a>";
            },

        ],

    	
    ]
]);

?>

<a href = "?r=teacher/createquestion&test=<?=$_GET['test']?>"><button type="button" class="btn btn-primary"> Добавить вопрос </button> </a>