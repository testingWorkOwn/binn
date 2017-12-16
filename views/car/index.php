<?php

use app\helpers\CarHelper;
use app\models\Car;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Car', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
                'attribute' => 'categoryId',
                'filter' => Car::CATEGORY_ID,
                'value' => function (Car $model) {
                    return $model->getCategory();
                },
            ],
            'price',
            [
                'attribute' => 'year',
                'filter' => CarHelper::getYearDropDown()
            ],
            [
                'attribute' => 'status',
                'filter' => Car::STATUS,
                'value' => function (Car $model) {
                    return $model->getStatus();
                }
            ],
            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'options' => [
                        'class' => 'form-control',
                    ],
                    'attribute' => 'created_at',
                    'dateFormat' => 'php:Y-m-d',
                ]),
                'format' => 'datetime',
            ],
            [
                'attribute' => 'updated_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'options' => [
                        'class' => 'form-control',
                    ],
                    'attribute' => 'updated_at',
                    'dateFormat' => 'php:Y-m-d',
                ]),
                'format' => 'datetime',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
