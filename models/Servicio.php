<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "servicio".
 *
 * @property int $id
 * @property string $nombre
 * @property int $categoria_id
 *
 * @property Categoria $categoria
 * @property TurnoHasServicio[] $turnoHasServicios
 * @property Turno[] $turnos
 */
class Servicio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servicio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoria_id', 'nombre'], 'required'],
            [['categoria_id', 'siempre_habil'], 'integer'],
            [['nombre', 'habil_desde', 'habil_hasta'], 'string', 'max' => 255],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'categoria_id' => 'Categoria',
            'habil_desde' => 'Servicio habil desde',
            'habil_hasta' => 'Servicio habil hasta',
            'siempre_habil' => 'Servicio habilitado indefinidamente'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurnoHasServicios()
    {
        return $this->hasMany(TurnoHasServicio::className(), ['servicio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurnos()
    {
        return $this->hasMany(Turno::className(), ['id' => 'turno_id'])->viaTable('turno_has_servicio', ['servicio_id' => 'id']);
    }
    
    public function getSiempreHabilString(){
        return $this->siempre_habil ? 'Si' : 'No';
    }
    
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getConfigReservas() 
    { 
        return $this->hasMany(ConfigReserva::className(), ['servicio_id' => 'id']); 
    }
}
