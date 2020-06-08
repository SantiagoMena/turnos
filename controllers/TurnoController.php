<?php

namespace app\controllers;

use Yii;
use app\models\Turno;
use app\models\Dato;
use app\models\TurnoSearch;
use app\models\Administracion;
use app\models\Empresa;
use app\models\TurnoHasServicio;
use app\models\Servicio;
use app\models\ConfigReserva;
use app\models\ConfigTurno;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * TurnoController implements the CRUD actions for Turno model.
 */
class TurnoController extends Controller
{
    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config);
        $this->layout = 'main';
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'recordar',
                            'index',
                            'view',
                            'create',
                            'update',
                            'delete',
                            'horarios',
                            'agenda',
                            'estado',
                            'nuevo',
                            'gracias',
                            'agendar',
                            'render-date-picker-dias-por-semana'
                        ],
                        'roles' => ['empresa', 'administracion'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'recordar',
                            'nuevo',
                            'horarios',
                            'gracias',
                            'agendar',
                            'render-date-picker-dias-por-semana'
                        ],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['recordar', 'horarios'],
                        'roles' => ['*'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Turno models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TurnoSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Lists all Turno models.
     * @return mixed
     */
    public function actionAgenda()
    {
        $searchModel = new TurnoSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        if($this->isRol('empresa'))
            $empresa = Empresa::find()->where(['usuario_id' => Yii::$app->user->id])->one();
        else
            $empresa = false;

        return $this->render('agenda', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'empresa' => $empresa
        ]);
    }

    /**
     * Displays a single Turno model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id)->getDato()->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Turno model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if($this->isRol('administracion'))
            $id = Administracion::find()->where(['usuario_id' => Yii::$app->user->id])->one()->empresa_id;
        if($this->isRol('empresa'))
            $id = Empresa::find()->where(['usuario_id' => Yii::$app->user->id])->one()->id;
        else
            $id = null;
        // $this->layout = 'main_publico';
        $model = new Turno;
        $modelDato = new Dato();
        if (($empresa = Empresa::findOne($id)) !== null) {
            $model->empresa_id = $empresa->id;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        //Comprobar que la empresa tenga habiliada la creación de turnos al publico
        $data['Turno'] = Yii::$app->request->post('Turno');
        $data['Dato'] = Yii::$app->request->post('Dato');
        $load = false;
        if($data['Turno']){
            if(isset($data['Turno']['horario'])){
                $fechas = explode(',', $data['Turno']['horario']);
                $data['Turno']['desde'] = date('Y-m-d H:i:s', strtotime($fechas[0]));
                $data['Turno']['hasta'] = date('Y-m-d H:i:s', strtotime($fechas[1]));
                $data['Turno']['token'] = md5(time());
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        $load = $model->load($data);
        $model->servicio_id = intval($data['Turno']['servicio_id']);
        if ($load && $model->save()) {

            $loadDato = $modelDato->load($data);
            $modelDato->turno_id = $model->id;
            $modelDato->uploadFile('adjunto');

            if($loadDato && $modelDato->save()) {
                //FIXME: REPARAR ENVIO DE MAIL
                $model->enviarMail();
                return $this->redirect(['gracias', 'id' => $model->id]);
            } else {
                // var_dump('modelDato',$modelDato->errors);die;
            }
        } else {
            // var_dump('model',$model->errors);die;
            return $this->render('agendar', [
                'model' => $model,
                'modelDato' => $modelDato,
                'modelEmpresa' => $empresa,
            ]);
        }
    }

    /**
     * Updates an existing Turno model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->servicios = ArrayHelper::map(
                                TurnoHasServicio::find()
                                ->where(['turno_id'=>$id])
                                ->with(['servicio'])
                                ->all(), 
                                'servicio_id', 'servicio_id'
                            );
        
        $data['Turno'] = Yii::$app->request->post('Turno');
        $load = false;
        if($data['Turno']){
            if($this->isRol('administracion'))
                $empresa_id = Administracion::find()->where(['usuario_id' => Yii::$app->user->id])->one()->empresa_id;
            if($this->isRol('empresa'))
                $empresa_id = Empresa::find()->where(['usuario_id' => Yii::$app->user->id])->one()->id;
            if(!$this->isRol('admin'))
                $data['Turno']['empresa_id'] = $empresa_id;
            $load = $model->load($data);
            $model->uploadFile('adjunto');
        }
        if ($load && $model->save()) {
            if(is_array($data['Turno']['servicios'])){
                \Yii::$app
                ->db
                ->createCommand()
                ->delete('turno_has_servicio', ['turno_id' => $id])
                ->execute();
                foreach ($data['Turno']['servicios'] as $key => $value) {
                    $turnoHasServicio = new TurnoHasServicio;
                    $turnoHasServicio->turno_id = $model->id;
                    $turnoHasServicio->servicio_id = $value;
                    $turnoHasServicio->save();
                }
            }
            $model->enviarMail();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Turno model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Turno model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Turno the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Turno::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionHorarios($id, $fecha){
        $modelConfigReserva = ConfigReserva::find()->where(['servicio_id' => $id])->one();
        if($modelConfigReserva->tipo === 'Dias por semana'){
            $modelConfigTurno = ConfigTurno::findOne($modelConfigReserva->getSemanaReservas()->one()->config_turno_id);
            return $modelConfigTurno->getHorarios(date('Y-m-d', strtotime($fecha)));
        }
        // $model = new Turno;
        // $empresa_id = false;
        // if($this->isRol('administracion'))
        //     $empresa_id = Administracion::find()->where(['usuario_id' => Yii::$app->user->id])->one()->empresa_id;
        // elseif($this->isRol('empresa'))
        //     $empresa_id = Empresa::find()->where(['usuario_id' => Yii::$app->user->id])->one()->id;
        // else
        //     $empresa_id = Yii::$app->request->get('id');

        // return $model->getHorarios($empresa_id, date('Y-m-d', strtotime($fecha)));
    }

    public function actionRecordar(){
        $model = new Turno;
        $turnosPendientes = $model->getTurnosPendientes();
        $recordatorios = [];
        foreach ($turnosPendientes as $key => $turno) {
            $mail_to = $turno->dato->correo;
            $recordatorios[] = $mail_to;
            $dia = date('Y-m-d', strtotime($turno->fecha));
            $hora = date('H:i:s', strtotime($turno->fecha));
            $empresa = Empresa::findOne($turno->empresa_id);
            $msj = "Le recordamos que tiene un turno a nombre de  ".$turno->dato->nombre." el día $dia a la hora $hora
                    <br>Empresa: ".$empresa->nombre."
                    <br>Empleado: ".$turno->dato->nombre."
                    <br>Servicios: ".$turno->getServicios()."
                    <br>Fecha: $dia
                    <br>Hora: $hora<hr>
                    Turnos - $empresa->nombre<br>
                    <a href='http://turnos.desligar.me' target='_blank'>turnos.deligar.me</a>
                    ";
            if($mail_to){
                Yii::$app->mailer->compose()
                ->setSubject('Recordatorio de turno')
                //->setHtmlBody("Le recordamos que tiene un turno para el día: $turno->fecha.")
                ->setHtmlBody($msj)
                ->setFrom('turnos@desligar.me')
                ->setTo($mail_to)
                ->send();
                sleep(1);
            }
        }
        return json_encode($recordatorios);
    }


    function isRol($rol){
        $user_id =Yii::$app->user->id;
        return in_array($rol, array_keys(\Yii::$app->authManager->getRolesByUser($user_id)));
    }

    public function actionEstado($id){
        $model = $this->findModel($id);
        $request = Yii::$app->request->get();
        if(isset($request['estado'])){
            $model->estado = $request['estado'];
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->redirect(['index']);
            }
        }
    }


    /**
     * Creates a new Turno model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAgendar($id)
    {
        $this->layout = 'vacio';
        $model = new Turno;
        $modelDato = new Dato();
        if (($empresa = Empresa::findOne($id)) !== null) {
            $model->empresa_id = $empresa->id;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        //Comprobar que la empresa tenga habiliada la creación de turnos al publico
        $data['Turno'] = Yii::$app->request->post('Turno');
        $data['Dato'] = Yii::$app->request->post('Dato');
        $load = false;
        if($data['Turno']){
            if(isset($data['Turno']['horario'])){
                $fechas = explode(',', $data['Turno']['horario']);
                $data['Turno']['desde'] = date('Y-m-d H:i:s', strtotime($fechas[0]));
                $data['Turno']['hasta'] = date('Y-m-d H:i:s', strtotime($fechas[1]));
                $data['Turno']['token'] = md5(time());
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        $load = $model->load($data);
        $model->servicio_id = intval($data['Turno']['servicio_id']);

        if ($load && $model->save()) {

            $loadDato = $modelDato->load($data);
            $modelDato->turno_id = $model->id;
            $modelDato->uploadFile('adjunto');

            if($loadDato && $modelDato->save()) {
                //FIXME: REPARAR ENVIO DE MAIL
                $model->enviarMail();
                return $this->redirect(['gracias', 'id' => $model->id]);
            } else {
                // var_dump('modelDato',$modelDato->errors);die;
            }
        } else {
            // var_dump('model',$model->errors);die;
            return $this->render('agendar', [
                'model' => $model,
                'modelDato' => $modelDato,
                'modelEmpresa' => $empresa,
            ]);
        }
    }

    /**
     * Creates a new Turno model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionNuevo($id)
    {
        $this->layout = 'main_publico';
        $model = new Turno;
        $modelDato = new Dato();
        if (($empresa = Empresa::findOne($id)) !== null) {
            $model->empresa_id = $empresa->id;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        //Comprobar que la empresa tenga habiliada la creación de turnos al publico
        $data['Turno'] = Yii::$app->request->post('Turno');
        $data['Dato'] = Yii::$app->request->post('Dato');
        $load = false;
        if($data['Turno']){
            if(isset($data['Turno']['horario']))
                $data['Turno']['fecha'] = $data['Turno']['horario'];
            else 
                $data['Turno']['fecha'] = NULL;
            $model->token = md5(time());
        }
        $load = $model->load($data);

        if ($load && $model->save()) {

            $loadDato = $modelDato->load($data);
            $modelDato->turno_id = $model->id;
            $modelDato->uploadFile('adjunto');

            if($loadDato && $modelDato->save()) {
                if(is_array($data['Turno']['servicios'])){
                    foreach ($data['Turno']['servicios'] as $key => $value) {
                        $turnoHasServicio = new TurnoHasServicio;
                        $turnoHasServicio->turno_id = $model->id;
                        $turnoHasServicio->servicio_id = $value;
                        $turnoHasServicio->save();
                    }
                } else {
                    $turnoHasServicio = new TurnoHasServicio;
                    $turnoHasServicio->turno_id = $model->id;
                    $turnoHasServicio->servicio_id = $data['Turno']['servicios'];
                    $turnoHasServicio->save();
                }
                //FIXME: REPARAR ENVIO DE MAIL
                $model->enviarMail();
                return $this->redirect(['gracias', 'id' => $model->id]);
            } else {
                // var_dump('modelDato',$modelDato->errors);die;
            }
        } else {
            // var_dump('model',$model->errors);die;
            return $this->render('nuevo', [
                'model' => $model,
                'modelDato' => $modelDato,
                'modelEmpresa' => $empresa,
            ]);
        }
    }

    /**
     * Displays a single Turno model.
     * @param integer $id
     * @return mixed
     */
    public function actionGracias($id)
    {
        $model = $this->findModel($id)->getDato()->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['gracias', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    public function actionRenderDatePickerDiasPorSemana($id){
        $this->layout = 'vacio';
        $model = ConfigReserva::find()->where(['servicio_id' => $id])->one();
        $modelSemanaReserva = $model->getSemanaReservas()->one();
        $diasHabiles = $modelSemanaReserva->diasHabiles;
        $diasNoHabiles = $modelSemanaReserva->diasNoHabiles;
        

        $endDate = $model->servicio->habil_hasta 
                    ? date('d-m-Y', strtotime($model->servicio->habil_hasta))
                    : null;
        $startDate = date('d-m-Y', strtotime($model->servicio->habil_desde)) > date('d-m-Y', strtotime('NOW')) 
                    ? date('d-m-Y', strtotime($model->servicio->habil_desde))
                    : date('d-m-Y', strtotime('NOW'));

        if($model){
            return $this->render('_fecha_dias_por_semana', [
                'diasHabiles' => $diasHabiles,
                'diasNoHabiles' => $diasNoHabiles,
                'endDate' => $endDate,
                'startDate' => $startDate,
                'empresa_id' => $model->servicio->categoria->empresa_id,
            ]);
        }
    }
}
