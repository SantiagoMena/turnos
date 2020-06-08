<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dia_turno".
 *
 * @property int $id
 * @property string $dia
 * @property int $empresa_id
 *
 * @property Empresa $empresa
 * @property FranjaHorariaHasDiaTurno[] $franjaHorariaHasDiaTurnos
 * @property FranjaHoraria[] $franjaHorarias
 */
class DiaTurno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dia_turno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dia'], 'string'],
            [['empresa_id'], 'required'],
            [['empresa_id'], 'integer'],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['empresa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dia' => 'Dia',
            'empresa_id' => 'Empresa ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'empresa_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFranjaHorariaHasDiaTurnos()
    {
        return $this->hasMany(FranjaHorariaHasDiaTurno::className(), ['dia_turno_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFranjaHorarias()
    {
        return $this->hasMany(FranjaHoraria::className(), ['id' => 'franja_horaria_id'])->viaTable('franja_horaria_has_dia_turno', ['dia_turno_id' => 'id']);
    }
}
