<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Car */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-md-12">
        <?= Html::img($model->getImageUrl()); ?>
        <ul class="list-group">
            <li class="list-group-item">Цена - <?= $model->price ?></li>
            <li class="list-group-item">Год выпуска - <?= $model->year ?></li>
            <li class="list-group-item">Модельный ряд - <?= $model->getCategory() ?></li>
        </ul>
    </div>

</div>
