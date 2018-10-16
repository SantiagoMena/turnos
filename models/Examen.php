<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "examen".
 *
 * @property int $id
 * @property string $nombre
 * @property int $categoria_id
 *
 * @property CitaHasExamen[] $citaHasExamens
 * @property Cita[] $citas
 * @property Categoria $categoria
 */
class Examen extends \yii\db\ActiveRecord
{
    public $categoria_nombre;
    public $examen_nombre;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'examen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['categoria_id'], 'required'],
            [['categoria_id'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
            [['categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitaHasExamens()
    {
        return $this->hasMany(CitaHasExamen::className(), ['examen_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitas()
    {
        return $this->hasMany(Cita::className(), ['id' => 'cita_id'])->viaTable('cita_has_examen', ['examen_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
    }
}
