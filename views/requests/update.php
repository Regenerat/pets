<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Requests $model */

$this->title = 'Update Requests: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="requests-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_updateForm', [
        'model' => $model,
    ]) ?>

</div>
