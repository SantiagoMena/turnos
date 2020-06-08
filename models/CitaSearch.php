<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cita;
use app\models\Secretaria;

/**
 * CitaSearch represents the model behind the search form about `app\models\Cita`.
 */
class CitaSearch extends Cita
{
    public $empresa;
    public $examenes;
    public function rules()
    {
        return [
            [['id', 'empresa_id'], 'integer'],
            [['fecha', 'cedula', 'nombre', 'telefono', 'correo', 'cargo', 'documento','empresa'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Cita::find();
        function isRol($rol){
            $user_id =Yii::$app->user->id;
            return in_array($rol, array_keys(\Yii::$app->authManager->getRolesByUser($user_id)));
        }
        if(isRol('secretaria'))
            $empresa_id = Secretaria::find()->where(['usuario_id' => Yii::$app->user->id])->one()->empresa_id;
        if(isRol('empresa'))
            $empresa_id = Empresa::find()->where(['usuario_id' => Yii::$app->user->id])->one()->id;
        if(!isRol('admin'))
            $query->where(['empresa_id'=>$empresa_id]);
        // $query->with(['empresa']);
        
        $query->innerJoin('empresa','empresa.id = cita.empresa_id');
        $query->leftJoin('cita_has_examen','cita_has_examen.cita_id = cita.id');
        $query->innerJoin('examen', 'examen.id = cita_has_examen.examen_id');
        $query->select(['cita.id','cedula','fecha', 'cita.nombre','cita.telefono','cita.correo','cargo','documento',"GROUP_CONCAT(examen.nombre SEPARATOR ',') as examenes ", 'empresa.nombre as empresa']);
        $query->groupBy('cita.id');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['empresa'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['empresa.nombre' => SORT_ASC],
            'desc' => ['empresa.nombre' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['examenes'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['examenes' => SORT_ASC],
            'desc' => ['examenes' => SORT_DESC],
        ];
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'date(fecha)' => $this->fecha,
            'empresa_id' => $this->empresa_id,
        ]);

        $query->andFilterWhere(['like', 'cedula', $this->cedula])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'correo', $this->correo])
            ->andFilterWhere(['like', 'cargo', $this->cargo])
            ->andFilterWhere(['like', 'empresa.nombre', $this->empresa])
            ->andFilterWhere(['like', 'documento', $this->documento])
            ->andFilterWhere(['like', 'examenes', $this->examenes]);

        return $dataProvider;
    }
}
