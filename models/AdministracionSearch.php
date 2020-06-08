<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Administracion;

/**
 * AdministracionSearch represents the model behind the search form about `app\models\Administracion`.
 */
class AdministracionSearch extends Administracion
{
    public function rules()
    {
        return [
            [['id', 'empresa_id', 'usuario_id'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Administracion::find();

        $user_id =Yii::$app->user->id;
        if( !in_array('admin', array_keys(\Yii::$app->authManager->getRolesByUser($user_id))) )
            $query->where(['empresa_id'=>Empresa::find()->where(['usuario_id' => Yii::$app->user->id])->one()->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'empresa_id' => $this->empresa_id,
            'usuario_id' => $this->usuario_id,
        ]);

        return $dataProvider;
    }
}
