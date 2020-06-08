<?php

use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;
use yii\helpers\Url;
\yii\bootstrap\BootstrapPluginAsset::register($this);

$url = Url::to(['turno/horarios']);
//OnChange fecha, mostrar turnos
$this->registerJs(
    "
    $('#turno-fecha-kvdate').parent().append('<div id=\"horarios\"></div>');
    $( '#turno-fecha' ).change(function() {
        var url = '$url?id='+$('#turno-servicio_id').val()+'&fecha=';
        url += $('#turno-fecha').val();
        $('#horarios').html('');
        $.get( url, function( data ) {
          $('#horarios').html(data);
        });
    });

    ",
    $this::POS_READY,
    'my-button-handler'
);
?>
<div class="" style="width: 220px; border-radius: 3px; border: 1px solid;">
<?=
    DatePicker::widget([
        'name' => 'Turno[fecha]',
        'id' => 'turno-fecha',
        'type' => DatePicker::TYPE_INLINE,
        'language' => "es",
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'dd-M-yyyy',
            'startDate' => $startDate,
            'endDate' => $endDate,
            // 'beforeShowDay'=>new yii\web\JsExpression('
            // function (date){
            //     var availableDates = '.$diasHabilesStr.';
            //     var day = (date.getDate()) < 10 ? "0"+(date.getDate()) : (date.getDate());
            //     var month = (date.getMonth() + 1) < 10 ? "0"+(date.getMonth() + 1) : (date.getMonth() + 1);
            //     var dmy = date.getFullYear() + "-" + month + "-" + day;

            //     if (availableDates.indexOf(dmy) > -1) {
            //         return true;
            //     } else {
            //         return false;
            //     }
            // }
            // '),
            'daysOfWeekDisabled' => $diasNoHabiles,
            'daysOfWeekHighlighted' => $diasHabiles,
            'todayHighlight' => false,
        ]
    ]);
?>
</div>