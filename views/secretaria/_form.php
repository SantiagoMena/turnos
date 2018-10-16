<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Empresa;
use app\models\User;

/**
 * @var yii\web\View $this
 * @var app\models\Secretaria $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="secretaria-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            // 'user_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter User ID...']],

            // 'empresa_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Empresa ID...']],

            'correo' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Correo...', 'maxlength' => 255]],

            'nombre' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Nombre...', 'maxlength' => 255]],

            'telefono' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Telefono...', 'maxlength' => 255]],

        ]

    ]);

    $user_id =Yii::$app->user->id;
    if( in_array('admin', array_keys(\Yii::$app->authManager->getRolesByUser($user_id))) ){
        echo $form->field($model, 'empresa_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Empresa::find()->all(), 'id', 'nombre'),
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione una empresa ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    }
    ?>

    <?= $form->field($user, 'username') ?>
    <?= $form->field($user, 'password')->passwordInput() ?>
    <?php
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Editar'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
