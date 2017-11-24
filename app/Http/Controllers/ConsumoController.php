<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Consumo;
use App\Galpon;
use App\Silos;
use App\Http\Requests;
use App\Http\Requests\ConsumoRequest;
use Session;
use Redirect;
use DB;

class ConsumoController extends Controller {

    function index() {
    }

public function consumo_alimento() {
     return view('consumo.index');      
  }

  public function lista_conusmo_alimento($fecha_inicio, $fecha_fin) {
 $consumo = DB::SELECT("SELECT consumo.cantidad, consumo.id,galpon.numero as numero_galpon,fases.numero as numero_fase,fases.nombre,consumo.fecha,alimento.tipo from galpon,edad,fases,fases_galpon,consumo,alimento 
WHERE
consumo.id_alimento=alimento.id and 
galpon.id=edad.id_galpon AND edad.id=fases_galpon.id_edad AND fases.id=fases_galpon.id_fase AND consumo.id_fase_galpon=fases_galpon.id  ANd  Date_format(consumo.fecha,'%Y/%m/%d') BETWEEN Date_format('".$fecha_inicio."','%Y/%m/%d') and Date_format('".$fecha_fin."','%Y/%m/%d') and consumo.deleted_at IS NULL order by galpon.numero,consumo.fecha");
        return response()->json($consumo); 
  }


    public function create() {
    }

    public function store(ConsumoRequest $request) {
        $result = Silos::find($request->id_silo);
        $resultemperatura=DB::select('select *from temperatura');
        $temperatura=$resultemperatura[0]->temperatura;
        if ($request->ajax()) {
            $verificar = DB::select("select count(*)as count,cantidad from  silo where  id=" . $request->id_silo . " and silo.cantidad<" . $request->cantidad);
             if ($request->aumentar==1){
              $verificar2 = DB::select("select count(*)as count,cantidad,silo.nombre from  silo where  id=" . $request->id_silo2 . " and silo.cantidad<" . $request->cantidad2);
                if ( $verificar2[0]->count !=0) {
                return response()->json(["mensaje1" => "ESA CANTIDAD NO EXITE EN EL " . $verificar2[0]->nombre ]);
                  
                }
              }
            if ($verificar[0]->count == 0) {
               $id_alimento=DB::select('select alimento.id AS id_alimento,silo.nombre,alimento.tipo from silo,alimento where silo.id_alimento=alimento.id and silo.id='.$request->id_silo);
               if ($request->cantidad!=0) {
                $consumo = Consumo::create([
                    'id_fase_galpon'=>$request->id_fase_galpon,
                    'cantidad'=>$request->cantidad,
                    'id_silo'=>$request->id_silo,
                    'id_alimento'=> $id_alimento[0]->id_alimento,
                    'temperatura'=> $temperatura,
                  ]);

               }
             
              if ($request->aumentar==1) {
                 
                     
                    $id_alimento2=DB::select('select alimento.id AS id_alimento,silo.nombre,alimento.tipo from silo,alimento where silo.id_alimento=alimento.id and silo.id='.$request->id_silo2);
                $consumo = Consumo::create([
                    'id_fase_galpon'=>$request->id_fase_galpon,
                    'cantidad'=>$request->cantidad2,
                    'id_silo'=>$request->id_silo2,
                    'id_alimento'=> $id_alimento2[0]->id_alimento,
                    'temperatura'=> $temperatura,
                  ]);

               

              }
            
                $cantidad = DB::select("select COUNT(*)as count,silo.cantidad from silo where silo.id=" . $result['id'] . " and cantidad_minima>=" . $result['cantidad']); //para controlar la cantidad minima del silo actual
                if ($cantidad[0]->count != 0) {
                    return response()->json(["mensaje" => "QUEDA ".$cantidad[0]->cantidad." KG. DE GRANO EN EL " . $result['nombre'] . ""]);
                } else {
                    return response()->json($request->all());
                }
            } else

                return response()->json(["mensaje1" => "ESA CANTIDAD NO EXITE EN EL " . $result['nombre'],"cantidad"=>$result['cantidad'] ]);
        }
    }

    public function edit($id) {
        $consumo = Consumo::find($id);
        return response()->json($consumo);
    }

    public function editar_consumo(Request $request) {

    $result = Silos::find($request->id_silo);
        if ($request->ajax()) {
            //$verificar = DB::select("select count(*)as count from  silo where  id=" . $request->id_silo . " and silo.cantidad<" . $request->aux);
            $consumo = DB::select("select * from  consumo where  id=" . $request->id_consumo);
            if ($consumo[0]->cantidad >= $request->cantidad) {
               $total_cant = $consumo[0]->cantidad - $request->cantidad;
               $actua = DB::table('consumo')->where('id', $request->id_consumo)->update(['cantidad' => $request->cantidad,]);
                                   return response()->json($request->all());
            } else {
                $total_cant = $request->cantidad - $consumo[0]->cantidad;
                $verificar = DB::select("select count(*)as count from  silo where  id=" . $request->id_silo . " and silo.cantidad<" . $total_cant);

                if ($verificar[0]->count == 0) {
                   $actua = DB::table('consumo')->where('id', $request->id_consumo)->update(['cantidad' => $request->cantidad,]);
                                       return response()->json($request->all());
                } else{
                    return response()->json(["mensaje1" => "ESA CANTIDAD NO EXITE EN EL " . $result['nombre'] . ""]);
                }
            }
        }
    }


  public function destroy(Request $request){
     $id=$request->get('id_con');
      $ingreso=Consumo::find($id);
      $ingreso->delete();
      Session::flash('message','ELIMINADO CORRECTAMENTE');
     return Redirect::to('/consumo_alimento');
  }


}
