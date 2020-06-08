<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Turno;

/**
 * TurnoSearch represents the model behind the search form about `app\models\Turno`.
 */
class TurnoSearch extends Turno
{
    public function rules()
    {
        return [
            [['id', 'empresa_id', 'datos_id'], 'integer'],
            [['desde', 'hasta', 'token', 'estado', 'fecha_modificacion'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Turno::find()
                    ->joinWith(['dato']);


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


        // $query->innerJoin('empresa','empresa.id = turno.empresa_id');
        $query->joinWith(['servicio', 'empresa']);
        // $query->leftJoin('turno_has_servicio','turno_has_servicio.turno_id = turno.id');
        // $query->innerJoin('servicio', 'servicio.id = turno_has_servicio.servicio_id');
        $query->select(['turno.id','documento','desde', 'hasta', 'dato.nombre', 'estado','dato.telefono','dato.correo','cargo','documento','servicio.nombre as servicios', 'empresa.nombre as empresa']);
        $query->groupBy('turno.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
                ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'fecha' => $this->fecha,
            'empresa_id' => $this->empresa_id,
            'fecha_modificacion' => $this->fecha_modificacion,
            'datos_id' => $this->datos_id,
        ]);

        $query->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
