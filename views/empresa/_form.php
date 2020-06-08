<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
// use yii\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use Da\User\Model\User;
use kartik\file\FileInput;

/**
 * @var yii\web\View $this
 * @var app\models\Empresa $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="empresa-form">
    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'nombre' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Nombre...', 'maxlength' => 255]],

            // 'nit' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Nit...', 'maxlength' => 255]],

            'correo' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Correo...', 'maxlength' => 255]],

            // 'telefono' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Telefono...', 'maxlength' => 255]],

            // 'direccion' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Direccion...', 'maxlength' => 255]],

            // 'logo' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Logo...', 'maxlength' => 255]],

        ]

    ]);
    ?>
    <div>
    <?= $form->field($model, 'logo')->widget(FileInput::classname(), [
            'language'      => 'es',
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => true,
                'showUpload' => false,
                'previewFileType' => 'image',
                'initialPreview'=> $model->logo ? [
                    '<img style="width: 100%;" src="'.$model->logo.'" class="file-preview-image">',
                ] : '',
                'initialCaption'=> $model->logo,
                'layoutTemplates' => ['actions'=>''],
            ],
        ]); ?>
    </div>
    <?= $form->field($user, 'username') ?>
    <?= $form->field($user, 'password')->passwordInput() ?>
    <?php
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Editar'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); 

    ?>

</div>
