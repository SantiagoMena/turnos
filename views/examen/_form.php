<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Categoria;
/**
 * @var yii\web\View $this
 * @var app\models\Examen $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="examen-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            // 'categoria_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Categoria ID...']],

            'nombre' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Ingrese Nombre...', 'maxlength' => 255]],

        ]

    ]);
    echo $form->field($model, 'categoria_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Categoria::find()->all(), 'id', 'nombre'),
        'language' => 'es',
        'options' => ['placeholder' => 'Seleccione una categoría ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Editar'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
