<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Turno $model
 */

$this->title = 'Crear Turno';
$this->params['breadcrumbs'][] = ['label' => 'Turnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turno-create col-md-6 col-md-offset-3">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'modelDato' => $modelDato,
    ]) ?>

</div>
