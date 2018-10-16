<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "secretaria".
 *
 * @property int $id
 * @property int $user_id
 * @property int $empresa_id
 * @property string $nombre
 * @property string $telefono
 * @property string $correo
 *
 * @property Empresa $empresa
 * @property User $user
 */
class Secretaria extends \yii\db\ActiveRecord
{
    public $username;
    public $empresa;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'secretaria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'empresa_id', 'correo'], 'required'],
            [['user_id', 'empresa_id'], 'integer'],
            [['nombre', 'telefono', 'correo'], 'string', 'max' => 255],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Usuario',
            'username' => 'Usuario',
            'empresa' => 'Empresa',
            'empresa_id' => 'Empresa',
            'nombre' => 'Nombre',
            'telefono' => 'Telefono',
            'correo' => 'Correo',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
