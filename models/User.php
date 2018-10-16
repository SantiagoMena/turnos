<?php
namespace app\models;

use dektrium\user\models\User as BaseUser;

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

    public function esRol($rol){
        var_dump(\Yii::$app->authManager->getRolesByUser($this->id));
    }
}

?>