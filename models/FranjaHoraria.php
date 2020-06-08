<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "franja_horaria".
 *
 * @property int $id
 * @property int $empresa_id
 * @property string $desde
 * @property string $hasta
 * @property int $tiene_turnos
 * @property int $minutos_turno
 * @property int $tiene_limpieza
 * @property int $tiempo_limpieza
 *
 * @property Empresa $empresa
 * @property FranjaHorariaHasDiaTurno[] $franjaHorariaHasDiaTurnos
 * @property DiaTurno[] $diaTurnos
 */
class FranjaHoraria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'franja_horaria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa_id'], 'required'],
            [['empresa_id', 'tiene_turnos', 'minutos_turno', 'tiene_limpieza', 'tiempo_limpieza', 'cupos'], 'integer'],
            [['desde', 'hasta'], 'string', 'max' => 8],
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
            'empresa_id' => 'Empresa ID',
            'desde' => 'Desde',
            'hasta' => 'Hasta',
            'tiene_turnos' => 'Tiene Turnos',
            'minutos_turno' => 'Hora Turno',
            'tiene_limpieza' => 'Tiene Limpieza',
            'tiempo_limpieza' => 'Tiempo Limpieza',
            'cupos' => 'Cupos',
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
        return $this->hasMany(FranjaHorariaHasDiaTurno::className(), ['franja_horaria_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiaTurnos()
    {
        return $this->hasMany(DiaTurno::className(), ['id' => 'dia_turno_id'])->viaTable('franja_horaria_has_dia_turno', ['franja_horaria_id' => 'id']);
    }
}
