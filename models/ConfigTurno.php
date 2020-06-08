<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "config_turno".
 *
 * @property int $id
 * @property string $desde
 * @property string $hasta
 * @property int $turno
 * @property int $minutos_turno
 * @property int $minutos_entre_turno
 * @property int $cupos
 *
 * @property DiaEspecificoReserva[] $diaEspecificoReservas
 * @property RangoReserva[] $rangoReservas
 * @property SemanaReserva[] $semanaReservas
 */
class ConfigTurno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'config_turno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa_id'], 'required'],
            [['id', 'turno', 'minutos_turno', 'minutos_entre_turno', 'cupos'], 'integer'],
            [['desde', 'hasta'], 'string', 'max' => 8],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desde' => 'Desde',
            'hasta' => 'Hasta',
            'turno' => 'Turno',
            'minutos_turno' => 'Minutos Turno',
            'minutos_entre_turno' => 'Minutos Entre Turno',
            'cupos' => 'Cupos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaEspecificoReservas()
    {
        return $this->hasMany(DiaEspecificoReserva::className(), ['config_turno_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRangoReservas()
    {
        return $this->hasMany(RangoReserva::className(), ['config_turno_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemanaReservas()
    {
        return $this->hasMany(SemanaReserva::className(), ['config_turno_id' => 'id']);
    }

    public function getHorarios($fecha){
        $desde = date('d-m-Y H:i:s', strtotime($fecha . ' ' .$this->desde));
        $hasta = date('d-m-Y H:i:s', strtotime($fecha . ' ' .$this->hasta));
        $fechas = '<div class="col-md-12">
                    <select id="turno-horario" class="form-control" name="Turno[horario]">
                    <option value="">Seleccione un horario ...</option>';
        
        if($this->minutos_turno === null){ //si no hay turnos
            $turno_value = $desde . ', ' . $hasta;
            $turno_fecha = date('H:i', strtotime($desde)) . ' => ' . date('H:i', strtotime($hasta));
            $fechas .= '<option value="'.$turno_value.'">'.$turno_fecha.'</option>';
        } else { //si hay turnos
            $fecha = $desde;
            $fecha_fin = $hasta;
            do {//TODO:verificar cupos
                $fecha_hasta = date('Y-m-d H:i:s', strtotime($fecha . '+' . $this->minutos_turno . ' minutes'));
                $turno_value = $fecha . ', ' . $fecha_hasta;
                $turno_fecha = date('H:i', strtotime($fecha)) . ' => ' . date('H:i', strtotime($fecha_hasta));
                if(!is_null($this->cupos)){//esta mal
                    if(Turno::find()->where([
                        'desde' => date('Y-m-d H:i:s', strtotime($fecha)),
                        'hasta' => date('Y-m-d H:i:s', strtotime($fecha_hasta)),
                        'empresa_id' => $this->empresa_id,
                        ])->count() < $this->cupos
                    )
                        $fechas .= '<option value="'.$turno_value.'">'.$turno_fecha.'</option>';
                } else 
                    $fechas .= '<option value="'.$turno_value.'">'.$turno_fecha.'</option>';

                if($this->minutos_entre_turno === null)
                    $fecha = $fecha_hasta;
                else
                    $fecha = date('Y-m-d H:i:s', strtotime($fecha_hasta . '+' . $this->minutos_entre_turno . ' minutes'));
            } while (date('Y-m-d H:i:s', strtotime($fecha)) <= date('Y-m-d H:i:s', strtotime($fecha_fin)));
        }
        // foreach ($franjasHorarias as $key => $franjaHoraria) {

        //     $fecha_inicio = date('Y-m-d', strtotime($fecha)).' '.date('H:i:s', strtotime($franjaHoraria->desde));
        //     $fecha_fin = date('Y-m-d', strtotime($fecha)).' '.date('H:i:s', strtotime($franjaHoraria->hasta));
        //     $fecha_mostrar = $fecha_inicio;
        //     $value_fecha = date('Y-m-d', strtotime($fecha)).' '.date('H:i:s', strtotime($fecha_mostrar));

        //     do {
        //         $fechas .= '<script>console.log("'.$fecha_mostrar.'")</script>';
        //         if($this->disponible($franjaHoraria, $fecha_mostrar, $empresa_id))
        //             $fechas .= '<option value="'.$fecha_mostrar.'">'.date('h:i A', strtotime($fecha_mostrar)).'</option>';

        //         //$fecha_mostrar = date('Y-m-d H:i:s', strtotime($value_fecha .' +'.$franjaHoraria->minutos_turno.' minutes'));
        //         $fecha_mostrar = date('Y-m-d H:i:s', strtotime($fecha_mostrar .' +'.$franjaHoraria->minutos_turno.' minutes'));
        //     } while (date('Y-m-d H:i:s', strtotime($fecha_mostrar)) <= date('Y-m-d H:i:s', strtotime($fecha_fin)));
        // }

        $fechas .= '</select>

            </div>';
        
        return $fechas;
    }
}
