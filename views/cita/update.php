<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Cita $model
 */

$this->title = 'Editar Cita: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Citas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editr';
?>
<div class="cita-update col-md-6 col-md-offset-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
