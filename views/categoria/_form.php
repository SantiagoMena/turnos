<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Empresa;

/* @var $this yii\web\View */
/* @var $model app\models\Categoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

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
    ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
