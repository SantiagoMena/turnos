<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * This is the model class for table "empresa".
 *
 * @property int $id
 * @property int $user_id
 * @property string $nombre
 * @property string $nit
 * @property string $correo
 * @property string $telefono
 * @property string $direccion
 * @property string $logo
 *
 * @property Cita[] $citas
 * @property User $user
 */
class Empresa extends \yii\db\ActiveRecord
{
    public $username;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id','correo','nombre'], 'required'],
            [['correo'], 'email'],
            [['user_id'], 'integer'],
            [['nombre', 'nit', 'correo', 'telefono', 'direccion'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['logo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
        ];
    }

    /**
     * Función para subir archivo pasando el nombre del campo
     *
     * @param [type] $field
     * @param string $value
     * @return void
     */
    public function uploadFile($field, $value='')
    {
        $upload_model = $this;
        $upload_model->{$field} = UploadedFile::getInstance($this, $field);
        if ($upload_model->validate() && isset($upload_model->{$field}->extension)) {
            $file_name = \Yii::$app->security->generateRandomString() . '.' . $upload_model->{$field}->extension;
            $upload_model->{$field}->saveAs('uploads/' . $file_name);
            $this->{$field} = Url::to('uploads', true).'/'.$file_name;
        } else {
            $this->{$field} = $value;
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuario',
            'user_id' => 'Usuario',
            'nombre' => 'Nombre',
            'nit' => 'Nit',
            'correo' => 'Correo',
            'telefono' => 'Telefono',
            'direccion' => 'Direccion',
            'logo' => 'Logo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitas()
    {
        return $this->hasMany(Cita::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
