<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $type app\models\CarType */

$this->title = 'Create Car';
$this->params['breadcrumbs'][] = ['label' => 'Cars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'type' => $type,
    ]) ?>

</div>
