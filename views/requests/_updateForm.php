<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Requests $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="requests-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'admin_message')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
