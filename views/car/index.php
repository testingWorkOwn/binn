<?php

use app\models\Car;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var $model Car */

$this->title = 'Cars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <table class="table">
        <tr>
            <td><?= 'Название' ?></td>
            <td><?= 'Модельный ряд' ?></td>
            <td><?= 'Цена' ?></td>
            <td><?= 'Год выпуска' ?></td>
        </tr>
        <?php foreach ($dataProvider->getModels() as $model): ?>
            <tr>
                <td><?= $model->title ?></td>
                <td><?= $model->getCategory() ?></td>
                <td><?= $model->price ?></td>
                <td><?= $model->year ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
