<?php

namespace app\models\forms;

use yii\base\Model;
use app\models\Empresa;
use app\models\DiaTurno;
use app\models\FranjaHoraria;
use app\models\FranjaHorariaHasDiaTurno;

class EmpresaForm extends Model
{
    // public $dias;
    // public $franjas;
    public $empresa;
    public $configuracion;

    public function __construct(){
      parent::__construct();

    }

    public function rules()
    {
        return [
            // [['id'], 'integer'],
            // [['nombre', 'empresa_id'], 'required'],
            // [['tipo', 'descripcion'], 'string'],
            [['dias', 'franjas'], 'safe'],
            // [['logo'], 
                // 'file', 'skipOnEmpty' => true, 
                // 'extensions' => 'png, jpg, jpeg, gif, svg'
            // ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            // 'id' => 'ID',
            // 'nombre' => 'Nombre',
            // 'tipo' => 'Tipo',
            // 'empresa_id' => 'Consorcio ID',
            // 'imagen' => 'Imagen',
            // 'descripcion' => 'Descripcion',
            // 'cualquier_dia' => 'Todos Días',
            // 'cualquier_horario' => 'Cualquier Horario',
        ];
    }

    public function save(){
        if(!$this->empresa)
            return false;
        /*$empresa = new Empresa;
        if($this->id){
            //Buscar existente
            if( !($empresa = Empresa::find()->where(['id'=>$this->empresa->id])->one()) ){
                return false;
            }
        }*/
        // $empresa->setAttributes($this->getAttributes());

        if($this->empresa->save() && $this->configuracion->save()){
            // $franjas_id = FranjaHoraria::find()
            //     ->select('id')
            //     ->where(['empresa_id' => $this->id])
            //     ->asArray()->all();

            // FranjaHorariaHasDiaTurno::deleteAll(['in', 'franja_horaria_id', array_values($franjas_id)]);

            //Elimino las relaciones de franjas
            FranjaHoraria::deleteAll("empresa_id = ".$this->empresa->id);
            //Elimino las relaciones de dias
            DiaTurno::deleteAll("empresa_id = ".$this->empresa->id);
            // $dias_empresa = DiaTurno::find()->where(['empresa_id' => $this->id])->all();
            // foreach ($dias_empresa as $dia_empresa){
            //     $dia_empresa->delete();
            // }

            if($this->dias && is_array($this->dias)){
                foreach ($this->dias as $dia) {
                    $diaTurno = new DiaTurno;
                    $diaTurno->dia = $dia;
                    $diaTurno->link('empresa',$this->empresa);
                    $diaTurno->save();
                }
            }
            // var_dump($this->franjas);die;
            // Cambiar por verificar si se pisan las franjas
            $dias_usados = [];
            if($this->franjas && is_array($this->franjas)){
                foreach ($this->franjas as $franja) {
                    if(isset($franja['dias']) && is_array($franja['dias']) && !empty($franja['dias'])){
                        $dias = $franja['dias'];
                        $franjaHoraria = new FranjaHoraria;
                        $franjaHoraria->empresa_id = $this->empresa->id;
                        $franjaHoraria->desde = $franja['desde'];
                        $franjaHoraria->hasta = $franja['hasta'];
                        $franjaHoraria->tiene_turnos = isset($franja['tiene_turnos']) ? $franja['tiene_turnos'] : 0;
                        $franjaHoraria->minutos_turno = isset($franja['minutos_turno']) ? $franja['minutos_turno'] : 0;
                        $franjaHoraria->cupos = isset($franja['cupos']) ? $franja['cupos'] : 1;
                        $franjaHoraria->tiene_limpieza = isset($franja['tiene_limpieza']) ? $franja['tiene_limpieza'] : 0;
                        $franjaHoraria->tiempo_limpieza = isset($franja['tiempo_limpieza']) ? $franja['tiempo_limpieza'] : 0;

                        if($franjaHoraria->save()){
                            foreach ($dias as $dia) {
                                // if(in_array($dia, $dias_usados)){
                                    
                                //     continue;
                                // }

                                $diaTurno = DiaTurno::find()
                                            ->joinWith(['franjaHorariaHasDiaTurnos'])
                                            // ->select(['dia_turno.*', 'franja_horaria_has_dia_turno.*'])
                                            ->where(['empresa_id'=>$this->empresa->id, 'dia'=>$dia])
                                            // ->andWhere(['franja_horaria_has_dia_turno.franja_horaria_id' => null])
                                            ->one();
                                if($diaTurno){
                                    $franjaHoraria->link('diaTurnos',$diaTurno);
                                    $dias_usados[] = $dia;
                                }
                            }
                        }

                        // $diaTurno = DiaTurno::find()->where(['dia'=>'']);
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }
}