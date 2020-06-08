<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "franja_horaria_has_dia_turno".
 *
 * @property int $franja_horaria_id
 * @property int $dia_turno_id
 *
 * @property DiaTurno $diaTurno
 * @property FranjaHoraria $franjaHoraria
 */
class FranjaHorariaHasDiaTurno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'franja_horaria_has_dia_turno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['franja_horaria_id', 'dia_turno_id'], 'required'],
            [['franja_horaria_id', 'dia_turno_id'], 'integer'],
            [['franja_horaria_id', 'dia_turno_id'], 'unique', 'targetAttribute' => ['franja_horaria_id', 'dia_turno_id']],
            [['dia_turno_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiaTurno::className(), 'targetAttribute' => ['dia_turno_id' => 'id']],
            [['franja_horaria_id'], 'exist', 'skipOnError' => true, 'targetClass' => FranjaHoraria::className(), 'targetAttribute' => ['franja_horaria_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'franja_horaria_id' => 'Franja Horaria ID',
            'dia_turno_id' => 'Dia Turno ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaTurno()
    {
        return $this->hasOne(DiaTurno::className(), ['id' => 'dia_turno_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFranjaHoraria()
    {
        return $this->hasOne(FranjaHoraria::className(), ['id' => 'franja_horaria_id']);
    }
}
