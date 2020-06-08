<?php

namespace app\models;

use Yii;

use yii\web\UploadedFile;
use yii\helpers\Url;
/**
 * This is the model class for table "dato".
 *
 * @property int $id
 * @property string $documento
 * @property string $nombre
 * @property string $telefono
 * @property string $correo
 * @property string $cargo
 * @property string $adjunto
 * @property int $turno_id
 */
class Dato extends \yii\db\ActiveRecord
{
    public $estado;
    public $servicios;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dato';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['turno_id'], 'required'],
            [['turno_id'], 'integer'],
            [['documento', 'nombre', 'telefono', 'correo', 'cargo'], 'string', 'max' => 255],
            [['adjunto'], 'file', 'skipOnEmpty' => true,'skipOnError' => true, 'extensions' => 'xls, xlsx, doc, docx, pdf, jpg, png, jpeg, txt'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'documento' => 'Documento',
            'nombre' => 'Nombre',
            'telefono' => 'Telefono',
            'correo' => 'Correo',
            'cargo' => 'Cargo',
            'adjunto' => 'Adjunto',
            'turno_id' => 'Turno ID',
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
            $this->{$field} = $file_name;
        } else {
            $this->{$field} = $value;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurno()
    {
        return $this->hasOne(Turno::className(), ['id' => 'turno_id']);
    }
}
