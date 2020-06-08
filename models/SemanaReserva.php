<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semana_reserva".
 *
 * @property int $id
 * @property int $lunes
 * @property int $martes
 * @property int $miercoles
 * @property int $jueves
 * @property int $viernes
 * @property int $sabado
 * @property int $domingo
 * @property int $config_reserva_id
 * @property int $config_turno_id
 *
 * @property ConfigReserva $configReserva
 * @property ConfigTurno $configTurno
 */
class SemanaReserva extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'semana_reserva';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'config_reserva_id', 'config_turno_id'], 'integer'],
            [['config_reserva_id', 'config_turno_id'], 'required'],
            [['config_reserva_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfigReserva::className(), 'targetAttribute' => ['config_reserva_id' => 'id']],
            [['config_turno_id'], 'exist', 'skipOnError' => true, 'targetClass' => ConfigTurno::className(), 'targetAttribute' => ['config_turno_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lunes' => 'Lunes',
            'martes' => 'Martes',
            'miercoles' => 'Miercoles',
            'jueves' => 'Jueves',
            'viernes' => 'Viernes',
            'sabado' => 'Sabado',
            'domingo' => 'Domingo',
            'config_reserva_id' => 'Config Reserva ID',
            'config_turno_id' => 'Config Turno ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfigReserva()
    {
        return $this->hasOne(ConfigReserva::className(), ['id' => 'config_reserva_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfigTurno()
    {
        return $this->hasOne(ConfigTurno::className(), ['id' => 'config_turno_id']);
    }

    public function getDiasHabiles(){
        $diasHabiles = [];
        if($this->domingo) array_push($diasHabiles, 0);
        if($this->lunes) array_push($diasHabiles, 1);
        if($this->martes) array_push($diasHabiles, 2);
        if($this->miercoles) array_push($diasHabiles, 3);
        if($this->jueves) array_push($diasHabiles, 4);
        if($this->viernes) array_push($diasHabiles, 5);
        if($this->sabado) array_push($diasHabiles, 6);

        return $diasHabiles;
    }

    public function getDiasNoHabiles(){
        $diasNoHabiles = [];
        if(!$this->domingo) array_push($diasNoHabiles, 0);
        if(!$this->lunes) array_push($diasNoHabiles, 1);
        if(!$this->martes) array_push($diasNoHabiles, 2);
        if(!$this->miercoles) array_push($diasNoHabiles, 3);
        if(!$this->jueves) array_push($diasNoHabiles, 4);
        if(!$this->viernes) array_push($diasNoHabiles, 5);
        if(!$this->sabado) array_push($diasNoHabiles, 6);

        return $diasNoHabiles;
    }
}
