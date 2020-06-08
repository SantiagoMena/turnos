<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "config_reserva".
 *
 * @property int $id
 * @property string $tipo
 * @property int $servicio_id
 *
 * @property Servicio $servicio
 * @property DiaEspecificoReserva[] $diaEspecificoReservas
 * @property RangoReserva[] $rangoReservas
 * @property SemanaReserva[] $semanaReservas
 */
class ConfigReserva extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'config_reserva';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo'], 'string'],
            [['servicio_id', 'tipo'], 'required'],
            [['servicio_id'], 'integer'],
            [['servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servicio::className(), 'targetAttribute' => ['servicio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo' => 'Tipo',
            'servicio_id' => 'Servicio ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicio()
    {
        return $this->hasOne(Servicio::className(), ['id' => 'servicio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaEspecificoReservas()
    {
        return $this->hasMany(DiaEspecificoReserva::className(), ['config_reserva_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRangoReservas()
    {
        return $this->hasMany(RangoReserva::className(), ['config_reserva_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemanaReservas()
    {
        return $this->hasMany(SemanaReserva::className(), ['config_reserva_id' => 'id']);
    }
}
