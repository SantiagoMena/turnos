<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Categoria;

/**
 * CategoriaSearch represents the model behind the search form of `app\models\Categoria`.
 */
class CategoriaSearch extends Categoria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'empresa_id'], 'integer'],
            [['nombre'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Categoria::find();


        function isRol($rol){
            $user_id =Yii::$app->user->id;
            return in_array($rol, array_keys(\Yii::$app->authManager->getRolesByUser($user_id)));
        }
        if(isRol('administracion'))
            $empresa_id = Administracion::find()->where(['usuario_id' => Yii::$app->user->id])->one()->empresa_id;
        if(isRol('empresa'))
            $empresa_id = Empresa::find()->where(['usuario_id' => Yii::$app->user->id])->one()->id;
        if(!isRol('admin'))
            $query->where(['empresa_id'=>$empresa_id]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'empresa_id' => $this->empresa_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
