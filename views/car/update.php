<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $type \app\models\CarType */

$this->title = 'Update Car: ' . $type->title;
$this->params['breadcrumbs'][] = ['label' => 'Cars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $type->title, 'url' => ['view', 'id' => $type->model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="car-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'type' => $type,
    ]) ?>

</div>
