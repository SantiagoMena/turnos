<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Servicio $model
 */

$this->title = 'Crear Servicio';
$this->params['breadcrumbs'][] = ['label' => 'Servicios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servicio-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <h2><?= !empty($errros) ? json_encode($errors) : null ?></h2>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'empresa_id' => $empresa_id,
        'modelConfigReserva' => $modelConfigReserva,
        'modelConfigTurno' => $modelConfigTurno,
        'modelSemanaReserva' => $modelSemanaReserva,
    ]) ?>

</div>
