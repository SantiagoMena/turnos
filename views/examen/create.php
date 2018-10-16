<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Examen $model
 */

$this->title = 'Crear Examen';
$this->params['breadcrumbs'][] = ['label' => 'Examens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="examen-create col-md-6 col-md-offset-3">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
