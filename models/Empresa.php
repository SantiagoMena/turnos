<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "empresa".
 *
 * @property int $id
 * @property string $nombre
 * @property string $nit
 * @property string $correo
 * @property string $telefono
 * @property string $direccion
 * @property string $logo
 * @property int $usuario_id
 *
 * @property Administracion[] $administracions
 * @property Usuario $usuario
 */
class Empresa extends \yii\db\ActiveRecord
{
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
            [['usuario_id'], 'required'],
            [['usuario_id'], 'integer'],
            [['nombre', 'nit', 'correo', 'telefono', 'direccion'], 'string', 'max' => 255],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usuario_id' => 'id']],
            [['logo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
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
            'nit' => 'Nit',
            'correo' => 'Correo',
            'telefono' => 'Telefono',
            'direccion' => 'Direccion',
            'logo' => 'Logo',
            'usuario_id' => 'Usuario ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdministracions()
    {
        return $this->hasMany(Administracion::className(), ['empresa_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'usuario_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfiguracion()
    {
        return $this->hasOne(Configuracion::className(), ['id' => 'empresa_id']);
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

        return true;
    }

    public function getFranjas(){
        $franjasHorarias = FranjaHoraria::find()->where(['empresa_id' => $this->id])->all();
        $franjas = [];
        foreach ($franjasHorarias as $franjaHoraria) {
            $franja = [
                'desde' => $franjaHoraria->desde,
                'hasta' => $franjaHoraria->hasta,
                'tiene_turnos' => $franjaHoraria->tiene_turnos,
                'minutos_turno' => $franjaHoraria->minutos_turno,
                'cupos' => $franjaHoraria->cupos,
                'tiene_limpieza' => $franjaHoraria->tiene_limpieza,
                'tiempo_limpieza' => $franjaHoraria->tiempo_limpieza,
            ];

            $franja['dias'] = array_keys(ArrayHelper::map($franjaHoraria->getDiaTurnos()->all(), 'dia', 'dia'));
            $franjas[] = $franja;
        }

        return $franjas;
    }
}
