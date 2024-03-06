<?php

use app\models\Requests;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\RequestsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Requests', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'description:ntext',
            'admin_message:ntext',
            'missing_date',
            //'user_id',
            'status',
            [
                'attribute'=> 'update admin_message',
                'format'=> 'raw',
                'visible' => (Yii::$app->user->identity->role_id == '1')?true:false,
                'value'=> function ($model) {
                    $html = Html::beginForm(Url::to(['update', 'id' => $model->id])); 
                    if($model->status_id == '2') {
                        $html .= Html::a('Update', Url::to('requests/update', true), ['class' => 'btn btn-primary']);
                    }
                    $html .= Html::endForm();
                    return $html;    
                }
            ],
            [
                'attribute'=> 'change status',
                'format'=> 'raw',
                'visible' => (Yii::$app->user->identity->role_id == '1')?true:false,
                'value'=> function ($model) {
                    $html = Html::beginForm(Url::to(['update', 'id' => $model->id])); 
                    if($model->status_id == '1') {
                        $html .= Html::activeDropDownList($model, 'status_id', [
                            2 => 'Принята',
                            3 => 'Отклонена',
                        ],
                        [
                            'prompt' => [
                                'text'=> 'В обработке',
                                'options' => [
                                    'value'=> '1',
                                    'style'=> 'display: none',
                                ]
                            ]
                        ]);
                        $html .= Html::submitButton('Принять', ['class' => 'btn btn-link']);
                    }
                    else if($model->status_id == '2') {
                        $html .= Html::activeDropDownList($model, 'status_id', [
                            4 => 'Найден',
                            3 => 'Не найден',
                        ],
                        [
                            'prompt' => [
                                'text'=> 'Принята',
                                'options' => [
                                    'value'=> '2',
                                    'style'=> 'display: none',
                                ]
                            ]
                        ]);
                        $html .= Html::submitButton('Принять', ['class' => 'btn btn-link']);
                    }
                    $html .= Html::endForm();
                    return $html;    
                }
            ],
        ],
    ]); ?>


</div>
