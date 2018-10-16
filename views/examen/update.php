<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Examen $model
 */

$this->title = 'Editar Examen: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Examens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="examen-update col-md-6 col-md-offset-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
