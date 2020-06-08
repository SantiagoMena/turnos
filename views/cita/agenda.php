<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\CitaSearch $searchModel
 */

$this->title = 'Citas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cita-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Cita', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'emptyText' => 'No se encontraron resultados.',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute' => 'fecha',
                'filter' => DatePicker::widget([
                    // 'name' => 'CitaSearch[fecha]',
                    'attribute' => 'fecha',
                    'model' => $searchModel,
                    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                    // 'value' => '23-Feb-1982',
                    'language' => 'es',
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]),
                // 'format' => [
                //     'datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'Y-m-d H:i:s']
            ],
            // ['attribute'=>'empresa', 'value' => 'empresa.nombre'],
            'empresa',
            'cedula',
            'nombre',
            'examenes',
//            'telefono', 
//            'correo', 
//            'cargo', 
//            'documento', 
            [
                'attribute' => 'documento',
                'format' => 'raw',    
                'filter' => false,
                'value' => function ($model) {
                    return $model->documento ? Html::a(
                            '<span class="glyphicon glyphicon-download"></span>', 
                            $model->documento,
                            ['target' => '_blank', 'class' => 'btn btn-success center-block',  'data-pjax'=>"0"]
                        ) : NULL;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['cita/update', 'id' => $model->id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Edit'),]
                        );
                    },
                    'documento'=>function ($url, $model) {
                        return Html::a(
                            '<span class="fa fa-list-alt"></span>', 
                            $model->documento, 
                            ['data-request-method'=>"get"]
                        );
                    },
                ],
                // 'template'=>'{view} {edit} {documento} {delete}'
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            // 'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Agregar', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Limpiar Lista', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
