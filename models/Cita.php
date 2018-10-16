<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Url;
use app\models\Empresa;

/**
 * This is the model class for table "cita".
 *
 * @property int $id
 * @property string $fecha
 * @property int $empresa_id
 * @property string $cedula
 * @property string $nombre
 * @property string $telefono
 * @property string $correo
 * @property string $cargo
 * @property string $documento
 *
 * @property Empresa $empresa
 * @property CitaHasExamen[] $citaHasExamens
 * @property Examen[] $examens
 */
class Cita extends \yii\db\ActiveRecord
{
    public $examenes;
    public $categoria;
    public $empresa;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cita';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'empresa_id'], 'required'],
            [['fecha'], 'safe'],
            [['empresa_id'], 'integer'],
            [['correo'], 'email'],
            [['cedula', 'nombre', 'telefono', 'correo', 'cargo'], 'string', 'max' => 255],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['empresa_id' => 'id']],
            [['documento'], 'file', 'skipOnEmpty' => true,'skipOnError' => true, 'extensions' => 'xls, xlsx, doc, docx, pdf, jpg, png, jpeg, txt'],
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
            'fecha' => 'Fecha',
            'empresa_id' => 'Empresa',
            'cedula' => 'Cedula',
            'nombre' => 'Nombre',
            'telefono' => 'Telefono',
            'correo' => 'Correo',
            'cargo' => 'Cargo',
            'documento' => 'Documento',
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
    public function getCitaHasExamens()
    {
        return $this->hasMany(CitaHasExamen::className(), ['cita_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExamens()
    {
        return $this->hasMany(Examen::className(), ['id' => 'examen_id'])->viaTable('cita_has_examen', ['cita_id' => 'id']);
    }
    public function getHorarios($fecha){
        /*
        Horario de citas (Checkeable según el intervalo que este disponible, con invertalos de tiempo de 15 min) - 
        (6:30 am - 11:45 pm y 2:00pm - 4:30 pm) Lu - Vi
         */
        if(date('w', strtotime($fecha)) == 0 || date('w', strtotime($fecha)) == 6)
            return [];

        $fecha_inicio = date('Y-m-d H:i:s', strtotime($fecha.' 6:30'));
        $fecha_fin = date('Y-m-d H:i:s', strtotime($fecha.' 11:45'));
        $fecha_mostrar = $fecha_inicio;
        $fechas = '';
        $fechas = '<div class="col-md-12">
                    <select id="cita-horario" class="form-control" name="Cita[horario]">
                    <option value="">Seleccione un horario ...</option>';

       do {
            if(!$this->existeCita($fecha_mostrar))
                $fechas .= '<option value="'.$fecha_mostrar.'">'.date('h:i A', strtotime($fecha_mostrar)).'</option>';
            // $fechas .= ' <input type="radio" id="'.$fecha_mostrar.'"
            //        name="Cita[horario]" value="'.$fecha_mostrar.'" />
            //        <label for="'.$fecha_mostrar.'">'.$fecha_mostrar.'</label>';
            $fecha_mostrar = date('Y-m-d H:i:s', strtotime($fecha_mostrar .' +15 minutes'));
        } while (date('Y-m-d H:i:s', strtotime($fecha_mostrar)) <= date('Y-m-d H:i:s', strtotime($fecha_fin)));


        $fecha_inicio = date('Y-m-d H:i:s', strtotime($fecha.' 14:00'));
        $fecha_fin = date('Y-m-d H:i:s', strtotime($fecha.' 16:30'));
        $fecha_mostrar = $fecha_inicio;
       do {
            if(!$this->existeCita($fecha_mostrar))
                $fechas .= '<option value="'.$fecha_mostrar.'">'.date('h:i A', strtotime($fecha_mostrar)).'</option>';
                // $fechas .= '<input type="radio" id="'.$fecha_mostrar.'" name="Cita[horario]" value="'.$fecha_mostrar.'" />
                //             <label for="'.$fecha_mostrar.'">'.$fecha_mostrar.'</label>';
            $fecha_mostrar = date('Y-m-d H:i:s', strtotime($fecha_mostrar .' +15 minutes'));
        } while (date('Y-m-d H:i:s', strtotime($fecha_mostrar)) <= date('Y-m-d H:i:s', strtotime($fecha_fin)));

        $fechas .= '</select>

            </div>';
        return $fechas;
    }

    public function existeCita($fecha){
        return Cita::find()->where(['fecha' => date('Y-m-d H:i:s', strtotime($fecha))])->one() ? TRUE : FALSE;
    }

    public function afterSave ( $insert, $changedAttributes ){
        $mail_to = Yii::$app->params['secretariaEmail'];
        if($this->correo)
            $mail_to = array_merge($mail_to, [$this->correo]);

            $dia = date('Y-m-d', strtotime($this->fecha));
            $hora = date('H:i:s', strtotime($this->fecha));
            $empresa = Empresa::findOne($this->empresa_id)->nombre;
            $msj = "La empresa $empresa a agendado una cita para el empleado $this->nombre el día $dia a la hora $hora
                    <br>Empresa: $empresa
                    <br>Empleado: $this->nombre
                    <br>Fecha: $dia
                    <br>Hora: $hora
                    ";
        Yii::$app->mailer->compose()
        ->setSubject('Nuevo Turno Agendado')
        ->setHtmlBody($msj)
        ->setFrom('citas@integrarips.com')
        ->setTo($mail_to)
        ->send();
        // ...custom code here...
        return true;
    }
    public function beforeDelete(){
        if (!parent::beforeDelete()) {
            return false;
        }
        $mail_to = Yii::$app->params['secretariaEmail'];
        if($this->correo)
            $mail_to = array_merge($mail_to, [$this->correo]);

            $dia = date('Y-m-d', strtotime($this->fecha));
            $hora = date('H:i:s', strtotime($this->fecha));
            $empresa = Empresa::findOne($this->empresa_id)->nombre;
            $msj = "La empresa $empresa a cancelado una cita para el empleado $this->nombre el día $dia a la hora $hora
                    <br>Empresa: $empresa
                    <br>Empleado: $this->nombre
                    <br>Fecha: $dia
                    <br>Hora: $hora
                    ";
        Yii::$app->mailer->compose()
        ->setSubject('Turno Cancelado')
        ->setHtmlBody($msj)
        ->setFrom('citas@integrarips.com')
        ->setTo($mail_to)
        ->send();
        // ...custom code here...
        return true;
    }

    public function getCitasPendientes(){
        return Cita::find()->where(['date(fecha)' => date('Y-m-d', strtotime('YESTERDAY'))])->all();
    }
}
