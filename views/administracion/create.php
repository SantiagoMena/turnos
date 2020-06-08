<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var app\models\Administracion $model
 */

$this->title = 'Crear Administracion';
$this->params['breadcrumbs'][] = ['label' => 'Administracion', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="administracion-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'user' => $user,
        'usuario' => $usuario,
    ]) ?>

</div>
