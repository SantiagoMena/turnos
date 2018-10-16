<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Secretaria;
use app\models\Empresa;

/**
 * SecretariaSearch represents the model behind the search form about `app\models\Secretaria`.
 */
class SecretariaSearch extends Secretaria
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'empresa_id'], 'integer'],
            [['nombre', 'telefono', 'correo', 'username', 'empresa'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Secretaria::find();

        $user_id =Yii::$app->user->id;
        if( !in_array('admin', array_keys(\Yii::$app->authManager->getRolesByUser($user_id))) )
            $query->where(['empresa_id'=>Empresa::find()->where(['user_id' => Yii::$app->user->id])->one()->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['username'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['user.username' => SORT_ASC],
            'desc' => ['user.username' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['empresa'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['empresa.nombre' => SORT_ASC],
            'desc' => ['empresa.nombre' => SORT_DESC],
        ];
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andWhere([
            // 'id' => $this->id,
            // 'user_id' => $this->user_id,
            // 'empresa_id' => $this->empresa_id,
            // 'empresa_id' => Empresa::find()->where(['user_id' => Yii::$app->user->id])->one()->id,
        ]);

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            // 'empresa_id' => $this->empresa_id,
            // 'empresa_id' => Empresa::find()->where(['user_id' => Yii::$app->user->id])->one()->id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'empresa.nombre', $this->empresa])
            ->andFilterWhere(['like', 'correo', $this->correo]);

        return $dataProvider;
    }
}
