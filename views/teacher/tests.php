<?php 
use yii\db\Query;
$this->title = 'Тестирования';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>


<?php


echo yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
    	['header' => 'Название теста', 'attribute' => 'name'],
    	['header' => 'Дисциплина',
    		'attribute' => 'discipline',
    		'format' => 'raw',
    		'value' => function ($model) {
    			$Query = new Query;
    			$result = $Query->select('name')->from('discipline')->where(['id' => $model->discipline])->one();
        		return print_r($result['name'], true);
      		},

    	],
    	['header' => 'Длительность теста', 'attribute' =>'time'],
        ['attribute' => 'Вопросы',
            'format' => 'raw',
            'value' => function ($model) {
                return "<a href = '?r=teacher/viewquestions&test=$model->id'><button type='button' class='btn btn-primary'> Вопросы </button> </a>";
            },

        ],
    	['attribute' => 'Редактировать',
    		'format' => 'raw',
    		'value' => function ($model) {
        		return "<a href = '?r=teacher/edittest&id=$model->id'><button type='button' class='btn btn-primary'> Редактировать </button> </a>";
      		},

    	],

        ['attribute' => 'Удалить',
            'format' => 'raw',
            'value' => function ($model) {
                return "<a href = '?r=teacher/deletetest&id=$model->id'><button type='button' class='btn btn-danger'> Удалить </button> </a>";
            },

        ],
    ]
]);
?>
<a href = "?r=teacher/createtest"><button type="button" class="btn btn-primary"> Добавить тест </button> </a>