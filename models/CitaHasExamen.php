<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cita_has_examen".
 *
 * @property int $cita_id
 * @property int $examen_id
 *
 * @property Cita $cita
 * @property Examen $examen
 */
class CitaHasExamen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cita_has_examen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cita_id', 'examen_id'], 'required'],
            [['cita_id', 'examen_id'], 'integer'],
            [['cita_id', 'examen_id'], 'unique', 'targetAttribute' => ['cita_id', 'examen_id']],
            [['cita_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cita::className(), 'targetAttribute' => ['cita_id' => 'id']],
            [['examen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Examen::className(), 'targetAttribute' => ['examen_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cita_id' => 'Cita ID',
            'examen_id' => 'Examen ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCita()
    {
        return $this->hasOne(Cita::className(), ['id' => 'cita_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamen()
    {
        return $this->hasOne(Examen::className(), ['id' => 'examen_id']);
    }
}
