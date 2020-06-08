<?php
use yii\helpers\Html;
use yii\web\View;
// use yii\widgets\MaskedInput;
use kartik\widgets\TimePicker;
use kartik\form\ActiveField;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\file\FileInput;
?>

<div class="amenidad-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model->empresa, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model->empresa, 'correo')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model->empresa, 'logo')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'language' => 'es',
            'pluginOptions' => [
                'showCaption' => false,
                'showRemove' => true,
                'showUpload' => false,
                'previewFileType' => 'image',
                'initialPreview'=> $model->empresa->logo ? [
                    '<img style="width: 100%;height: 100%;" src="'.Url::to('uploads', true).'/'.$model->empresa->logo.'" class="file-preview-image">',
                ] : '',
                'initialCaption'=> $model->empresa->logo,
                'layoutTemplates' => ['actions'=>''],
                'dropZoneEnabled' => false,
            ],
        ]); 
    ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success' ]) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>