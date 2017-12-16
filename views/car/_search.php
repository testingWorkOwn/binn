<?php

use app\helpers\CarHelper;
use app\models\Car;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'categoryId')->dropDownList(['' => ''] + Car::CATEGORY_ID) ?>

    <div class="col-md-12 form-inline">
        <div class="col-md-6">
            <label class="col-md-12">Цена</label>
            <?= $form->field($model, 'fromPrice')->input('number')->label('От') ?>
            <?= $form->field($model, 'toPrice')->input('number')->label('До') ?>
        </div>
        <div class="col-md-6">
            <label class="col-md-12">Год выпуска</label>
            <?= $form->field($model, 'fromYear')->dropDownList(['' => ''] + CarHelper::getYearDropDown())->label('От') ?>
            <?= $form->field($model, 'toYear')->dropDownList(['' => ''] + CarHelper::getYearDropDown())->label('До') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', [''], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
