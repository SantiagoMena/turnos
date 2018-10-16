<?php

namespace app\controllers;

use Yii;
use app\models\Cita;
use app\models\CitaSearch;
use app\models\Secretaria;
use app\models\Empresa;
use app\models\CitaHasExamen;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * CitaController implements the CRUD actions for Cita model.
 */
class CitaController extends Controller
{
    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config);
        $this->layout = 'main_cita';
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'horarios'],
                        'roles' => ['empresa', 'secretaria', 'admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['recordar'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Cita models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CitaSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Cita model.
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
     * Creates a new Cita model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cita;
        //Instanciar automaticamente el id de empresa dependiendo el usuario
        $data['Cita'] = Yii::$app->request->post('Cita');
        $load = false;
        if($data['Cita']){
            $data['Cita']['fecha'] = $data['Cita']['horario'];
            if($this->isRol('secretaria'))
                $empresa_id = Secretaria::find()->where(['user_id' => Yii::$app->user->id])->one()->empresa_id;
            if($this->isRol('empresa'))
                $empresa_id = Empresa::find()->where(['user_id' => Yii::$app->user->id])->one()->id;
            if(!$this->isRol('admin'))
                $data['Cita']['empresa_id'] = $empresa_id;
            $load = $model->load($data);
            $model->uploadFile('documento');
        }
        if ($load && $model->save()) {
            if(is_array($data['Cita']['examenes'])){
                foreach ($data['Cita']['examenes'] as $key => $value) {
                    $citaHasExamen = new CitaHasExamen;
                    $citaHasExamen->cita_id = $model->id;
                    $citaHasExamen->examen_id = $value;
                    $citaHasExamen->save();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Cita model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->examenes = ArrayHelper::map(
                                        CitaHasExamen::find()->where(['cita_id'=>$id])->with(['examen'])->all(), 'examen_id', 'examen_id');
        
        $data['Cita'] = Yii::$app->request->post('Cita');
        $load = false;
        if($data['Cita']){
            if($this->isRol('secretaria'))
                $empresa_id = Secretaria::find()->where(['user_id' => Yii::$app->user->id])->one()->empresa_id;
            if($this->isRol('empresa'))
                $empresa_id = Empresa::find()->where(['user_id' => Yii::$app->user->id])->one()->id;
            if(!$this->isRol('admin'))
                $data['Cita']['empresa_id'] = $empresa_id;
            $load = $model->load($data);
            $model->uploadFile('documento');
        }
        if ($load && $model->save()) {
            if(is_array($data['Cita']['examenes'])){
                \Yii::$app
                ->db
                ->createCommand()
                ->delete('cita_has_examen', ['cita_id' => $id])
                ->execute();
                foreach ($data['Cita']['examenes'] as $key => $value) {
                    $citaHasExamen = new CitaHasExamen;
                    $citaHasExamen->cita_id = $model->id;
                    $citaHasExamen->examen_id = $value;
                    $citaHasExamen->save();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Cita model.
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
     * Finds the Cita model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cita the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cita::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionHorarios($fecha){
        $model = new Cita;
        return $model->getHorarios(date('Y-m-d', strtotime($fecha)));
    }

    public function actionRecordar(){
        $model = new Cita;
        $citasPendientes = $model->getCitasPendientes();
        $recordatorios = [];
        foreach ($citasPendientes as $key => $cita) {
            $mail_to = $cita->correo;
            $recordatorios[] = $mail_to;
            if($mail_to){
                Yii::$app->mailer->compose()
                ->setSubject('Recordatorio de turno')
                ->setHtmlBody("Le recordamos que tiene un turno para el día: $cita->fecha.")
                ->setFrom('citas@integrarips.com')
                ->setTo($mail_to)
                ->send();
            }
        }
        return json_encode($recordatorios);
    }


    function isRol($rol){
        $user_id =Yii::$app->user->id;
        return in_array($rol, array_keys(\Yii::$app->authManager->getRolesByUser($user_id)));
    }
}
