<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Url;
use app\models\Empresa;
use app\models\Dato;

/**
 * This is the model class for table "turno".
 *
 * @property int $id
 * @property string $fecha
 * @property int $empresa_id
 * @property string $token
 * @property string $estado
 * @property string $fecha_modificacion
 * @property int $dato_id
 *
 * @property Empresa $empresa
 * @property Dato $dato
 * @property TurnoHasServicio[] $turnoHasServicios
 */
class Turno extends \yii\db\ActiveRecord
{
    public $servicios;
    public $categoria;
    public $empresa;
    public $documento;
    public $telefono;
    public $correo;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'turno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['desde', 'hasta', 'empresa_id', 'token'], 'required'],
            [['desde', 'hasta', 'fecha_modificacion'], 'safe'],
            [['empresa_id'], 'integer'],
            [['estado'], 'string'],
            [['token'], 'string', 'max' => 255],
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
            'desde' => 'Fecha Desde',
            'hasta' => 'Fecha Hasta',
            'empresa_id' => 'Empresa ID',
            'token' => 'Token',
            'estado' => 'Estado',
            'fecha_modificacion' => 'Fecha Modificacion',
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
    public function getDato() 
    { 
        return $this->hasOne(Dato::className(), ['turno_id' => 'id']); 
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServicio()
    {
        return $this->hasOne(Servicio::className(), ['id' => 'servicio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurnoHasServicios()
    {
        return $this->hasMany(TurnoHasServicio::className(), ['turno_id' => 'id']);
    }
    public function getHorarios($empresa_id, $fecha){
        $dias = [
            0 => 'Domingo',
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miercoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sabado',
        ];
        $dia = $dias[date('w', strtotime($fecha))];
        $franjasHorarias = FranjaHoraria::find()
                            ->where(['dia_turno.dia'=> $dia, 'franja_horaria.empresa_id' => $empresa_id])
                            ->orderBy(['id'=>SORT_DESC])
                            ->joinWith(['franjaHorariaHasDiaTurnos', 'franjaHorariaHasDiaTurnos.diaTurno'])
                            ->all();

        $fechas = '';
        $fechas = '<div class="col-md-12">
                    <select id="turno-horario" class="form-control" name="Turno[horario]">
                    <option value="">Seleccione un horario ...</option>';
        foreach ($franjasHorarias as $key => $franjaHoraria) {

            $fecha_inicio = date('Y-m-d', strtotime($fecha)).' '.date('H:i:s', strtotime($franjaHoraria->desde));
            $fecha_fin = date('Y-m-d', strtotime($fecha)).' '.date('H:i:s', strtotime($franjaHoraria->hasta));
            $fecha_mostrar = $fecha_inicio;
            $value_fecha = date('Y-m-d', strtotime($fecha)).' '.date('H:i:s', strtotime($fecha_mostrar));

            do {
                $fechas .= '<script>console.log("'.$fecha_mostrar.'")</script>';
                if($this->disponible($franjaHoraria, $fecha_mostrar, $empresa_id))
                    $fechas .= '<option value="'.$fecha_mostrar.'">'.date('h:i A', strtotime($fecha_mostrar)).'</option>';

                //$fecha_mostrar = date('Y-m-d H:i:s', strtotime($value_fecha .' +'.$franjaHoraria->minutos_turno.' minutes'));
                $fecha_mostrar = date('Y-m-d H:i:s', strtotime($fecha_mostrar .' +'.$franjaHoraria->minutos_turno.' minutes'));
            } while (date('Y-m-d H:i:s', strtotime($fecha_mostrar)) <= date('Y-m-d H:i:s', strtotime($fecha_fin)));
        }

        $fechas .= '</select>

            </div>';
        return $fechas;
    }

    public function disponible($franjaHoraria, $fecha, $empresa_id){
        if(date('Y-m-d H:i:s', strtotime($fecha)) < date('Y-m-d H:i:s'))
            return false;

        $turno = Turno::find()->where(['fecha' => date('Y-m-d H:i:s', strtotime($fecha)), 'empresa_id' => $empresa_id]);
        return $turno->exists() && $fecha ? $turno->count() < $franjaHoraria->cupos : TRUE;
    }

    public function existeTurno($fecha){
        return Turno::find()->where(['fecha' => date('Y-m-d H:i:s', strtotime($fecha))])->exists() ? TRUE : FALSE;
    }

    public function getServicios(){
        // $turno = Turno::find()
        //     ->where(['turno.id'=>$this->id])
        //     ->innerJoin('empresa','empresa.id = turno.empresa_id')
        //     ->leftJoin('turno_has_servicio','turno_has_servicio.turno_id = turno.id')
        //     ->innerJoin('servicio', 'servicio.id = turno_has_servicio.servicio_id')
        //     ->select(['turno.id',"GROUP_CONCAT(servicio.nombre SEPARATOR ', ') as servicios"])
        //     ->groupBy('turno.id')
        //     ->one();
        return $this->servicio->nombre;
    }
    public function enviarMail (){
        $mail_to = Yii::$app->params['secretariaEmail'];
        $dato = Dato::find()->where(['turno_id' => $this->id])->one();
        if($dato->correo)
            $modelEmpresa = Empresa::findOne($this->empresa_id);
            $empresa = $modelEmpresa->nombre;
            $mail_to = [$modelEmpresa->correo, $dato->correo];

            $dia = date('Y-m-d', strtotime($this->desde));
            $hora = date('H:i:s', strtotime($this->hasta));
            $desde = date('H:i:s', strtotime($this->desde));
            $hasta = date('H:i:s', strtotime($this->hasta));
            $msj = "La empresa $empresa a agendado una turno para el cliente $dato->nombre el día $dia a la hora $hora
                    <br>Empresa: $empresa
                    <br>Cliente: $dato->nombre
                    <br>Servicios: ".$this->servicio->nombre."
                    <br>Fecha: $dia
                    <br>Turno: $desde => $hasta
                    ";
        Yii::$app->mailer->compose()
        ->setSubject('Nuevo Turno Agendado')
        ->setHtmlBody($msj)
        ->setFrom('turnos@desligar.me')
        ->setTo($mail_to)
        ->send();
        // ...custom code here...
        return true;
    }
    // public function afterSave ( $insert, $changedAttributes ){
    //     $mail_to = Yii::$app->params['secretariaEmail'];
    //     if($this->correo)
    //         $mail_to = array_merge($mail_to, [$this->correo]);

    //         $dia = date('Y-m-d', strtotime($this->fecha));
    //         $hora = date('H:i:s', strtotime($this->fecha));
    //         $empresa = Empresa::findOne($this->empresa_id)->nombre;
    //         $msj = "La empresa $empresa a agendado una turno para el empleado $this->nombre el día $dia a la hora $hora
    //                 <br>Empresa: $empresa
    //                 <br>Empleado: $this->nombre
    //                 <br>Examenes: ".$this->getExamenes()."
    //                 <br>Fecha: $dia
    //                 <br>Hora: $hora
    //                 ";
    //     Yii::$app->mailer->compose()
    //     ->setSubject('Nuevo Turno Agendado')
    //     ->setHtmlBody($msj)
    //     ->setFrom('turnos@integrarips.com')
    //     ->setTo($mail_to)
    //     ->send();
    //     // ...custom code here...
    //     return true;
    // }
    public function beforeDelete(){
        if (!parent::beforeDelete()) {
            return false;
        }
        $mail_to = Yii::$app->params['secretariaEmail'];
        $dato = Dato::find()->where(['turno_id' => $this->id])->one();
        if($dato->correo)
            $mail_to = array_merge($mail_to, [$dato->correo]);

            $dia = date('Y-m-d', strtotime($this->desde));
            $hora = date('H:i:s', strtotime($this->hasta));
            $desde = date('H:i:s', strtotime($this->desde));
            $hasta = date('H:i:s', strtotime($this->hasta));
            $empresa = Empresa::findOne($this->empresa_id)->nombre;
            $msj = "La empresa $empresa a cancelado una turno para el empleado $dato->nombre el día $dia a la hora $hora
                    <br>Empresa: $empresa
                    <br>Empleado: $dato->nombre
                    <br>Servicios: ".$this->servicio->nombre."
                    <br>Fecha: $dia
                    <br>Turno: $desde => $hasta
                    ";
        Yii::$app->mailer->compose()
        ->setSubject('Turno Cancelado')
        ->setHtmlBody($msj)
        ->setFrom('turnos@desligar.me')
        ->setTo($mail_to)
        ->send();
        // ...custom code here...
        return true;
    }

    public function getTurnosPendientes(){
        echo date('Y-m-d H:i:00', strtotime('NOW'));
        return Turno::find()->where(['fecha' => date('Y-m-d H:i:00', strtotime('NOW +2 hours'))])->all();
    }

}
