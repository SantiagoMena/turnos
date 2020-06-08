<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Administracion $model
 */

$this->title = 'Editar Administracion: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Administracion', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="administracion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
