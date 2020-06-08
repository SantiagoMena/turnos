<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Servicio $model
 */

$this->title = 'Editar Servicio: ' . ' ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="servicio-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <h2><?= !empty($errros) ? json_encode($errors) : null ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
        'empresa_id' => $empresa_id,
        'modelConfigReserva' => $modelConfigReserva,
        'modelConfigTurno' => $modelConfigTurno,
        'modelSemanaReserva' => $modelSemanaReserva,
    ]) ?>

</div>
