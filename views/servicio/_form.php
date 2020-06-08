<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Categoria;
use kartik\datetime\DateTimePicker;
use yii\web\View;

/**
 * @var yii\web\View $this
 * @var app\models\Servicio $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="servicio-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'nombre' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter Nombre...', 'maxlength' => 255]],

        ]

    ]);
    $where = $empresa_id ? ['empresa_id' => $empresa_id] : true;

    ?>
    <?=
        $form->field($model, 'categoria_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Categoria::find()->where($where)->all(), 'id', 'nombre'),
            'language' => 'es',
            'options' => ['placeholder' => 'Seleccione una categoría ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>
    <?= $form->field($model, 'siempre_habil')->checkBox([
      'onChange' => new yii\web\JsExpression('
            (function(item){
                var habil_desde = $("#servicio-habil_desde");
                var habil_hasta = $("#servicio-habil_hasta");

                if(item.checked){
                    habil_desde.val(null).trigger("change");
                    habil_hasta.val(null).trigger("change");
                    habil_desde.attr("readonly", true);
                    habil_hasta.attr("readonly", true);
                } else {
                    habil_desde.attr("readonly", false);
                    habil_hasta.attr("readonly", false);
                }
            })(this);
          '),
    ]) ?>
    <?=
        $form->field($model, 'habil_desde')->widget(DateTimePicker::classname(), [
            'language' => 'es',
            // 'disabled' => $model->siempre_habil,
            'options' => [
                'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                // 'pluginOptions' => [
                //     'format' => 'dd-mm-yyyy',
                //     'startDate' => date('d-m-Y', strtotime('NOW')),
                //     'language' => "es",
                //     'todayHighlight' => true,
                // ],
            ], 
        ]);
    ?>
    <?=
        $form->field($model, 'habil_hasta')->widget(DateTimePicker::classname(), [
            'language' => 'es',
            // 'disabled' => $model->siempre_habil,
            'options' => [
                // 'type' => DatePicker::TYPE_COMPONENT_APPEND,
                // 'pluginOptions' => [
                //     'format' => 'dd-mm-yyyy',
                //     'startDate' => date('d-m-Y', strtotime('NOW')),
                //     'language' => "es",
                //     'todayHighlight' => true,
                // ],
            ], 
        ]);
    ?>
    
    <?= $this->render('_select_tipo_reserva', [
        'modelConfigReserva' => $modelConfigReserva,
        'form' => $form
    ]) ?>

    <div class="" id="formulario-dias-por-semana">
        <?= $this->render('_formulario_dias_por_semana', [
            'modelSemanaReserva' => $modelSemanaReserva,
        ]) ?>
    </div>

    <div class="row">
        <?= $this->render('_formulario_turno', [
            'modelConfigTurno' => $modelConfigTurno,
            'form' => $form
        ]) ?>
    </div>
    <?php
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Crear') : Yii::t('app', 'Editar'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>


<?php $script = "
$('#formulario-dias-por-semana').hide();
";
$this->registerJs($script, View::PH_BODY_BEGIN); 
?>

<?php $script = "

var tipo = $('#configreserva-tipo');
if(tipo.val() !== 'Dias por semana')
    $('#formulario-dias-por-semana').hide();

var siempre_habil = $('#servicio-siempre_habil');
var habil_desde = $('#servicio-habil_desde');
var habil_hasta = $('#servicio-habil_hasta');
if(siempre_habil.attr('checked')){
    habil_desde.val(null).trigger('change');
    habil_hasta.val(null).trigger('change');
    habil_desde.attr('readonly', true);
    habil_hasta.attr('readonly', true);
} else {
    habil_desde.attr('readonly', false);
    habil_hasta.attr('readonly', false);
}
";
$this->registerJs($script, View::POS_READY); 
?>
