<?php

namespace app\controllers;

use Yii;
use app\models\Empresa;
use app\models\User;
use app\models\EmpresaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * EmpresaController implements the CRUD actions for Empresa model.
 */
class EmpresaController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'horarios'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Empresa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmpresaSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Empresa model.
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
     * Creates a new Empresa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelEmpresa = new Empresa;
        $modelUser = new User;
        if(Yii::$app->request->post('User')){

            $modelUser->username = Yii::$app->request->post('User')['username'];
            $modelUser->password = Yii::$app->request->post('User')['password'];
            $modelUser->email = Yii::$app->request->post('Empresa')['correo'];
            if($modelUser->save()){
                //Asigno rol de empresa
                $auth = Yii::$app->authManager;
                $authorRole = $auth->getRole('empresa');
                $auth->assign($authorRole, $modelUser->getId());

                $data['Empresa'] = Yii::$app->request->post('Empresa');
                $data['Empresa']['user_id'] = $modelUser->id;
                $modelEmpresa->load($data);
                $modelEmpresa->uploadFile('logo');

                if ( $modelEmpresa->save() ) {
                    // $modelEmpresa->uploadFile('logo');
                    return $this->redirect(['view', 'id' => $modelEmpresa->id]);
                } else {
                    return $this->render('create', [
                        'model' => $modelEmpresa,
                        'user' => $modelUser,
                    ]);
                }
            } else {
                return $this->render('create', [
                    'model' => $modelEmpresa,
                    'user' => $modelUser,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $modelEmpresa,
                'user' => $modelUser,
            ]);
        }

        
    }

    /**
     * Updates an existing Empresa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Empresa model.
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
     * Finds the Empresa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Empresa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Empresa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
