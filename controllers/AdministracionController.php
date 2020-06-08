<?php

namespace app\controllers;

use Yii;
use app\models\Administracion;
use app\models\AdministracionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Usuario;
use app\models\Empresa;
use app\models\User;
use yii\filters\AccessControl;

/**
 * AdministracionController implements the CRUD actions for Administracion model.
 */
class AdministracionController extends Controller
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
                        'roles' => ['empresa'],
                    ],
                ],
            ],
        ];
    }
    /**
     * Lists all Administracion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdministracionSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Administracion model.
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
     * Creates a new Administracion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new Administracion;

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('create', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Creates a new Secretaria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Administracion;
        $user = new User;
        $usuario = new Usuario;
        if(Yii::$app->request->post('User')){

            $user->username = Yii::$app->request->post('User')['username'];
            $user->password = Yii::$app->request->post('User')['password'];
            $user->email = Yii::$app->request->post('Usuario')['correo'];

            $usuario->correo = Yii::$app->request->post('Usuario')['correo'];
            //Agregar nombre y telefono
            if($user->save()){
                $usuario->id = $user->id;
                if($usuario->save()){
                    //Asigno rol de administracion
                    $auth = Yii::$app->authManager;
                    $authorRole = $auth->getRole('administracion');
                    $auth->assign($authorRole, $user->getId());
                    //Asigno id de user
                    $data['Administracion'] = Yii::$app->request->post('Administracion');
                    $data['Administracion']['usuario_id'] = $user->id;

                    if($this->isRol('administracion'))
                        $empresa_id = Administracion::find()->where(['usuario_id' => Yii::$app->user->id])->one()->empresa_id;
                    if($this->isRol('empresa'))
                        $empresa_id = Empresa::find()->where(['usuario_id' => Yii::$app->user->id])->one()->id;
                    if($this->isRol('admin'))
                       $empresa_id = $data['Administracion']['empresa_id'];

                    $data['Administracion']['empresa_id'] = $empresa_id;
                    
                    $user_id =Yii::$app->user->id;
                    if( !in_array('admin', array_keys(\Yii::$app->authManager->getRolesByUser($user_id))) ){
                        $data['Administracion']['empresa_id'] = Empresa::find()->where(['usuario_id' => Yii::$app->user->id])->one()->id;
                    }
                    
                    if ($model->load($data) && $model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        return $this->render('create', [
                            'model' => $model,
                            'user' => $user,
                            'usuario' => $usuario,
                        ]);
                    }
                } else {
                    return $this->render('create', [
                        'model' => $model,
                        'user' => $user,
                        'usuario' => $usuario,
                    ]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'user' => $user,
                    'usuario' => $usuario,
                ]);
            }
        } else {
                return $this->render('create', [
                    'model' => $model,
                    'user' => $user,
                    'usuario' => $usuario,
                ]);
            }
    }
    /**
     * Updates an existing Administracion model.
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
     * Deletes an existing Administracion model.
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
     * Finds the Administracion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Administracion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Administracion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    function isRol($rol){
        $user_id =Yii::$app->user->id;
        return in_array($rol, array_keys(\Yii::$app->authManager->getRolesByUser($user_id)));
    }
}
