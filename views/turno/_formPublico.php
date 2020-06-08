<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use kartik\select2\Select2;
// use dosamigos\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Empresa;
use app\models\Categoria;
use app\models\Servicio;
use app\models\Dato;
use yii\helpers\Url;
use kartik\file\FileInput;
/**
 * @var yii\web\View $this
 * @var app\models\Turno $model
 * @var yii\widgets\ActiveForm $form
 */
$url = Url::to(['turno/horarios']);
//OnChange fecha, mostrar turnos
$this->registerJs(
    "
    $('#turno-fecha-kvdate').parent().append('<div id=\"horarios\"></div>');
    $( '#turno-fecha' ).change(function() {
        $('#horarios').html('');
        $.get( \"$url?id=$modelEmpresa->id&fecha=\"+$( '#turno-fecha' ).val(), function( data ) {
          $('#horarios').html(data);
        });
    });

    ",
    $this::POS_READY,
    'my-button-handler'
);
?>
<div class="turno-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); 
    ?>

    <?=
        Form::widget([

            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [

                'fecha' => [
                    'type' => Form::INPUT_WIDGET, 
                    'widgetClass' => DatePicker::classname(),
                    'visible'=>$model->isNewRecord,
                    'options' => [
                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'startDate' => /*'2017-01-01',*/date('d-m-Y', strtotime('NOW')),
                            /*'endDate' => '2017-02-03',*/
                            /*'format' => "dd/mm/yyyy",*/
                            'language' => "es",
                            // 'beforeShowDay'=>new yii\web\JsExpression('
                            // function (date){
                            //     var availableDates = '.$diasHabilesStr.';
                            //     var day = (date.getDate()) < 10 ? "0"+(date.getDate()) : (date.getDate());
                            //     var month = (date.getMonth() + 1) < 10 ? "0"+(date.getMonth() + 1) : (date.getMonth() + 1);
                            //     var dmy = date.getFullYear() + "-" + month + "-" + day;

                            //     if (availableDates.indexOf(dmy) > -1) {
                            //         return true;
                            //     } else {
                            //         return false;
                            //     }
                            // }
                            // '),
                            'daysOfWeekDisabled' => "0,1,2,4,6",
                            'daysOfWeekHighlighted' => "1,2,5,6",
                            'todayHighlight' => false,
                            /*'datesDisabled' => ['11/06/2016', '11/21/2016']*/
                        ],
                    ], 
                ],

            ]

        ]);
    ?>

    <?=
        Form::widget([

            'model' => $modelDato,
            'form' => $form,
            'columns' => 1,
            'attributes' => [

                'documento' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Cedula...', 'maxlength' => 255]],

                'nombre' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Nombre...', 'maxlength' => 255]],

                'telefono' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Telefono...', 'maxlength' => 255]],

                'correo' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Correo...', 'maxlength' => 255]],

                // 'cargo' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Cargo...', 'maxlength' => 255]],

            ]

        ]);
    ?>
    <div>
    <?= 
    NULL
    // $form->field($modelDato, 'adjunto')->widget(FileInput::classname(), [
    //         'options' => ['accept' => '*'],
    //         'language'      => 'es',
    //         'pluginOptions' => [
    //             'showCaption' => false,
    //             'showRemove' => true,
    //             'showUpload' => false,
    //             // 'previewFileType' => 'image',
    //             // 'initialPreview'=> $model->logo ? [
    //             //     '<img style="width: 100%;" src="'.$model->logo.'" class="file-preview-image">',
    //             // ] : '',
    //             'initialCaption'=> $modelDato->adjunto, //agregar url::to
    //             'layoutTemplates' => ['actions'=>''],
    //         ],
    //     ]); 
        ?>
    </div>
    <?= 
     $form->field($model, 'servicios')->widget
                            (
                                Select2::classname(),
                                [
                                    'data'          =>ArrayHelper::map(
                                        Servicio::find()->joinWith(['categoria'])->where(['categoria.empresa_id'=>$model->empresa_id])->all(), 'id','nombre','categoria.nombre'),
                                        // Servicio::find()->joinWith('categoria')->select(['categoria.nombre AS categoria_nombre','examen.nombre AS examen_nombre'])->all(), 'id', 'categoria_nombre','examen_nombre'),
                                    'language'      => 'es',
                                    'options'       => ['placeholder' => 'Seleccione servicios...','multiple' => false],
                                    'pluginOptions' => 
                                    [
                                        'allowClear' => false,'multiple' => false
                                    ],
                                ]
                            )
                            ->Label('Servicios');
    ?>
    <?php


    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Editar'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
