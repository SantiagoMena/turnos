<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Secretaria $model
 */

$this->title = 'Crear Secretaria';
$this->params['breadcrumbs'][] = ['label' => 'Secretarias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="secretaria-create col-md-6 col-md-offset-3">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'user' => $user,
    ]) ?>

</div>
