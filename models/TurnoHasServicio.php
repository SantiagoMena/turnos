<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "turno_has_servicio".
 *
 * @property int $turno_id
 * @property int $servicio_id
 *
 * @property Servicio $servicio
 * @property Turno $turno
 */
class TurnoHasServicio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'turno_has_servicio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['turno_id', 'servicio_id'], 'required'],
            [['turno_id', 'servicio_id'], 'integer'],
            [['turno_id', 'servicio_id'], 'unique', 'targetAttribute' => ['turno_id', 'servicio_id']],
            [['servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servicio::className(), 'targetAttribute' => ['servicio_id' => 'id']],
            [['turno_id'], 'exist', 'skipOnError' => true, 'targetClass' => Turno::className(), 'targetAttribute' => ['turno_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'turno_id' => 'Turno ID',
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
    public function getTurno()
    {
        return $this->hasOne(Turno::className(), ['id' => 'turno_id']);
    }
}
