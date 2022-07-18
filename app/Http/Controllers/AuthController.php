<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use App\Models\Tayyorsqlad;
use App\Models\Ishchilar;
use App\Models\Itogop;
use App\Models\Jonatilgan;
use App\Models\Karzinap;
use App\Models\Tavarp;
use App\Models\Userp;

class AuthController extends Controller
{
    public function login()
    {
        $data = Ishchilar::all();
        return view("auth.login", ['data'=>$data]);
    }
  
    public function loginuser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required',
        ]);
        if($validator->passes()){
            $user = Ishchilar::where('login','=',$request['login'])->first();
            if($request->password == $user->password){
                $request->session()->put('IDIE',$user->id);
                return response()->json(["data"=>200]);             
            }else{
                return response()->json(["data"=>404]);
            }
        }else{            
            return response()->json(['data'=>0, 'error'=>$validator->errors()->toArray()]);
        }
    }
     
    public function dashbord()
    {
        $jonatilgan = Jonatilgan::count();
        $foo = Itogop::find(1);
        $clents = Userp::all();
        if(Session::has('IDIE')){
            $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
            return view('sotuv',[
                'brends'=>$brends,
                'itogs'=>$foo,
                'clents'=>$clents,
                'jonatilgan'=>$jonatilgan
            ]);
        }else{
            return redirect('/logaut');
        }
    }
    public function logaut()
    {
        if(Session::has('IDIE')){
            Session::pull('IDIE');
            return redirect('/');
        }else{
            return redirect('/');
        }
    }
}