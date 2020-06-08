<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\TurnoSearch $searchModel
 */

$this->title = 'Turnos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turno-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Turno', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?=
    Html::a('<i class="glyphicon glyphicon-plus"></i> Agregar', ['create'], ['class' => 'btn btn-success'])
    ?>

</div>
