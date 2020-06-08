<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Turno $model
 */

$this->title = 'Agendar Turno';
// $this->params['breadcrumbs'][] = ['label' => 'Turnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $modelEmpresa->nombre;
?>
<div class="turno-create col-md-6 col-md-offset-3">
    <div class="page-header">
        <center><h1><?= Html::encode($this->title) ?></h1>
        <?= Html::img('@web/uploads/'.$modelEmpresa->logo, ['alt' => 'Turnos', 'class' => "img-responsive"]); ?></center>
    </div>
    <?= $this->render('_formPublico', [
        'model' => $model,
        'modelDato' => $modelDato,
        'modelEmpresa' => $modelEmpresa,
    ]) ?>

</div>
