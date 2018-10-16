<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Cita $model
 */

$this->title = 'Crear Cita';
$this->params['breadcrumbs'][] = ['label' => 'Citas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cita-create col-md-6 col-md-offset-3">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
