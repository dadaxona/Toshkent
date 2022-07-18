<?php

namespace App\Providers;

use App\Models\Adress;
use App\Models\Adressp;
use App\Models\Ishchilar;
use App\Models\Arxivp;
use App\Models\Deletkarzinap;
use App\Models\Tayyorsqlad;
use App\Models\Tavarp;
use App\Models\Umumiyp;
use App\Models\Updatetavrp;
use App\Models\Userp;
use App\Models\Itogop;
use App\Models\Jonatilgan;
use App\Models\Karzinap;
use App\Models\Karzina2p;
use App\Models\Karzina3p;
use App\Models\Tavar;
use App\Models\Tavar2;
use App\Models\Tavar2p;
use App\Models\Trvarcktosh;
use App\Models\Trvarkеtosh;
use App\Models\Zakazp;
use App\Models\Zakaz2p;
use App\Providers\KlentServis2;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class KlentServis extends KlentServis2
{
    public function store($request)
    {
        if($request->id){
            return $this->update($request);        
        }else{
            $data = Userp::create([
                'name'=>$request->name,
                'tel'=>$request->tel,
                'firma'=>$request->firma,
                'inn'=>$request->inn,
            ]);
            if($data){
                return response()->json(['code'=>200, 'msg'=>'Мувофакиятли яратилмади','data' => $request], 200);
            }
        }
    }

    public function update($request)
    {
        Userp::find($request->id)->update($request->all());
        $data = Userp::find($request->id);
        return response()->json(['code'=>201, 'msg'=>'Мувофакиятли янгиланди','data' => $data], 201);
    }

    public function delete($id)
    {
        Userp::find($id)->delete($id);
        return response()->json(['msg'=>'Мувофакиятли очирилди']);
    }


    // 2
    public function store2($request)
    {
        foreach ($request->addmore as $value) {
            $data = Tavarp::create($value);
            Tavar::create($value);
        }
        return response()->json(['code'=>200, 'msg'=>'Мувофакиятли яратилмади','data' => $data], 200);
        
    }

    public function store2tip($request)
    {
        foreach ($request->addmore as $value) {
            $data = Tavar2p::create($value);
            Tavar2::create([
                'tavar_id'=>$value["tavarp_id"],
                'name'=>$value["name"],
            ]);
        }
        return response()->json(['code'=>200, 'msg'=>'Мувофакиятли яратилмади','data' => $data], 200);
        
    }
    public function update2($request)
    {
        Tavar2p::find($request->id)->update($request->all());
        Tavar2::find($request->id)->update([
            'tavar_id'=>$request->tavarp_id,
            'name'=>$request->name,
        ]);
        $data = Tavar2p::find($request->id);
        return response()->json(['code'=>200, 'msg'=>'Мувофакиятли янгиланди','data' => $data], 200);
    }

    public function updateer2($request)
    {
        Tavarp::find($request->id)->update($request->all());
        Tavar::find($request->id)->update($request->all());
        $data = Tavarp::find($request->id);
        return response()->json(['code'=>200, 'msg'=>'Мувофакиятли янгиланди','data' => $data], 200);
    }
    
    public function edit3()
    {
        $tayyorsqlad = Tayyorsqlad::all();
        $data = Tavarp::all();
        $datatip = Tavar2p::all();
        $adressp =  DB::table('adresseps')->get();
        $tiklash = Deletkarzinap::all();
        $jonatilgan = Jonatilgan::count();
        $umumiyp = Umumiyp::find(1);
        if(Session::has('IDIE')){
          $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
          return view('tavar2',[
              'brends'=>$brends,
              'ichkitavar'=>$tayyorsqlad,
              'jonatilgan'=>$jonatilgan,
              'data'=>$data,
              'datatip'=>$datatip,
              'tiklash'=>$tiklash,
              'adress'=>$adressp,
              'umumiyp'=>$umumiyp??[]
          ]);
        }else{
            return redirect('/logaut');
        }
    }

    public function store3($request)
    {
        foreach ($request->addmore as $value) {
            $foo = Tayyorsqlad::where('tavarp_id', $value["tavarp_id"])
                            ->where('adress', $value["adress"])
                            ->where('tavar2p_id', $value["tavar2p_id"])
                            ->first();
            if($foo){
                $a = $foo->hajm + $value["hajm"];
                $b = $value["summa"] - $foo->summa;
                $c = $foo->summa + $b / 2;
                $fff = Tavar2p::find($value["tavar2p_id"]);
                Tayyorsqlad::where('tavarp_id', $value["tavarp_id"])
                        ->where('adress', $value["adress"])
                        ->where('tavar2p_id', $value["tavar2p_id"])
                        ->update([
                            'name'=>$fff->name,
                            'raqam' => $value["raqam"],
                            'hajm' => $a, 
                            'summa' => $c,
                            'summa2' => $value["summa2"],
                            'summa3' => $value["summa3"],
                        ]);
                $data = Tayyorsqlad::where('tavarp_id', $value["tavarp_id"])
                        ->where('adress', $value["adress"])
                        ->where('tavar2p_id', $value["tavar2p_id"])
                        ->first();
                // $updates = Updatetavrp::where('tavarp_id', $value["tavarp_id"])
                //         ->where('tayyorsqlad_id', $data->id)
                //         ->where('adress', $value["adress"])
                //         ->where('tavar2p_id', $value["tavar2p_id"])
                //         ->first();
                // if($updates){
                //     Updatetavrp::where('tavarp_id', $value["tavarp_id"])
                //             ->where('tayyorsqlad_id', $data->id)
                //             ->where('adress', $value["adress"])
                //             ->where('tavar2p_id', $value["tavar2p_id"])
                //             ->update([
                //                 'raqam'=>$value["raqam"],
                //                 'hajm'=>$value["hajm"],
                //                 'summa'=>$value["summa"],
                //                 'summa2'=>$value["summa2"],
                //                 'summa3'=>$value["summa3"],
                //             ]);
                // }else{
                //     Updatetavrp::create([
                //         'tavarp_id'=>$value["tavarp_id"],
                //         'tayyorsqlad_id'=>$data->id,
                //         'adress'=>$value["adress"],
                //         'tavar2p_id'=>$value["tavar2p_id"],
                //         'raqam'=>$value["raqam"],
                //         'hajm'=>$value["hajm"],
                //         'summa'=>$value["summa"],
                //         'summa2'=>$value["summa2"],
                //         'summa3'=>$value["summa3"],
                //     ]);
                // }
                Trvarkеtosh::create([
                    'tavarp_id'=>$value["tavarp_id"],
                    'adress'=>$value["adress"],
                    'tavar2p_id'=>$value["tavar2p_id"],
                    'tayyorsqlad_id'=>$data->id,
                    'raqam'=>$value["raqam"],
                    'hajm'=>$value["hajm"],
                    'summa'=>$value["summa"],
                    'summa2'=>$value["summa2"],
                    'summa3'=>$value["summa3"],
                ]);
            }else{
                $fff = Tavar2p::find($value["tavar2p_id"]);
                $data = Tayyorsqlad::create([
                    'tavarp_id'=>$value["tavarp_id"],
                    'adress'=>$value["adress"],
                    'tavar2p_id'=>$value["tavar2p_id"],
                    'name'=>$fff["name"],
                    'raqam'=>$value["raqam"],
                    'hajm'=>$value["hajm"],
                    'summa'=>$value["summa"],
                    'summa2'=>$value["summa2"],
                    'summa3'=>$value["summa3"],
                ]);
                // $updates = Updatetavrp::where('tavarp_id', $value["tavarp_id"])
                //         ->where('tayyorsqlad_id', $data->id)
                //         ->where('adress', $value["adress"])
                //         ->where('tavar2p_id', $value["tavar2p_id"])
                //         ->first();
                // if($updates){
                //     Updatetavrp::where('tavarp_id', $value["tavarp_id"])
                //             ->where('tayyorsqlad_id', $data->id)
                //             ->where('adress', $value["adress"])
                //             ->where('tavar2p_id', $value["tavar2p_id"])
                //             ->update([
                //                 'raqam'=>$value["raqam"],
                //                 'hajm'=>$value["hajm"],
                //                 'summa'=>$value["summa"],
                //                 'summa2'=>$value["summa2"],
                //                 'summa3'=>$value["summa3"],
                //             ]);
                // }else{
                //     Updatetavrp::create([
                //         'tavarp_id'=>$value["tavarp_id"],
                //         'tayyorsqlad_id'=>$data->id,
                //         'adress'=>$value["adress"],
                //         'tavar2p_id'=>$value["tavar2p_id"],
                //         'raqam'=>$value["raqam"],
                //         'hajm'=>$value["hajm"],
                //         'summa'=>$value["summa"],
                //         'summa2'=>$value["summa2"],
                //         'summa3'=>$value["summa3"],
                //     ]);
                // }
                Trvarkеtosh::create([
                    'tavarp_id'=>$value["tavarp_id"],
                    'adress'=>$value["adress"],
                    'tavar2p_id'=>$value["tavar2p_id"],
                    'tayyorsqlad_id'=>$data->id,
                    'raqam'=>$value["raqam"],
                    'hajm'=>$value["hajm"],
                    'summa'=>$value["summa"],
                    'summa2'=>$value["summa2"],
                    'summa3'=>$value["summa3"],
                ]);
            }
        }
        return response()->json(['code'=>200, 'msg'=>'Мувофакиятли яратилмади','data' => $data], 200);
    }

    public function updates($request)
    {
        // $updatetavrp = Updatetavrp::where('tayyorsqlad_id', $request->id)->first();
        // $foo = Tayyorsqlad::find($request->id);
        $fff = Tavar2p::find($request->tavar2p_id);
        // $h1 = $foo->hajm - $updatetavrp->hajm + $request->hajm;
        // $sum2 = $foo->summa2 - $updatetavrp->summa2 + $request->summa2;
        // $sum3 = $foo->summa3 - $updatetavrp->summa3 + $request->summa3;        
        $data = Tayyorsqlad::find($request->id)->update([
            'tavarp_id'=>$request->tavarp_id,
            'adress'=>$request->adress,
            'tavar2p_id'=>$request->tavar2p_id,
            'name'=>$fff->name,
            'raqam'=>$request->raqam,
            'hajm'=>$request->hajm,
            'summa'=>$request->summa,
            'summa2'=>$request->summa2,
            'summa3'=>$request->summa3,
        ]);
        // Updatetavrp::where('tayyorsqlad_id', $request->id)->update([
        //     'tavarp_id'=>$request->tavarp_id,
        //     'tayyorsqlad_id'=>$request->id, 
        //     'adress'=>$request->adress,
        //     'tavar2p_id'=>$request->tavar2p_id,
        //     'raqam'=>$request->raqam,
        //     'hajm'=>$request->hajm, 
        //     'summa'=>$request->summa,
        //     'summa2'=>$request->summa2,
        //     'summa3'=>$request->summa3,
        // ]);
        Trvarkеtosh::where('tayyorsqlad_id', $request->id)->update([
            'tavarp_id'=>$request->tavarp_id,
            'adress'=>$request->adress,
            'tavar2p_id'=>$request->tavar2p_id,
            'tayyorsqlad_id'=>$request->id, 
            'raqam'=>$request->raqam,
            'hajm'=>$request->hajm, 
            'summa'=>$request->summa,
            'summa2'=>$request->summa2,
            'summa3'=>$request->summa3,
        ]);
        return response()->json(['code'=>201, 'msg'=>'Мувофакиятли янгиланди','data' => $data], 201);
    }

    public function delete3($id)
    {
        $data = Tayyorsqlad::find($id);
        $fff = Tavar2p::find($data->tavar2p_id);
        Deletkarzinap::create([
            'tavarp_id'=>$data->tavarp_id,
            'adressp'=>$data->adressp,
            'tavar2p_id'=>$data->tavar2p_id,
            'name'=>$fff->name,
            'raqam'=>$data->raqam,
            'hajm'=>$data->hajm, 
            'summa'=>$data->summa,
            'summa2'=>$data->summa2,
            'summa3'=>$data->summa3,
            'kurs'=>$data->kurs, 
            'kurs2'=>$data->kurs2
        ]);
        Tayyorsqlad::find($id)->delete($id);
        return response()->json(['msg'=>'Мувофакиятли очирилди']);
    }

    public function tiklash($id)
    {
        $data = Deletkarzinap::find($id);
        $a = Tayyorsqlad::create([
            'tavarp_id'=>$data->tavarp_id,
            'adressp'=>$data->adressp,
            'tavar2p_id'=>$data->tavar2p_id,
            'name'=>$data->name,
            'raqam'=>$data->raqam,
            'hajm'=>$data->hajm, 
            'summa'=>$data->summa,
            'summa2'=>$data->summa2,
            'summa3'=>$data->summa3,
            'kurs'=>$data->kurs, 
            'kurs2'=>$data->kurs2
        ]);
        // Updatetavrp::create([
        //     'tavarp_id'=>$data->tavarp_id,
        //     'tayyorsqlad_id'=>$a->id,
        //     'adressp'=>$data->adressp,
        //     'tavar2p_id'=>$data->tavar2p_id,
        //     'raqam'=>$data->raqam,
        //     'hajm'=>$data->hajm, 
        //     'summa'=>$data->summa,
        //     'summa2'=>$data->summa2,
        //     'summa3'=>$data->summa3
        // ]);
        Trvarkеtosh::create([
            'tavarp_id'=>$data->tavarp_id,
            'adress'=>$data->adress,
            'tavar2p_id'=>$data->tavar2p_id,
            'tayyorsqlad_id'=>$a->id,
            'raqam'=>$data->raqam,
            'hajm'=>$data->hajm,
            'summa'=>$data->summa,
            'summa2'=>$data->summa2,
            'summa3'=>$data->summa3,
        ]);
        Deletkarzinap::find($id)->delete($id);
        return response()->json(['msg'=>'Мувофакиятли тикланди']);
    }

    public function deleetemnu($id)
    {
        Deletkarzinap::find($id)->delete($id);
        return response()->json(['msg'=>'Мувофакиятли очирилди']);
    }

    public function store4($request)
    {
        $foo = Tayyorsqlad::find($request->id);
        $h1 = $foo->hajm + $request->hajm;
        $sum1 = $foo->summa + $request->summa;
        $sum2 = $foo->summa2 + $request->summa2;       
        Tayyorsqlad::find($request->id)->update([
            'raqam'=>$request->raqam,
            'hajm'=>$h1,
            'summa'=>$sum1,
            'summa2'=>$sum2
        ]);
        $data = Tayyorsqlad::find($request->id);
        return response()->json(['code'=>201, 'msg'=>'Мувофакиятли янгиланди','data' => $data], 201);
       
    }

    public function pastavka($request)
    {
        foreach ($request->addmore as $value) {
            $data = DB::table('adresseps')->insert($value);
            Adress::create($value);
        }
        return response()->json(['code'=>200, 'msg'=>'Мувофакиятли яратилмади','data' => $data], 200);
        
    }

    public function pastavkaupdate($request)
    {
        unset($request["_token"]);
        DB::table('adresseps')->where('id', $request->id)->update($request->all());
        Adress::find($request->id)->update($request->all());
        $data = DB::table('adresseps')->find($request->id);
        return response()->json(['code'=>201, 'msg'=>'Мувофакиятли янгиланди','data' => $data], 201);
    }

    public function deletew4($id)
    {
        DB::table('adresseps')->where('id' ,$id)->delete($id);
        Adress::find($id)->delete($id);
        return response()->json(['msg'=>'Мувофакиятли очирилди']);
    }

    public function clents()
    {
        $jonatilgan = Jonatilgan::count();
        $userp = Userp::paginate(10);
        if(Session::has('IDIE')){
            $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
            return view('clent',[
                'brends'=>$brends,
                'collection'=>$userp,
                'jonatilgan'=>$jonatilgan,
            ]);
        }else{
            return redirect('/logaut');
        }
    }

    public function sazdat($request)
    {
        $valyuta = Itogop::find(1);
        if($request->radio == "option1"){
            if($valyuta->usd == 0){
                $foo = Tayyorsqlad::find($request->id);
                if($foo->hajm <= 0){
                    return response()->json(['msg'=>'Товар йетарли емас', 'code'=>0]);
                }else{
                    $dat = Karzinap::create([
                        'tavarp_id' => $foo->tavarp_id,
                        'tayyorsqlad_id' => $foo->id,
                        'name' => $foo->name,
                        'raqam' => $foo->raqam,
                        'soni' => 1,
                        'hajm' => $foo->hajm,
                        'summa' => (float)$foo->summa3,
                        'summa2' => (float)$foo->kurs2,
                        'chegirma' => 0,
                        'itog' => (float)$foo->kurs2,
                    ]);
                    $ito = Itogop::find(1);
                    if($ito){
                        $j = (float)$ito->itogo + (float)$foo->kurs2;
                        Itogop::find(1)->update([
                            'itogo'=>(float)$j,
                        ]);
                        $ito2 = Itogop::find(1);
                        return response()->json(['msg'=>'Кошилди', 'data'=>$dat, 'data2'=>$ito2]);
            
                    }else{
                        Itogop::create([
                            'itogo'=>(float)$foo->kurs2,
                        ]);
                        $ito3 = Itogop::find(1);
                        return response()->json(['msg'=>'Кошилди', 'data'=>$dat, 'data2'=>$ito3]);
                    }
                }
            }else{
                $foo = Tayyorsqlad::find($request->id);
                if($foo->hajm <= 0){
                    return response()->json(['msg'=>'Товар йетарли емас', 'code'=>0]);
                }else{
                    $dat = Karzinap::create([
                        'tavarp_id' => $foo->tavarp_id,
                        'tayyorsqlad_id' => $foo->id,
                        'name' => $foo->name,
                        'raqam' => $foo->raqam,
                        'soni' => 1,
                        'hajm' => $foo->hajm,
                        'summa' => (float)$foo->summa3 / (float)$valyuta->kurs,
                        'summa2' => (float)$foo->kurs2 / (float)$valyuta->kurs,
                        'chegirma' => 0,
                        'itog' => (float)$foo->kurs2 / (float)$valyuta->kurs,
                    ]);
                    $ito = Itogop::find(1);
                    if($ito){
                        $j = (float)$ito->itogo + (float)$foo->kurs2 / (float)$valyuta->kurs;
                        Itogop::find(1)->update([
                            'itogo'=>(float)$j,
                        ]);
                        $ito2 = Itogop::find(1);
                        return response()->json(['msg'=>'Кошилди', 'data'=>$dat, 'data2'=>$ito2]);
            
                    }else{
                        Itogop::create([
                            'itogo'=>(float)$foo->kurs2 / (float)$valyuta->kurs,
                        ]);
                        $ito3 = Itogop::find(1);
                        return response()->json(['msg'=>'Кошилди', 'data'=>$dat, 'data2'=>$ito3]);
                    }
                }
            }
        }else{
            if($valyuta->usd == 0){
                $foo = Tayyorsqlad::find($request->id);
                if($foo->hajm <= 0){
                    return response()->json(['msg'=>'Товар йетарли емас', 'code'=>0]);
                }else{
                    $dat = Karzinap::create([
                        'tavarp_id' => $foo->tavarp_id,
                        'tayyorsqlad_id' => $foo->id,
                        'name' => $foo->name,
                        'raqam' => $foo->raqam,
                        'soni' => 1,
                        'hajm' => $foo->hajm,
                        'summa' => (float)$foo->summa2,
                        'summa2' => (float)$foo->kurs,
                        'chegirma' => 0,
                        'itog' => (float)$foo->kurs,
                    ]);
                    $ito = Itogop::find(1);
                    if($ito){
                        $j = (float)$ito->itogo + (float)$foo->kurs;
                        Itogop::find(1)->update([
                            'itogo'=>(float)$j,
                        ]);
                        $ito2 = Itogop::find(1);
                        return response()->json(['msg'=>'Кошилди', 'data'=>$dat, 'data2'=>$ito2]);
            
                    }else{
                        Itogop::create([
                            'itogo'=>(float)$foo->kurs,
                        ]);
                        $ito3 = Itogop::find(1);
                        return response()->json(['msg'=>'Кошилди', 'data'=>$dat, 'data2'=>$ito3]);
                    }
                }
            }else{
                $foo = Tayyorsqlad::find($request->id);
                if($foo->hajm <= 0){
                    return response()->json(['msg'=>'Товар йетарли емас', 'code'=>0]);
                }else{
                    $dat = Karzinap::create([
                        'tavarp_id' => $foo->tavarp_id,
                        'tayyorsqlad_id' => $foo->id,
                        'name' => $foo->name,
                        'raqam' => $foo->raqam,
                        'soni' => 1,
                        'hajm' => $foo->hajm,
                        'summa' => (float)$foo->summa2 / (float)$valyuta->kurs,
                        'summa2' => (float)$foo->kurs / (float)$valyuta->kurs,
                        'chegirma' => 0,
                        'itog' => (float)$foo->kurs / (float)$valyuta->kurs,
                    ]);
                    $ito = Itogop::find(1);
                    if($ito){
                        $j = (float)$ito->itogo + (float)$foo->kurs / (float)$valyuta->kurs;
                        Itogop::find(1)->update([
                            'itogo'=>(float)$j,
                        ]);
                        $ito2 = Itogop::find(1);
                        return response()->json(['msg'=>'Кошилди', 'data'=>$dat, 'data2'=>$ito2]);
            
                    }else{
                        Itogop::create([
                            'itogo'=>(float)$foo->kurs / (float)$valyuta->kurs,
                        ]);
                        $ito3 = Itogop::find(1);
                        return response()->json(['msg'=>'Кошилди', 'data'=>$dat, 'data2'=>$ito3]);
                    }
                }
            }
        }
    }

    public function usdkurd2($request)
    {
        $row = Tayyorsqlad::all();
        foreach ($row as $value) {
            $dat = (float)$value->summa2 * (float)$request->kurs;
            $dat2 = (float)$value->summa3 * (float)$request->kurs;
            Tayyorsqlad::find($value->id)->update([
                'kurs'=>(float)$dat,
                'kurs2'=>(float)$dat2
            ]);
        }
        $a = Itogop::find(1);
        if($a){
            Itogop::find(1)->update([
                'kurs'=>(float)$request->kurs
            ]);
        }else{
            Itogop::create([
                'itogo'=>0,
                'kurs'=>(float)$request->kurs,
                'usd'=>0
            ]);
        }
        $b2 = Itogop::find(1);
        return response()->json(['msg'=>'Киритилди', 'data'=>$b2]);
    }

    public function plus($request)
    {
        $foo1 = Karzinap::find($request->id);
        $row = Tayyorsqlad::find($foo1->tayyorsqlad_id);
        $valyuta = Itogop::find(1);
        $a = $foo1->soni + 1;
        if($a > $row->hajm){
            return response()->json(['msg'=>'Тавар етарли емас', 'error'=>400]);
        }else{
            if($valyuta->usd == 0){
                if($request->radio == "option2"){
                    $itog = $foo1->itog + $row->kurs;
                    $itog2 = $foo1->summa + $row->summa2;
                    Karzinap::find($request->id)->update([
                        'soni'=>$a,
                        'itog'=>$itog,
                        'summa'=>$itog2,
                    ]);
                    $foo3 = Karzinap::find($request->id);
                    $b = Itogop::find(1);
                    $j = $b->itogo + $row->kurs;
                    Itogop::find(1)->update([
                        'itogo'=>$j,
                    ]);
                    $b2 = Itogop::find(1);
                    return response()->json(['data'=>$foo3, 'data2'=>$b2]);
                }else{
                    $itog = $foo1->itog + $row->kurs2;
                    $itog2 = $foo1->summa + $row->summa3;
                    Karzinap::find($request->id)->update([
                        'soni'=>$a,
                        'itog'=>$itog,
                        'summa'=>$itog2,
                    ]);
                    $foo3 = Karzinap::find($request->id);
                    $b = Itogop::find(1);
                    $j = $b->itogo + $row->kurs2;
                    Itogop::find(1)->update([
                        'itogo'=>$j,
                    ]);
                    $b2 = Itogop::find(1);
                    return response()->json(['data'=>$foo3, 'data2'=>$b2]);
                }
            }else{
                if($request->radio == "option2"){
                    $itog = $foo1->itog + $row->kurs / $valyuta->kurs;
                    $itog2 = $foo1->summa + $row->summa2 / $valyuta->kurs;
                    Karzinap::find($request->id)->update([
                        'soni'=>$a,
                        'itog'=>$itog,
                        'summa'=>$itog2,
                    ]);
                    $foo3 = Karzinap::find($request->id);
                    $b = Itogop::find(1);
                    $j = $b->itogo + $row->kurs / $valyuta->kurs;
                    Itogop::find(1)->update([
                        'itogo'=>$j,
                    ]);
                    $b2 = Itogop::find(1);
                    return response()->json(['data'=>$foo3, 'data2'=>$b2]);
                }else{
                    $itog = $foo1->itog + $row->kurs2 / $valyuta->kurs;
                    $itog2 = $foo1->summa + $row->summa3 / $valyuta->kurs;
                    Karzinap::find($request->id)->update([
                        'soni'=>$a,
                        'itog'=>$itog,
                        'summa'=>$itog2,
                    ]);
                    $foo3 = Karzinap::find($request->id);
                    $b = Itogop::find(1);
                    $j = $b->itogo + $row->kurs2 / $valyuta->kurs;
                    Itogop::find(1)->update([
                        'itogo'=>$j,
                    ]);
                    $b2 = Itogop::find(1);
                    return response()->json(['data'=>$foo3, 'data2'=>$b2]);
                }
            }
        }
    }

    public function minus($request)
    {
        $foo1 = Karzinap::find($request->id);
        $row = Tayyorsqlad::find($foo1->tayyorsqlad_id);
        $valyuta = Itogop::find(1);
        $a = $foo1->soni - 1;
        if($a < 1){
            return $this->delminus($request, $row, $valyuta);
        }else{
            if($valyuta->usd == 0){
                if($request->radio == "option2"){
                    $itog = $foo1->itog - $row->kurs;
                    $itog2 = $foo1->summa - $row->summa2;
                    Karzinap::find($request->id)->update([
                        'soni'=>$a,
                        'itog'=>$itog,
                        'summa'=>$itog2,
                    ]);
                    $foo3 = Karzinap::find($request->id);
                    $b = Itogop::find(1);
                    $j = $b->itogo - $row->kurs;
                    Itogop::find(1)->update([
                        'itogo'=>$j,
                    ]);
                    $b2 = Itogop::find(1);
                    return response()->json(['data'=>$foo3, 'data2'=>$b2]);
                }else{
                    $itog = $foo1->itog - $row->kurs2;
                    $itog2 = $foo1->summa - $row->summa3;
                    Karzinap::find($request->id)->update([
                        'soni'=>$a,
                        'itog'=>$itog,
                        'summa'=>$itog2,
                    ]);
                    $foo3 = Karzinap::find($request->id);
                    $b = Itogop::find(1);
                    $j = $b->itogo - $row->kurs2;
                    Itogop::find(1)->update([
                        'itogo'=>$j,
                    ]);
                    $b2 = Itogop::find(1);
                    return response()->json(['data'=>$foo3, 'data2'=>$b2]);
                }
            }else{
                if($request->radio == "option2"){
                    $itog = $foo1->itog - $row->kurs / $valyuta->kurs;
                    $itog2 = $foo1->summa - $row->summa2 / $valyuta->kurs;
                    Karzinap::find($request->id)->update([
                        'soni'=>$a,
                        'itog'=>$itog,
                        'summa'=>$itog2,
                    ]);
                    $foo3 = Karzinap::find($request->id);
                    $b = Itogop::find(1);
                    $j = $b->itogo - $row->kurs / $valyuta->kurs;
                    Itogop::find(1)->update([
                        'itogo'=>$j,
                    ]);
                    $b2 = Itogop::find(1);
                    return response()->json(['data'=>$foo3, 'data2'=>$b2]);
                }else{
                    $itog = $foo1->itog - $row->kurs2 / $valyuta->kurs;
                    $itog2 = $foo1->summa - $row->summa3 / $valyuta->kurs;
                    Karzinap::find($request->id)->update([
                        'soni'=>$a,
                        'itog'=>$itog,
                        'summa'=>$itog2,
                    ]);
                    $foo3 = Karzinap::find($request->id);
                    $b = Itogop::find(1);
                    $j = $b->itogo - $row->kurs2 / $valyuta->kurs;
                    Itogop::find(1)->update([
                        'itogo'=>$j,
                    ]);
                    $b2 = Itogop::find(1);
                    return response()->json(['data'=>$foo3, 'data2'=>$b2]);
                }
            }
        }
    }

    public function delminus($request, $row, $valyuta)
    {
        $b = Itogop::find(1);
        $j = $b->itogo - $row->kurs / $valyuta->kurs;
        Itogop::find(1)->update([
            'itogo'=>$j
        ]);
        $b2 = Itogop::find(1);
        $foo3 = Karzinap::find($request->id);
        Karzinap::find($request->id)->delete($request->id);
        $iff = Karzinap::count();
        if ($iff == 0) {
            Itogop::find(1)->update([
                'itogo'=>0,
            ]);
            $b3 = Itogop::find(1);
            return response()->json(['msg'=>'Тавар олиб ташланди', 'data'=>$foo3, 'data2'=>$b3, 'error'=>400]);
        }else{
            return response()->json(['msg'=>'Тавар олиб ташланди', 'data'=>$foo3, 'data2'=>$b2, 'error'=>400]);
        }
    }

    public function udalit($request)
    {
        $foo1 = Karzinap::find($request->id);
        $b = Itogop::find(1);
        $j = $b->itogo - $foo1->itog;
        Itogop::find(1)->update([
            'itogo'=>$j,
        ]);
        $b2 = Itogop::find(1);
        Karzinap::find($request->id)->delete($request->id);
        $iff = Karzinap::count();
        if ($iff == 0) {
            Itogop::find(1)->update([
                'itogo'=>0,
            ]);
            $b3 = Itogop::find(1);
            return response()->json(['msg'=>'Очирилди', 'data'=>$foo1, 'data2'=>$b3]);
        }else{
            return response()->json(['msg'=>'Очирилди', 'data'=>$foo1, 'data2'=>$b2]);
        }
    }

    public function yangilash($request)
    {
        $foo1 = Karzinap::find($request->id);
        $row = Tayyorsqlad::find($foo1->tayyorsqlad_id);
        if($request->soni > $row->hajm){
            return response()->json(['msg'=>'Тавар етарли емас', 'code'=>0]);
        }else{
            $b = Itogop::find(1);
            $pool = $b->itogo - $foo1->itog;
            $poo2 = $pool + $request->summ;
            Itogop::find(1)->update([
                'itogo'=>$poo2
            ]);
            Karzinap::find($request->id)->update([
                'soni'=>$request->soni,
                'summa2'=>$request->summo,
                'chegirma'=>$request->cheg,
                'itog'=>$request->summ,
            ]);
            $foo3 = Karzinap::find($request->id);
            $b2 = Itogop::find(1);
            return response()->json(['msg'=>'Янгиланди', 'data'=>$foo3, 'data2'=>$b2]);
        }
    }

    public function tugle($request)
    {
        unset($request["_tokin"]);
        $row = Karzinap::all();
        $b23 = Itogop::find(1);
        if($b23->usd == 0){
            foreach ($row as $value) {
                $dat = $value->summa2 / $b23->kurs;
                $dat2 = $value->itog / $b23->kurs;
                Karzinap::find($value->id)->update([
                    'summa2'=>$dat,
                    'itog'=>$dat2
                ]);
            }
            Itogop::find(1)->update([
                'itogo' => $b23->itogo / $b23->kurs,
                'usd' => 1,
            ]);
            $b2 = Itogop::find(1);
            return response()->json(['msg'=>'Киритилди', 'data'=>$b2]);
        }else{
            return $this->tuglesom($b23);
        }
    }

    public function tuglesom($b23)
    {
        $row = Karzinap::all();
        foreach ($row as $value) {
            $dat = $value->summa2 * $b23->kurs;
            $dat2 = $value->itog * $b23->kurs;
            Karzinap::find($value->id)->update([
                'summa2'=>$dat,
                'itog'=>$dat2
            ]);
        }
        Itogop::find(1)->update([
            'itogo' => $b23->itogo * $b23->kurs,
            'usd' => 0
        ]);
        $b2 = Itogop::find(1);
        return response()->json(['msg'=>'Киритилди', 'data'=>$b2]);        
    }

    public function oplata($request)
    {
        $usd = Itogop::find(1);
        if ($usd->usd == 1) {
            if($request->id){
                $variable = Karzinap::all();
                $arxivp = Arxivp::create([
                    'userp_id'=>$request->id,
                    'itogs'=>$request->itogs,
                    'naqt'=>$request->naqt,
                    'plastik'=>$request->plastik,
                    'bank'=>$request->bank,
                    'karzs'=>$request->karzs,
                ]);
                foreach ($variable as $value) {
                    Karzina2p::create([
                        'userp_id'=> $request->id,
                        'tavarp_id'=> $value->tavarp_id,
                        'tayyorsqlad_id'=> $value->tayyorsqlad_id,
                        'clentra' => $arxivp->clentra,
                        'name'=> $value->name, 
                        'soni'=> $value->soni,  
                        'hajm'=> $value->hajm, 
                        'summa'=> $value->summa, 
                        'summa2'=> $value->summa2, 
                        'chegirma'=> $value->chegirma, 
                        'itog'=> $value->itog,
                    ]);
                    $foo = Tayyorsqlad::find($value->tayyorsqlad_id);
                    $foo2 = $foo->hajm - $value->soni;
                    Tayyorsqlad::find($value->tayyorsqlad_id)->update([
                        'hajm'=>$foo2
                    ]);
                    Trvarcktosh::create([
                         'tavarp_id'=>$foo->tavarp_id,
                        'adress'=>$foo->adress,
                        'tavar2p_id'=>$foo->tavar2p_id,
                        'tayyorsqlad_id'=>$foo->id, 
                        'raqam'=>$foo->raqam,
                        'hajm'=>$value->soni, 
                        'summa'=>$value->summa,
                        'summa2'=>$value->summa2,
                        'summa3'=>$value->itog,
                    ]);
                }
                Itogop::find(1)->update([
                    'itogo'=>0,
                ]);
                $b2 = Itogop::find(1);
                Karzinap::where('id',">",0)->delete();
                return response()->json(['data'=>$b2]);
            }else{
                $variable = Karzinap::all();
                foreach ($variable as $value) {
                    Karzina3p::create([
                        'tavarp_id'=> $value->tavarp_id,
                        'tayyorsqlad_id'=> $value->tayyorsqlad_id,
                        'name'=> $value->name, 
                        'soni'=> $value->soni,  
                        'hajm'=> $value->hajm, 
                        'summa'=> $value->summa, 
                        'summa2'=> $value->summa2, 
                        'chegirma'=> $value->chegirma, 
                        'itog'=> $value->itog,
                    ]);
                    $foo = Tayyorsqlad::find($value->tayyorsqlad_id);
                    $foo2 = $foo->hajm - $value->soni;
                    Tayyorsqlad::find($value->tayyorsqlad_id)->update([
                        'hajm'=>$foo2
                    ]);
                    Trvarcktosh::create([
                         'tavarp_id'=>$foo->tavarp_id,
                        'adress'=>$foo->adress,
                        'tavar2p_id'=>$foo->tavar2p_id,
                        'tayyorsqlad_id'=>$foo->id, 
                        'raqam'=>$foo->raqam,
                        'hajm'=>$value->soni, 
                        'summa'=>$value->summa,
                        'summa2'=>$value->summa2,
                        'summa3'=>$value->itog,
                    ]);
                }
                Itogop::find(1)->update([
                    'itogo'=>0,
                ]);
                $b2 = Itogop::find(1);
                Karzinap::where('id',">",0)->delete();
                return response()->json(['data'=>$b2]);
            }
        }else{
            if($request->id){
                $variable = Karzinap::all();
                $arxivp = Arxivp::create([
                    'userp_id'=>$request->id,
                    'itogs'=>$request->itogs / $usd->kurs,
                    'naqt'=>$request->naqt / $usd->kurs,
                    'plastik'=>$request->plastik / $usd->kurs,
                    'bank'=>$request->bank / $usd->kurs,
                    'karzs'=>$request->karzs / $usd->kurs,
                ]);
                foreach ($variable as $value) {
                    Karzina2p::create([
                        'userp_id'=> $request->id,
                        'tavarp_id'=> $value->tavarp_id,
                        'tayyorsqlad_id'=> $value->tayyorsqlad_id,
                        'clentra' => $arxivp->clentra,
                        'name'=> $value->name, 
                        'soni'=> $value->soni,  
                        'hajm'=> $value->hajm, 
                        'summa'=> $value->summa / $usd->kurs, 
                        'summa2'=> $value->summa2 / $usd->kurs, 
                        'chegirma'=> $value->chegirma, 
                        'itog'=> $value->itog / $usd->kurs,
                    ]);
                    $foo = Tayyorsqlad::find($value->tayyorsqlad_id);
                    $foo2 = $foo->hajm - $value->soni;
                    Tayyorsqlad::find($value->tayyorsqlad_id)->update([
                        'hajm'=>$foo2
                    ]);
                    Trvarcktosh::create([
                         'tavarp_id'=>$foo->tavarp_id,
                        'adress'=>$foo->adress,
                        'tavar2p_id'=>$foo->tavar2p_id,
                        'tayyorsqlad_id'=>$foo->id, 
                        'raqam'=>$foo->raqam,
                        'hajm'=>$value->soni, 
                        'summa'=>$value->summa,
                        'summa2'=>$value->summa2,
                        'summa3'=>$value->itog,
                    ]);
                }
                Itogop::find(1)->update([
                    'itogo'=>0,
                ]);
                $b2 = Itogop::find(1);
                Karzinap::where('id',">",0)->delete();
                return response()->json(['data'=>$b2]);
            }else{
                $variable = Karzinap::all();
                foreach ($variable as $value) {
                    Karzina3p::create([
                        'tavarp_id'=> $value->tavarp_id,
                        'tayyorsqlad_id'=> $value->tayyorsqlad_id,
                        'name'=> $value->name,
                        'soni'=> $value->soni,
                        'hajm'=> $value->hajm,
                        'summa'=> $value->summa / $usd->kurs,
                        'summa2'=> $value->summa2 / $usd->kurs,
                        'chegirma'=> $value->chegirma,
                        'itog'=> $value->itog / $usd->kurs,
                    ]);
                    $foo = Tayyorsqlad::find($value->tayyorsqlad_id);
                    $foo2 = $foo->hajm - $value->soni;
                    Tayyorsqlad::find($value->tayyorsqlad_id)->update([
                        'hajm'=>$foo2
                    ]);
                    Trvarcktosh::create([
                         'tavarp_id'=>$foo->tavarp_id,
                        'adress'=>$foo->adress,
                        'tavar2p_id'=>$foo->tavar2p_id,
                        'tayyorsqlad_id'=>$foo->id, 
                        'raqam'=>$foo->raqam,
                        'hajm'=>$value->soni, 
                        'summa'=>$value->summa,
                        'summa2'=>$value->summa2,
                        'summa3'=>$value->itog,
                    ]);
                }
                Itogop::find(1)->update([
                    'itogo'=>0,
                ]);
                $b2 = Itogop::find(1);
                Karzinap::where('id',">",0)->delete();
                return response()->json(['data'=>$b2]);
            }
        }
    }

    public function zakazayt($request)
    {
        $usd = Itogop::find(1);
        if ($usd->usd == 1) {
            if($request->id){
                $variable = Karzinap::all();
                Arxivp::create([
                    'userp_id'=>$request->id,
                    'itogs'=>$request->itogs,
                    'naqt'=>$request->naqt,
                    'plastik'=>$request->plastik,
                    'bank'=>$request->bank,
                    'karzs'=>$request->karzs,
                ]);
                foreach ($variable as $value) {
                    Karzina2p::create([
                        'userp_id'=> $request->id,
                        'tavarp_id'=> $value->tavarp_id,
                        'tayyorsqlad_id'=> $value->tayyorsqlad_id,
                        'name'=> $value->name, 
                        'soni'=> $value->soni,  
                        'hajm'=> $value->hajm, 
                        'summa'=> $value->summa, 
                        'summa2'=> $value->summa2, 
                        'chegirma'=> $value->chegirma,
                        'itog'=> $value->itog,
                        'zakazp'=> $request->checks,
                    ]);
                }
                Itogop::find(1)->update([
                    'itogo'=>0,
                ]);
                $b2 = Itogop::find(1);
                Karzinap::where('id',">",0)->delete();
                return response()->json(['data'=>$b2]);
            }else{
                $variable = Karzinap::all();
                $fooo = Zakazp::create([
                    'malumot'=>$request->malumot,
                    'itogs'=>$request->itogs,
                    'naqt'=>$request->naqt,
                    'plastik'=>$request->plastik,
                    'bank'=>$request->bank,
                    'karzs'=>$request->karzs,
                ]);
                foreach ($variable as $value) {
                    Zakaz2p::create([
                        'zakazp_id'=> $fooo->id,
                        'tavarp_id'=> $value->tavarp_id,
                        'tayyorsqlad_id'=> $value->tayyorsqlad_id,
                        'name'=> $value->name,
                        'soni'=> $value->soni,
                        'hajm'=> $value->hajm,
                        'summa'=> $value->summa, 
                        'summa2'=> $value->summa2,
                        'chegirma'=> $value->chegirma,
                        'itog'=> $value->itog,
                    ]);
                }
                Itogop::find(1)->update([
                    'itogo'=>0,
                ]);
                $b2 = Itogop::find(1);
                Karzinap::where('id',">",0)->delete();
                return response()->json(['data'=>$b2]);
            }
        }else{
            if($request->id){
                $variable = Karzinap::all();          
                $fooo = Arxivp::create([
                    'userp_id'=>$request->id,
                    'itogs'=>$request->itogs / $usd->kurs,
                    'naqt'=>$request->naqt / $usd->kurs,
                    'plastik'=>$request->plastik / $usd->kurs,
                    'bank'=>$request->bank / $usd->kurs,
                    'karzs'=>$request->karzs / $usd->kurs,
                ]);
                foreach ($variable as $value) {
                    Karzina2p::create([
                        'userp_id'=> $request->id,
                        'tavarp_id'=> $value->tavarp_id,
                        'tayyorsqlad_id'=> $value->tayyorsqlad_id,
                        'name'=> $value->name,
                        'soni'=> $value->soni,  
                        'hajm'=> $value->hajm, 
                        'summa'=> $value->summa / $usd->kurs, 
                        'summa2'=> $value->summa2 / $usd->kurs, 
                        'chegirma'=> $value->chegirma,
                        'itog'=> $value->itog / $usd->kurs,
                        'zakazp'=> $request->checks,
                    ]);
                }
                Itogop::find(1)->update([
                    'itogo'=>0,
                ]);
                $b2 = Itogop::find(1);
                Karzinap::where('id',">",0)->delete();
                return response()->json(['data'=>$b2]);
            }else{
                $variable = Karzinap::all();
                $fooo = Zakazp::create([
                    'malumot'=>$request->malumot,
                    'itogs'=>$request->itogs / $usd->kurs,
                    'naqt'=>$request->naqt / $usd->kurs,
                    'plastik'=>$request->plastik / $usd->kurs,
                    'bank'=>$request->bank / $usd->kurs,
                    'karzs'=>$request->karzs / $usd->kurs,
                ]);
                foreach ($variable as $value) {
                    Zakaz2p::create([
                        'zakazp_id'=> $fooo->id,
                        'tavarp_id'=> $value->tavarp_id,
                        'tayyorsqlad_id'=> $value->tayyorsqlad_id,
                        'name'=> $value->name, 
                        'soni'=> $value->soni,  
                        'hajm'=> $value->hajm, 
                        'summa'=> $value->summa / $usd->kurs, 
                        'summa2'=> $value->summa2 / $usd->kurs, 
                        'chegirma'=> $value->chegirma, 
                        'itog'=> $value->itog / $usd->kurs,
                    ]);
                }
                Itogop::find(1)->update([
                    'itogo'=>0,
                ]);
                $b2 = Itogop::find(1);
                Karzinap::where('id',">",0)->delete();
                return response()->json(['data'=>$b2]);
            }
        }        
    }
}