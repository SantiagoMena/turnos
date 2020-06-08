<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
        <h4><?= null//Html::encode($this->title) ?></h4>
        <?php if($empresa): ?>
        <h4>Link externo para clientes:</h4>
        <h4><?= Html::a(Url::to(['turno/agendar', 'id'=>$empresa->id], true),
                            Yii::$app->urlManager->createUrl(['turno/agendar', 'id'=>$empresa->id]),
                            ['title' => Yii::t('yii', 'Nuevo Turno Publico'),]
                        ); ?></h4>
        <h4>Código de inserción para webs:</h4>
        <code>&lt;iframe src=&quot;<?php echo Url::to(['turno/agendar', 'id'=>$empresa->id], true) ?>&quot; style=&quot;border:0px #ffffff none;&quot; name=&quot;desligar.me&quot; scrolling=&quot;yes&quot; frameborder=&quot;0&quot; marginheight=&quot;0px&quot; marginwidth=&quot;0px&quot; height=&quot;100%&quot; width=&quot;50%&quot; allowfullscreen&gt;&lt;/iframe&gt;</code>
        <?php endif; ?>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Turno', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => false,
        // 'filterModel' => $searchModel,
        'emptyText' => 'No se encontraron resultados.',
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            // [
            //     'attribute' => 'fecha',
            //     'filter' => DatePicker::widget([
            //         // 'name' => 'TurnoSearch[fecha]',
            //         'attribute' => 'fecha',
            //         'model' => $searchModel,
            //         'type' => DatePicker::TYPE_COMPONENT_PREPEND,
            //         // 'value' => '23-Feb-1982',
            //         'language' => 'es',
            //         'pluginOptions' => [
            //             'autoclose'=>true,
            //             'format' => 'yyyy-mm-dd'
            //         ]
            //     ]),
            //     // 'format' => [
            //     //     'datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'Y-m-d H:i:s']
            // ],
            // ['attribute'=>'empresa', 'value' => 'empresa.nombre'],
            // 'cedula',
            [
                'attribute' => 'desde',
                'filter' => false,
            ],
            [
                'attribute' => 'hasta',
                'filter' => false,
            ],
            'dato.nombre',
            'servicios',
            'dato.telefono', 
            'dato.correo', 
            // 'dato.cargo', 
            'dato.documento', 
            // [
            //     'attribute' => 'dato.adjunto',
            //     'format' => 'raw',    
            //     'filter' => false,
            //     'value' => function ($model) {
            //         return $model->dato->adjunto ? Html::a(
            //                 '<span class="glyphicon glyphicon-download"></span>', 
            //                 Url::to('@web/uploads').'/'.$model->dato->adjunto, 
            //                 ['target' => '_blank', 'class' => 'btn btn-success center-block',  'data-pjax'=>"0"]
            //             ) : NULL;
            //     },
            // ],
            [
                'attribute' => 'estado',
                'format' => 'raw',    
                'filter' => false,
                'value' => function ($model) {
                    return '<form id="form-estado'.$model->id.'" method="get" action="'.Url::to(['turno/estado'], true).'" >'.
                            Html::dropDownList('estado', $model->estado, 
                                [
                                    'Pendiente' => 'Pendiente', 
                                    'Confirmado' => 'Confirmado', 
                                    'Cancelado' => 'Cancelado', 
                                    'Activo' => 'Activo', 
                                    'Concluido' => 'Concluido', 
                                    'Reprogramado' => 'Reprogramado'
                                ], [
                                'id'=>'estado-'.$model->id,
                            ]).
                            Html::hiddenInput('id', $model->id).
                            Html::submitButton('Cambiar')
                            .'</form>';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Acciones',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['turno/update', 'id' => $model->id/*, 'edit' => 't'*/]),
                            ['title' => Yii::t('yii', 'Edit'),]
                        );
                    },
                    'adjunto'=>function ($url, $model) {
                        return Html::a(
                            '<span class="fa fa-list-alt"></span>', 
                            Url::to('@web/uploads').'/'.$model->dato->adjunto, 
                            ['data-request-method'=>"get"]
                        );
                    },
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => '¿Está seguro de eliminar el turno #'.$model->id.'?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
                'template'=>'{view} {delete}'
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
            // 'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Limpiar Lista', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
