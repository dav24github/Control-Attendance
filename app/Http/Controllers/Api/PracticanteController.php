<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Model\Practicante;
use DB;

class PracticanteController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $practicantes = Practicante::with('horario')->where('estado','1')->paginate(10);
        return $practicantes;
    }

    public function indexHistorial()
    {
        $practicantes = Practicante::with('horario')->paginate(10);
        return $practicantes;
    }

    public function getPracticantes(){ //info
        $practicantes = Practicante::with('horario')->where('estado','1')->get();
        return response()->json($practicantes);
    }

    public function search(){
        
        if(\Request::get('q') == "")
            return $this->index();

        if($search = \Request::get('q')){
            $practicantes = Practicante::where(function($query) use ($search){
                $query->where('estado',1)
                        ->where('nombre','LIKE',"%$search%");
            })->paginate(10);
        }
        
        return $practicantes;
    }

    public function searchHistorial(){
        
        if(\Request::get('q') == "")
            return $this->index();

        if($search = \Request::get('q')){
            $practicantes = Practicante::where(function($query) use ($search){
                $query->where('nombre','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%");
            })->paginate(2);
        }
        
        return $practicantes;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre'=>'required|string',
            'horario_id'=>'required',
            'ci'=>'required|unique:practicantes',            
            'cu'=>'required|unique:practicantes',
            'carrera'=>'required|string',
            'email'=>'required|email|string|unique:practicantes',
            'telefono'=>'required|numeric|unique:practicantes',
            'direccion'=>'required|string',
            'f_ingreso'=>'required|date',

        ]);

        $p = new Practicante();
        if($request->foto){
            $position = strpos($request->foto,';');
            $sub = substr($request->foto,0,$position);
            $ext = explode('/',$sub)[1];
            $imageName = time().".".$ext;
            $img = Image::make($request->foto)->resize(240,240);
            $uploadPath = 'backEnd/assets/img/practicantes/';
            $imgUrl = $uploadPath.$imageName;
            $img->save($imgUrl);
            $p->foto = $imgUrl;

        }else{
            $p->foto = 'backEnd/assets/img/default/user-alt.png';
        }
        $p->nombre = $request->nombre;
        $p->horario_id = $request->horario_id;
        $p->ci = $request->ci;
        $p->cu = $request->cu;
        $p->carrera = $request->carrera;
        $p->email = $request->email;
        $p->telefono = $request->telefono;
        $p->direccion = $request->direccion;
        $p->f_ingreso = $request->f_ingreso;

        $p->save();

        // DB::table('check_faltas')->insert(['fecha'=>$request->f_ingreso]);

        return response()->json(['success'=>'Add Practicante']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $practicante = Practicante::where('id',$id)->first();
        return response()->json($practicante);
    }

    public function showPracticante($id){
        $practicante = DB::table('practicantes')
        ->join('horarios','practicantes.horario_id','horarios.id')        
        ->where('practicantes.id',$id)->first();

        $horarios = DB::table('practicantes')
        ->join('horarios','practicantes.horario_id','horarios.id')        
        ->join('horario_details','horario_details.horario_id','horarios.id')
        ->select('horario_details.hd_nombre','horario_details.horario_e','horario_details.horario_s')
        ->where('practicantes.id',$id)->get();

        return response()->json([$practicante,$horarios]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'nombre'=>'required|string',
            'horario_id'=>'required',
            'ci'=>'required|unique:practicantes,ci,'.$id,            
            'cu'=>'required|unique:practicantes,cu,'.$id,
            'carrera'=>'required|string',
            'email'=>'required|email|string|unique:practicantes,email,'.$id,
            'telefono'=>'required|numeric|unique:practicantes,telefono,'.$id,
            'direccion'=>'required|string',
            'f_ingreso'=>'required|date',
        ]);

        $p = Practicante::where('id',$id)->first();
        if($request->flag == "lleno"){
            $position = strpos($request->foto,';');
            $sub = substr($request->foto,0,$position);
            $ext = explode('/',$sub)[1];
            $imageName = time().".".$ext;
            $img = Image::make($request->foto)->resize(240,240);
            $uploadPath = 'backEnd/assets/img/practicantes/';
            $imgUrl = $uploadPath.$imageName;
            $img->save($imgUrl);
            if($p->foto!="backEnd/assets/img/default/user-alt.png"){
                unlink($p->foto);
            }
            $p->foto = $imgUrl;   
        }else{
            if($request->flag == "vacio" && $p->foto!="backEnd/assets/img/default/user-alt.png")
            {   
                unlink($p->foto);
                $p->foto ="backEnd/assets/img/default/user-alt.png";                
            }
        }
        $p->nombre = $request->nombre;
        $p->horario_id = $request->horario_id;
        $p->ci = $request->ci;
        $p->cu = $request->cu;
        $p->carrera = $request->carrera;
        $p->email = $request->email;
        $p->telefono = $request->telefono;
        $p->direccion = $request->direccion;
        $p->f_ingreso = $request->f_ingreso;
        $p->estado= $request->estado;

        $p->save();
        return response()->json(['success'=>'Update Practicante']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $practicante = Practicante::where('id',$id)->first();
        // $practicante->estado = 0;
        // $photo = $practicante->foto;
        // if($photo){
        //     unlink($photo);
        //     $practicante->delete();
        // }else{
        //     $practicante->delete();
        // }
        // $practicante->save();
    }
}
