<?php
namespace app\controllers;

use Yii;
use dektrium\user\controllers\RegistrationController as BaseRegistrationController;
use app\models\Empresa;
use app\models\User;
use app\models\Usuario;
use dektrium\user\models\RegistrationForm;

class RegistrationController extends BaseRegistrationController
{
    /**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise
     * redirects to home page.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRegister()
    {
        if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        /** @var RegistrationForm $model */
        $model = \Yii::createObject(RegistrationForm::className());
        $modelEmpresa = new Empresa;
        $modelUsuario = new Usuario;
        
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

        $this->performAjaxValidation($model);
        //TODO: Agregar transaction
        // $connection = \Yii::$app->db;
        // $transaction = $connection->beginTransaction();
        // try {
            if ($model->load(\Yii::$app->request->post()) && $model->register()) {
                $modelUser = User::find()->where(['email' => $model->email])->one();
                $modelUsuario->id = $modelUser->id;
                $modelUsuario->correo = $modelUser->email;
                if($modelUsuario->save()){
                    //Asigno rol de empresa
                    $auth = Yii::$app->authManager;
                    $authorRole = $auth->getRole('empresa');
                    $auth->assign($authorRole, $modelUser->id);

                    $data['Empresa'] = Yii::$app->request->post('Empresa');
                    $data['Empresa']['usuario_id'] = $modelUser->id;
                    $data['Empresa']['correo'] = $modelUser->email;
                    $modelEmpresa->load($data);
                    $modelEmpresa->uploadFile('logo');

                    if ( $modelEmpresa->save() ) {
                        $this->trigger(self::EVENT_AFTER_REGISTER, $event);

                        return $this->render('/message', [
                            'title'  => \Yii::t('user', 'Tu cuenta ha sido creada!'),
                            'module' => $this->module,
                        ]);
                    } else {
                        $modelUsuario->delete();
                        $modelUser->delete();
                    }
                } else {
                    $modelUser->delete();
                }
            }
        // } catch (\Exception $e) {
        //     $transaction->rollBack();
        //     throw $e;
        // } catch (\Throwable $e) {
        //     $transaction->rollBack();
        //     throw $e;
        // }
        return $this->render('register', [
            'model'  => $model,
            'modelEmpresa' => $modelEmpresa,
            'module' => $this->module,
        ]);
    }
}