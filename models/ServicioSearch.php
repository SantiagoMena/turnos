<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Servicio;

/**
 * ServicioSearch represents the model behind the search form about `app\models\Servicio`.
 */
class ServicioSearch extends Servicio
{
    public function rules()
    {
        return [
            [['id', 'categoria_id', 'siempre_habil'], 'integer'],
            [['nombre', 'habil_desde', 'habil_hasta'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Servicio::find()->joinWith(['categoria']);

        function isRol($rol){
            $user_id =Yii::$app->user->id;
            return in_array($rol, array_keys(\Yii::$app->authManager->getRolesByUser($user_id)));
        }
        if(isRol('administracion'))
            $empresa_id = Administracion::find()->where(['usuario_id' => Yii::$app->user->id])->one()->empresa_id;
        if(isRol('empresa'))
            $empresa_id = Empresa::find()->where(['usuario_id' => Yii::$app->user->id])->one()->id;
        if(!isRol('admin'))
            $query->where(['categoria.empresa_id'=>$empresa_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'categoria_id' => $this->categoria_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
