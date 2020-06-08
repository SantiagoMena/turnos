<?php
use kartik\checkbox\CheckboxX;
\yii\bootstrap\BootstrapPluginAsset::register($this);

$dias = [
    'lunes' => 'Lunes',
    'martes' => 'Martes',
    'miercoles' => 'Miercoles',
    'jueves' => 'Jueves',
    'viernes' => 'Viernes',
    'sabado' => 'Sabado',
    'domingo' => 'Domingo'
];
?>
<div class="col-md-7 col-md-offset-3"> 
    <?php foreach ($dias as $atributte => $dia): ?>
        <label class="cbx-label" for="s_1"><?= $dia ?></label>
        <?= 
            CheckboxX::widget([
                'model'=>$modelSemanaReserva,
                'attribute' => $atributte,
                'pluginOptions'=>['threeState'=>false]
            ]);
        ?>
    <?php endforeach; ?>
</div>