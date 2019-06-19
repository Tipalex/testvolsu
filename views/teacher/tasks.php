<?php 
use yii\db\Query;
$this->title = 'Задания';
$this->params['breadcrumbs'][] = ['label' => $this->title];
?>

<?php


echo yii\grid\GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
    	['header' => 'Название задания', 'attribute' => 'name'],
    	['header' => 'Дисциплина',
    		'attribute' => 'discipline',
    		'format' => 'raw',
    		'value' => function ($model) {
    			$Query = new Query;
    			$result = $Query->select('name')->from('discipline')->where(['id' => $model->discipline])->one();
        		return print_r($result['name'], true);
      		},

    	],
        ['header' => 'Вступление', 'attribute' => 'description'],
        ['attribute' => 'Приложение',
            'format' => 'raw',
            'value' => function ($model) {
                if(isset($model->filePath))
                return "<a href = '?r=teacher/getfile&name=$model->filePath'><button type='button' class='btn btn-primary'>". substr($model->filePath, 8) ."</button> </a>";
                else return "Отсутствует";
            },

        ],
    	['attribute' => 'Редактировать',
    		'format' => 'raw',
    		'value' => function ($model) {
        		return "<a href = '?r=teacher/editetask&id=$model->id'><button type='button' class='btn btn-primary'> Редактировать </button> </a>";
      		},

    	],

        ['attribute' => 'Удалить',
            'format' => 'raw',
            'value' => function ($model) {
                return "<a href = '?r=teacher/deletetask&id=$model->id'><button type='button' class='btn btn-danger'> Удалить </button> </a>";
            },

        ],
    ]
]);
?>
<a href = "?r=teacher/createtask"><button type="button" class="btn btn-primary"> Добавить задание </button> </a>