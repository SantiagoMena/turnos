<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\file\FileInput;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 * @var dektrium\user\Module $module
 */

$this->title = Yii::t('user', 'Registrarse');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($modelEmpresa, 'nombre') ?>

                <?= $form->field($model, 'email')->label('Correo') ?>

                <?= $form->field($model, 'username')->label('Usuario') ?>
                <div>
                <?= $form->field($modelEmpresa, 'logo')->widget(FileInput::classname(), [
                        'language'      => 'es',
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => [
                            'showCaption' => false,
                            'showRemove' => true,
                            'showUpload' => false,
                            'previewFileType' => 'image',
                            'initialPreview'=> $modelEmpresa->logo ? [
                                '<img style="width: 100%;" src="'.$modelEmpresa->logo.'" class="file-preview-image">',
                            ] : '',
                            'initialCaption'=> $modelEmpresa->logo,
                            'layoutTemplates' => ['actions'=>''],
                        ],
                    ]); ?>
                
                </div>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput()->label('Clave') ?>
                <?php endif ?>

                <?= Html::submitButton(Yii::t('user', 'Registrarse'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Se encuentra registrado? Ingresa!'), ['/user/security/login']) ?>
        </p>
    </div>
</div>
