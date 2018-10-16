<?php

namespace app\controllers;

use Yii;
use app\models\Secretaria;
use app\models\SecretariaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\Empresa;
use yii\filters\AccessControl;

/**
 * SecretariaController implements the CRUD actions for Secretaria model.
 */
class SecretariaController extends Controller
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
                        'roles' => ['empresa', 'admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Secretaria models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SecretariaSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Secretaria model.
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
     * Creates a new Secretaria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Secretaria;
        $user = new User;
        if(Yii::$app->request->post('User')){

            $user->username = Yii::$app->request->post('User')['username'];
            $user->password = Yii::$app->request->post('User')['password'];
            $user->email = Yii::$app->request->post('Secretaria')['correo'];
            if($user->save()){
                //Asigno rol de secretaria
                $auth = Yii::$app->authManager;
                $authorRole = $auth->getRole('secretaria');
                $auth->assign($authorRole, $user->getId());
                //Asigno id de user
                $data['Secretaria'] = Yii::$app->request->post('Secretaria');
                $data['Secretaria']['user_id'] = $user->id;

                $user_id =Yii::$app->user->id;
                if( !in_array('admin', array_keys(\Yii::$app->authManager->getRolesByUser($user_id))) ){
                    $data['Secretaria']['empresa_id'] = Empresa::find()->where(['user_id' => Yii::$app->user->id])->one()->id;
                }
                
                if ($model->load($data) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('create', [
                        'model' => $model,
                        'user' => $user,
                    ]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'user' => $user,
                ]);
            }
        } else {
                return $this->render('create', [
                    'model' => $model,
                    'user' => $user,
                ]);
            }
    }

    /**
     * Updates an existing Secretaria model.
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
     * Deletes an existing Secretaria model.
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
     * Finds the Secretaria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Secretaria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Secretaria::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
