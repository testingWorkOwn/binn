<?php


use app\models\Car;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $type \app\models\CarType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($type, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($type, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($type, 'categoryId')->dropDownList(Car::CATEGORY_ID) ?>

    <?php if (!$type->model->isNewRecord): ?>
        <img src="<?= $type->model->getUrlImage(); ?>" alt="">
    <?php endif; ?>

    <?= $form->field($type, 'image')->fileInput() ?>

    <?= $form->field($type, 'price')->input('number') ?>

    <?= $form->field($type, 'year')->input('number') ?>


    <?= $form->field($type, 'status')->dropDownList(Car::STATUS) ?>

    <div class="form-group">
        <?= Html::submitButton($type->model->isNewRecord ? 'Create' : 'Update', ['class' => $type->model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
