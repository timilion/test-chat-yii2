<?php
/* @var $this yii\web\View */
/** @var TYPE_NAME $dataProvider */

use yii\grid\GridView;

$this->title = 'Некорректные сообщения';

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'user.login',
        [
            'attribute' => 'text',
            'label' => 'Сообщения'
        ],
        [
            'attribute' => 'created_at',
            'label' => 'Создано',
            'value' => function($model) {
                return Yii::$app->formatter->asDatetime($model->created_at);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
        ],
    ],
]); ?>