<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historial_turno".
 *
 * @property int $version
 * @property string $fecha
 * @property int $empresa_id
 * @property string $token
 * @property string $estado
 * @property string $fecha_modificacion
 * @property int $datos_id
 * @property int $id
 *
 * @property Empresa $empresa
 * @property Datos $datos
 */
class HistorialTurno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'historial_turno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'empresa_id', 'token', 'datos_id', 'id'], 'required'],
            [['fecha', 'fecha_modificacion'], 'safe'],
            [['empresa_id', 'datos_id', 'id'], 'integer'],
            [['estado'], 'string'],
            [['token'], 'string', 'max' => 255],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['datos_id'], 'exist', 'skipOnError' => true, 'targetClass' => Datos::className(), 'targetAttribute' => ['datos_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'version' => 'Version',
            'fecha' => 'Fecha',
            'empresa_id' => 'Empresa ID',
            'token' => 'Token',
            'estado' => 'Estado',
            'fecha_modificacion' => 'Fecha Modificacion',
            'datos_id' => 'Datos ID',
            'id' => 'ID',
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
    public function getDatos()
    {
        return $this->hasOne(Datos::className(), ['id' => 'datos_id']);
    }
}
