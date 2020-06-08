<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\ServicioSearch $searchModel
 */

$this->title = 'Servicios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servicio-index">
    <div class="page-header">
        <h1><?= null//Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Servicio', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => 'No se encontraron resultados.',
        // 'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute' => 'nombre',
                'filter' => false,
            ],
            // [
            //     'label' => 'Categoria',
            //     'attribute' => 'categoria_id',
            //     'value' => 'categoria.nombre',
            //     'filter' => false,
            // ],
            // [
            //     'attribute' => 'siempre_habil',
            //     'value' =>  function($model){
            //         return $model->getSiempreHabilString();
            //     },
            //     'filter' => false,
            // ],
            // [
            //     'attribute' => 'habil_desde',
            //     'filter' => false,
            // ],
            // [
            //     'attribute' => 'habil_hasta',
            //     'filter' => false,
            // ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['servicio/update', 'id' => $model->id/*, 'edit' => 't'*/]),
                            ['title' => Yii::t('yii', 'Editar'),]
                        );
                    },
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => '¿Está seguro de eliminar el servicio: '.$model->nombre.'?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
                'template'=>'{update} {view} {delete}',
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Crear Servicio', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Refrescar Lista', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
