<?php
namespace app\models;

use dektrium\user\models\User as BaseUser;
use yii\helpers\Html;
use app\models\Empresa;
use app\models\Secretaria;
use Yii;

class User extends BaseUser
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username','password'], 'required']
        ];
    }
	
    public function findByUsername($username){
        User::find()->where(['username' => $username])->one();
    }

    public static function esRol($rol){
        $user_id =Yii::$app->user->id;
        return in_array($rol, array_keys(\Yii::$app->authManager->getRolesByUser($user_id)));
    }

    public static function getLogo(){
        $user_id =Yii::$app->user->id;
        if(User::esRol('empresa')){
            return Html::img('@web/uploads/'.Empresa::find()->where(['usuario_id' => $user_id])->one()->logo, ['alt' => 'Turnos', 'class' => "img-responsive"]);
        } elseif(User::esRol('secretaria')){
            return Html::img('@web/uploads/'.Secretaria::find()->where(['usuario_id' => $user_id])->one()->empresa->logo, ['alt' => 'Turnos', 'class' => "img-responsive"]);
        } else/*if($this->esRol('admin'))*/{
            return Html::img('@web/images/logo.png', ['alt' => 'Turnos', 'class' => "img-responsive"]);
        }
    }

    public static function getEmpresa(){
        $user_id =Yii::$app->user->id;
        if(User::esRol('empresa')){
            return Empresa::find()->where(['usuario_id' => $user_id])->one()->id;
        } 
        return false;
    }
}

?>