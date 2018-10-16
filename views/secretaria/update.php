<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Secretaria $model
 */

$this->title = 'Editar Secretaria: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Secretarias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="secretaria-update col-md-6 col-md-offset-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
