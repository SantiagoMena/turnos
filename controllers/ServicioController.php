<?php

namespace app\controllers;

use Yii;
use app\models\Servicio;
use app\models\ConfigReserva;
use app\models\ConfigTurno;
use app\models\SemanaReserva;
use app\models\Empresa;
use app\models\ServicioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ServicioController implements the CRUD actions for Servicio model.
 */
class ServicioController extends Controller
{
    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config);
        $this->layout = 'main_default';
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['empresa', 'administracion'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Servicio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServicioSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Servicio model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Servicio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Servicio;
        $model->siempre_habil = 1;
        $modelConfigReserva = new ConfigReserva;
        $modelSemanaReserva = new SemanaReserva;
        $modelConfigTurno = new ConfigTurno;
        $errors = [];
        function isRol($rol){
            $user_id =Yii::$app->user->id;
            return in_array($rol, array_keys(\Yii::$app->authManager->getRolesByUser($user_id)));
        }

        $empresa_id = false;
        if(isRol('administracion'))
            $empresa_id = Administracion::find()->where(['usuario_id' => Yii::$app->user->id])->one()->empresa_id;
        if(isRol('empresa'))
            $empresa_id = Empresa::find()->where(['usuario_id' => Yii::$app->user->id])->one()->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //Guardo Config Reserva
            $modelConfigReserva->load(Yii::$app->request->post());
            $modelConfigReserva->servicio_id = $model->id;
            if($modelConfigReserva->save()){
                //Según el tipo de reserva guardo el modelo
                if($modelConfigReserva->tipo === 'Dias por semana'){
                    //Guardo Config Turno
                    $modelConfigTurno->empresa_id = $empresa_id;
                    if ($modelConfigTurno->load(Yii::$app->request->post()) && $modelConfigTurno->save()) {
                        //Guardo Semana reserva
                        $modelSemanaReserva->load(Yii::$app->request->post());
                        $modelSemanaReserva->config_reserva_id = $modelConfigReserva->id;
                        $modelSemanaReserva->config_turno_id = $modelConfigTurno->id;
                        if($modelSemanaReserva->save()){
                            return $this->redirect(['view', 'id' => $model->id]);
                        } else $errors['modelSemanaReserva'] = $modelSemanaReserva->getErrors();
                    } else $errors['modelConfigTurno'] = $modelConfigTurno->getErrors();
                } else $errors['tipoReserva'] = 'No coincide';
            } else $errors['modelServicio'] = $modelConfigReserva->getErrors();
        } else $errors['modelServicio'] = $model->getErrors();
        return $this->render('create', [
            'model' => $model,
            'empresa_id' => $empresa_id,
            'modelConfigReserva' => $modelConfigReserva,
            'modelConfigTurno' => $modelConfigTurno,
            'modelSemanaReserva' => $modelSemanaReserva,
            'errors' => $errors,
        ]);
    }

    /**
     * Updates an existing Servicio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelConfigTurno = new ConfigTurno;
        $errors = [];
        if($model->getConfigReservas()->exists()){
            $modelConfigReserva = $model->getConfigReservas()->one();
            switch ($modelConfigReserva->tipo) {
                case 'Dias por semana':
                    if($modelConfigReserva->getSemanaReservas()->exists()){
                        $modelSemanaReserva = $modelConfigReserva->getSemanaReservas()->one();
                        if($modelSemanaReserva->getConfigTurno()->exists()){
                            $modelConfigTurno = $modelSemanaReserva->getConfigTurno()->one();
                        } else {
                            $modelConfigTurno = new ConfigTurno;
                        }
                    } else {
                        $modelSemanaReserva = new SemanaReserva;
                    }
                    break;
                
                default:
                    //Definir todos los modelos
                    $modelSemanaReserva = new SemanaReserva;
                    $modelConfigTurno = new ConfigTurno;
                    break;
            }
        } else {
            $modelConfigReserva = new ConfigReserva;
            $modelSemanaReserva = new SemanaReserva;
            $modelConfigTurno = new ConfigTurno;
        }

        

        function isRol($rol){
            $user_id =Yii::$app->user->id;
            return in_array($rol, array_keys(\Yii::$app->authManager->getRolesByUser($user_id)));
        }

        $empresa_id = false;
        if(isRol('administracion'))
            $empresa_id = Administracion::find()->where(['usuario_id' => Yii::$app->user->id])->one()->empresa_id;
        if(isRol('empresa'))
            $empresa_id = Empresa::find()->where(['usuario_id' => Yii::$app->user->id])->one()->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //Guardo Config Reserva
            $modelConfigReserva->load(Yii::$app->request->post());
            $modelConfigReserva->servicio_id = $model->id;
            if($modelConfigReserva->save()){
                //Según el tipo de reserva guardo el modelo
                if($modelConfigReserva->tipo === 'Dias por semana'){
                    //Guardo Config Turno
                    $modelConfigTurno->empresa_id = $empresa_id;
                    if ($modelConfigTurno->load(Yii::$app->request->post()) && $modelConfigTurno->save()) {
                        //Guardo Semana reserva
                        $modelSemanaReserva->load(Yii::$app->request->post());
                        $modelSemanaReserva->config_reserva_id = $modelConfigReserva->id;
                        $modelSemanaReserva->config_turno_id = $modelConfigTurno->id;
                        if($modelSemanaReserva->save()){
                            return $this->redirect(['view', 'id' => $model->id]);
                        } else $errors['modelSemanaReserva'] = $modelSemanaReserva->getErrors();
                    } else $errors['modelConfigTurno'] = $modelConfigTurno->getErrors();
                } else $errors['tipoReserva'] = 'No coincide';
            } else $errors['modelServicio'] = $modelConfigReserva->getErrors();
        }
        return $this->render('update', [
            'model' => $model,
            'empresa_id' => $empresa_id,
            'modelConfigReserva' => $modelConfigReserva,
            'modelConfigTurno' => $modelConfigTurno,
            'modelSemanaReserva' => $modelSemanaReserva,
            'errors' => $errors,
        ]);
    }

    /**
     * Deletes an existing Servicio model.
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
     * Finds the Servicio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Servicio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Servicio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRenderFormularioDiasPorSemana(){
        $modelSemanaReserva = new SemanaReserva;
        $modelConfigTurno = new ConfigTurno;
        return $this->render('_formulario_dias_por_semana', [
            'modelSemanaReserva' => $modelSemanaReserva,
            'modelConfigTurno' => $modelConfigTurno,
        ]);
    }
}
