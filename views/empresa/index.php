<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\EmpresaSearch $searchModel
 */

$this->title = 'Empresas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-index">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Empresa', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'emptyText' => 'No se encontraron resultados.',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            [
                'attribute'=>'username', 
                'value' => 'usuario.user.username'],
            'nombre',
            'nit',
            'correo',
//            'telefono', 
//            'direccion', 
//            'logo', 

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'buttons' => [
                    'configurar' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['empresa/configurar', 'id' => $model->id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Configurar'),]
                        );
                    },
                ],
                'template'=>'{configurar} {view} {delete}'
            ],
            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'buttons' => [
            //         'update' => function ($url, $model) {
            //             return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
            //                 Yii::$app->urlManager->createUrl(['empresa/view', 'id' => $model->id, 'edit' => 't']),
            //                 ['title' => Yii::t('yii', 'Editar'),]
            //             );
            //         }
            //     ],
            // ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Agregar', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Limpiar Lista', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
