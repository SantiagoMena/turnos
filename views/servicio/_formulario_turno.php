<?php

use kartik\helpers\Html;
use yii\web\View;
\yii\bootstrap\BootstrapPluginAsset::register($this);
use kartik\widgets\TimePicker;
?>
<div class="col-md-12"> 
    <div class="col-md-8 col-md-offset-4">
        <div class="form-group col-md-4">
            <label class="control-label">Desde</label>
            <?=
            TimePicker::widget([
                // 'name' => "Turno[desde]",
                'model' => $modelConfigTurno,
                'attribute' => 'desde',
                'addonOptions' => [
                    'asButton' => true,
                    'buttonOptions' => ['class' => 'btn btn-info']
                ],
                'pluginOptions' => [
                    'showMeridian' => false,
                ]
            ]);
            ?>
        </div>
        <div class="form-group col-md-4">
            <label class="control-label">Hasta</label>
            <?=
            TimePicker::widget([
                // 'name' => "Turno[hasta]",
                'model' => $modelConfigTurno,
                'attribute' => 'hasta',
                'addonOptions' => [
                    'asButton' => true,
                    'buttonOptions' => ['class' => 'btn btn-info'],
                ],
                'pluginOptions' => [
                    'showMeridian' => false,
                ]
            ])
            ?>
        </div>
    </div>
    <?= $form->field($modelConfigTurno, 'minutos_turno', [
            'addon' => [
                'prepend' => [
                    'content'=>Html::input('checkBox', 'todo_el_dia', null, [
                        'id'=>'todo_el_dia',
                        'checked' => is_null($modelConfigTurno->minutos_turno),
                        'onChange' => new yii\web\JsExpression('
                            (function(item){
                                var minutos_turno = $("#configturno-minutos_turno");
                                if(item.checked){
                                    minutos_turno.val(null).trigger("change");
                                    minutos_turno.attr("readonly", true);
                                } else {
                                    minutos_turno.attr("readonly", false);
                                }
                            })(this);
                        '),
                        ])
                            . Html::label('Todo el día')
                    ]
                ]
        ]);
    ?>
    <?= $form->field($modelConfigTurno, 'minutos_entre_turno', [
            'addon' => [
                'prepend' => [
                    'content'=>Html::input('checkBox', 'sin_entre_turno', null, [
                        'id'=>'sin_entre_turno',
                        'checked' => is_null($modelConfigTurno->minutos_entre_turno),
                        'onChange' => new yii\web\JsExpression('
                            (function(item){
                                var minutos_entre_turno = $("#configturno-minutos_entre_turno");
                                if(item.checked){
                                    minutos_entre_turno.val(null).trigger("change");
                                    minutos_entre_turno.attr("readonly", true);
                                } else {
                                    minutos_entre_turno.attr("readonly", false);
                                }
                            })(this);
                        '),
                        ])
                            . Html::label('Sin entre turno')
                    ]
                ]
        ]);
    ?>
    <?= $form->field($modelConfigTurno, 'cupos', [
            'addon' => [
                'prepend' => [
                    'content'=>Html::input('checkBox', 'cupos_abiertos', null, [
                        'id'=>'cupos_abiertos',
                        'checked' => is_null($modelConfigTurno->cupos),
                        'onChange' => new yii\web\JsExpression('
                            (function(item){
                                var cupos = $("#configturno-cupos");
                                if(item.checked){
                                    cupos.val(null).trigger("change");
                                    cupos.attr("readonly", true);
                                } else {
                                    cupos.attr("readonly", false);
                                }
                            })(this);
                        '),
                        ])
                            . Html::label('Abiertos')
                    ]
                ]
        ]);
    ?>
</div>
<?php $script = "
var sin_entre_turno = $('#sin_entre_turno');
var todo_el_dia = $('#todo_el_dia');
var cupos_abiertos = $('#cupos_abiertos');

var minutos_turno = $('#configturno-minutos_turno');
var minutos_entre_turno = $('#configturno-minutos_entre_turno');
var cupos = $('#configturno-cupos');

if(sin_entre_turno.attr('checked')) minutos_entre_turno.attr('readonly', true);
if(todo_el_dia.attr('checked')) minutos_turno.attr('readonly', true);
if(cupos_abiertos.attr('checked')) cupos.attr('readonly', true);

";
$this->registerJs($script, View::POS_READY); 
?>
