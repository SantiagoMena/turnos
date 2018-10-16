<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
// use dosamigos\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Empresa;
use app\models\Categoria;
use app\models\Examen;
use yii\helpers\Url;
use kartik\file\FileInput;
/**
 * @var yii\web\View $this
 * @var app\models\Cita $model
 * @var yii\widgets\ActiveForm $form
 */
$url = Url::to(['cita/horarios']);
//OnChange fecha, mostrar turnos
$this->registerJs(
    "
    $('#cita-fecha-disp-kvdate').parent().append('<div id=\"horarios\"></div>');
    $( '#cita-fecha' ).change(function() {
        $('#horarios').html('');
        $.get( \"$url?fecha=\"+$( '#cita-fecha' ).val(), function( data ) {
          $('#horarios').html(data);
        });
    });

    ",
    $this::POS_READY,
    'my-button-handler'
);
?>

<div class="cita-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); 
    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'fecha' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),
            'options' => [
                'type' => DateControl::FORMAT_DATE,
                ], 
                'visible'=>$model->isNewRecord
            ],

            // 'empresa_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Empresa ID...']],

            'cedula' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Cedula...', 'maxlength' => 255]],

            'nombre' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Nombre...', 'maxlength' => 255]],

            'telefono' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Telefono...', 'maxlength' => 255]],

            'correo' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Correo...', 'maxlength' => 255]],

            'cargo' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Cargo...', 'maxlength' => 255]],

            // 'documento' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Documento...', 'maxlength' => 255]],

        ]

    ]);
    ?>


    <div>
    <?= $form->field($model, 'documento')->widget(FileInput::classname(), [
            'options' => ['accept' => '*'],
            'language'      => 'es',
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => true,
                'showUpload' => false,
                // 'previewFileType' => 'image',
                // 'initialPreview'=> $model->logo ? [
                //     '<img style="width: 100%;" src="'.$model->logo.'" class="file-preview-image">',
                // ] : '',
                'initialCaption'=> $model->documento,
                'layoutTemplates' => ['actions'=>''],
            ],
        ]); ?>
    </div>
    <?= 
     $form->field($model, 'examenes')->widget
                            (
                                Select2::classname(),
                                [
                                    'data'          =>ArrayHelper::map(
                                        Examen::find()->joinWith('categoria')->all(), 'id','nombre','categoria.nombre'),
                                        // Examen::find()->joinWith('categoria')->select(['categoria.nombre AS categoria_nombre','examen.nombre AS examen_nombre'])->all(), 'id', 'categoria_nombre','examen_nombre'),
                                    'language'      => 'es',
                                    'options'       => ['placeholder' => 'Seleccione examenes...','multiple' => true],
                                    'pluginOptions' => 
                                    [
                                        'allowClear' => false,'multiple' => true
                                    ],
                                ]
                            )
                            ->Label('Examenes');
        // Select2::widget([
        //         'name' => 'examenes',
        //         'id'=>'examenes',
        //         'data' =>ArrayHelper::map(Examen::find()->joinWith('categoria')->select(['categoria.nombre AS categoria_nombre','examen.nombre AS examen_nombre'])->all(), 'id', 'categoria_nombre','examen_nombre'),
        //         'options' => [
        //             'placeholder' => 'Seleccione examenes ...',
        //             'multiple' => true,
        //         ],
        //     ]);
    ?>
    <?php
    $user_id =Yii::$app->user->id;
    if( in_array('admin', array_keys(\Yii::$app->authManager->getRolesByUser($user_id))) ){
        // Solo el admin ve este campo
        echo $form->field($model, 'empresa_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Empresa::find()->all(), 'id', 'nombre'),
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione una empresa ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    }


    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Editar'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
