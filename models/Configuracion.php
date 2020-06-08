<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "configuracion".
 *
 * @property int $id
 * @property int $empresa_id
 * @property int $turno_publico
 * @property int $cancelar_turno
 * @property int $reprogramar_turno
 * @property string $correos
 * @property int $adjunto_turno
 * @property int $cualquier_horario
 * @property int $cualquier_dia
 *
 * @property Empresa $empresa
 */
class Configuracion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'configuracion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['empresa_id'], 'required'],
            [['empresa_id', 'turno_publico', 'cancelar_turno', 'reprogramar_turno', 'adjunto_turno', 'cualquier_horario', 'cualquier_dia'], 'integer'],
            [['correos'], 'string'],
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
            'turno_publico' => 'Turno Publico',
            'cancelar_turno' => 'Cancelar Turno',
            'reprogramar_turno' => 'Reprogramar Turno',
            'correos' => 'Correos',
            'adjunto_turno' => 'Adjunto Turno',
            'cualquier_horario' => 'Cualquier Horario',
            'cualquier_dia' => 'Cualquier Dia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'empresa_id']);
    }
}
