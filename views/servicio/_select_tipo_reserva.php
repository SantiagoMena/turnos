<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
<div class='col-md-12'>
    <?=
    $form->field($modelConfigReserva, 'tipo')->widget(Select2::classname(), [
        'data' => [
            'Dias por semana' => 'Dias por semana',
            // 'Rango de dias' => 'Rango de dias',
            // 'Dias en especifico' => 'Dias en especifico',
        ],
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        'options' => [
            'placeholder' => 'Seleccione un tipo de reserva ...',
            'multiple' => false,
        ],
    ])->label('Tipo de Reserva');
    // Select2::widget([
    //     'model' => $modelConfigReserva,
    //     'attribute' => 'tipo',
    //     'data' => [
    //         'Dias por semana' => 'Dias por semana',
    //         // 'Rango de dias' => 'Rango de dias',
    //         // 'Dias en especifico' => 'Dias en especifico',
    //     ],
    //     'options' => [
    //         'placeholder' => 'Seleccione un tipo de reserva ...',
    //         'multiple' => false,
    //     ],
    // ]);
    ?>
</div>
<?php

//OnChange fecha, mostrar turnos
$this->registerJs(
    "
    var tipo = $('#configreserva-tipo');
    var dias_por_semana = $('#formulario-dias-por-semana');
    tipo.change(function() {
        if(tipo.val() === 'Dias por semana')
            dias_por_semana.show();
    });

    ",
    $this::POS_READY,
    'my-button-handler'
);
?>