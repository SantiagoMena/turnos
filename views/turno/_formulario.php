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
$url = Url::to(['turno/render-date-picker-dias-por-semana']);
//OnChange fecha, mostrar turnos
$this->registerJs(
    "
    var turno_servicios = $('#turno-servicio_id');
    turno_servicios.change(function() {
        var contenedor_fecha = $('#contenedor-fecha');
        contenedor_fecha.html('');
        $.get( \"$url\"+'/?id='+turno_servicios.val(), function( data ) {
            contenedor_fecha.html(data);
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
     $form->field($model, 'servicio_id')->widget
                            (
                                Select2::classname(),
                                [
                                    'data'          =>ArrayHelper::map(
                                        Servicio::find()->joinWith(['categoria'])->where(['categoria.empresa_id'=>$model->empresa_id])->all(), 'id','nombre','categoria.nombre'),
                                    'language'      => 'es',
                                    'options'       => ['placeholder' => 'Seleccione el servicio...','multiple' => false],
                                    'pluginOptions' => 
                                    [
                                        'allowClear' => false,'multiple' => false
                                    ],
                                ]
                            )
                            ->Label('Servicio');
    ?>
    
    <div id="contenedor-fecha" class="col-md-4 col-md-offset-4">
    
    </div>
    <?=
        Form::widget([

            'model' => $modelDato,
            'form' => $form,
            'columns' => 1,
            'attributes' => [

                'documento' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Documento...', 'maxlength' => 255]],

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
    <?php


    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Editar'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
