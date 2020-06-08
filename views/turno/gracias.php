<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var app\models\Turno $model
 */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Turnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turno-view col-md-6 col-md-offset-3">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            // 'id',
            // [
            //     'attribute' => 'fecha',
            //     'format' => [
            //         'datetime', (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime']))
            //             ? Yii::$app->modules['datecontrol']['displaySettings']['datetime']
            //             : 'd-m-Y H:i:s A'
            //     ],
            //     'type' => DetailView::INPUT_WIDGET,
            //     'widgetOptions' => [
            //         'class' => DateControl::classname(),
            //         'type' => DateControl::FORMAT_DATETIME
            //     ]
            // ],
            // 'empresa_id',
            'documento',
            'nombre',
            'telefono',
            'correo',
            //'cargo',
            [
                'attribute' => 'estado',
                'value'=>$model->turno->estado,
            ],
            // 'documento',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
