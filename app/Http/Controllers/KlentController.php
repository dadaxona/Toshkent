<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\KlentServis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\KlentController2;
use Carbon\Carbon;
use App\Models\Tavarp;
use App\Models\Userp;
use App\Models\Admin;
use App\Models\Adressp;
use App\Models\Tayyorsqlad;
use App\Models\Itogop;
use App\Models\Karzinap;
use App\Models\Updatetavrp;
use App\Models\Sqladpoytaxtp;
use App\Models\Tavar2p;
use App\Models\Ishchilar;
use App\Models\Jonatilgan;
use App\Models\Tavar;
use App\Models\Tavar2;

class KlentController extends KlentController2
{
    public function tavar_live(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $data = DB::table('tavarps')
            ->where('name', 'like', '%'.$query.'%')
            ->orderBy('id', 'DESC')
            ->get();
        }
        else
        {
        $data = DB::table('tavarps')
            ->orderBy('id', 'DESC')
            ->get();
        }
        $total_row = $data->count();
        if($total_row > 0)
        {
            foreach($data as $row)
            {
                $output .= '
                <tr style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->name.'</td>
                    <td class="ui-widget-content">
                        <a href="javascript:void(0)" onclick="editPost2('.$row->id.')" style="color: green">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                            </svg>
                        </a>             
                        <a href="javascript:void(0)" onclick="deletePost2('.$row->id.')" class="mx-3" style="color: red">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                ';
            }
        }
        else
        {
        $output = '
            <tr>
                <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';
        }
        $data = array(
            'table_data'  => $output,
        );

        echo json_encode($data);
        }
    }

    public function tavar2_live(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $data =Tavar2p::where('name', 'like', '%'.$query.'%')->orderBy('id', 'DESC')->get();
        }
        else
        {
        $data = Tavar2p::orderBy('id', 'DESC')->get();
        }
        $total_row = $data->count();
        if($total_row > 0)
        {
            foreach($data as $row)
            {
                $output .= '
                <tr style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                    <td class="ui-widget-content">'.$row->name.'</td>
                    <td class="ui-widget-content">
                        <a href="javascript:void(0)" onclick="editPost2('.$row->id.')" style="color: green">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                            </svg>
                        </a>             
                        <a href="javascript:void(0)" onclick="deletePost2('.$row->id.')" class="mx-3" style="color: red">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                ';
            }
        }
        else
        {
        $output = '
            <tr>
                <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';
        }
        $data = array(
            'table_data'  => $output,
        );

        echo json_encode($data);
        }
    }

    public function live_adress(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $data = DB::table('adresseps')
            ->where('adress', 'like', '%'.$query.'%')
            ->orderBy('id', 'DESC')
            ->get();
            
        }
        else
        {
        $data = DB::table('adresseps')
            ->orderBy('id', 'DESC')
            ->get();
        }
        $total_row = $data->count();
        if($total_row > 0)
        {
            foreach($data as $row)
            {
                $output .= '
                <tr id="row_'.$row->id.'" style="border-bottom: 1px solid;">
                <td class="ui-widget-content">'. $row->adress.'</td>
                <td class="ui-widget-content">
                  <a href="javascript:void(0)" onclick="editPosts2('.$row->id .')" style="color: green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                      <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                    </svg>
                  </a>                            
                  <a href="javascript:void(0)" onclick="deletePost2('.$row->id.')" class="mx-3" style="color: red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                      <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                    </svg>
                  </a>
                </td>
              </tr>
              ';
            }
        }
        else
        {
        $output = '
            <tr>
                <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';
        }
        $data = array(
            'table_data'  => $output,
            'total_data'  => $total_row
        );

        echo json_encode($data);
        }
    }

    public function live_clent(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $data = DB::table('userps')
            ->where('adress', 'like', '%'.$query.'%')
            ->orderBy('id', 'DESC')
            ->get();
            
        }
        else
        {
        $data = DB::table('userps')
            ->orderBy('id', 'DESC')
            ->get();
        }
        $total_row = $data->count();
        if($total_row > 0)
        {
            foreach($data as $row)
            {
                $output .= '
                <tr id="row_'.$row->id.'" style="border-bottom: 1px solid;">
                <td class="ui-widget-content">'.$row->name.'</td>
                <td class="ui-widget-content">'.$row->tel.'</td>
                <td class="ui-widget-content">'.$row->firma.'</td>
                <td class="ui-widget-content">'.$row->inn.'</td>
            
                <td class="ui-widget-content">
                  <a href="javascript:void(0)" onclick="editPost('.$row->id.')" style="color: green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                      <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                    </svg>
                  </a>                            
                  <a href="javascript:void(0)" onclick="deletePost('.$row->id.')" class="mx-3" style="color: red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                      <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                    </svg>
                  </a>
                </td>
              </tr>
              ';
            }
        }
        else
        {
        $output = '
            <tr>
                <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';
        }
        $data = array(
            'table_data'  => $output,
            'total_data'  => $total_row
        );

        echo json_encode($data);
        }
    }

    public function index()
    {
        $jonatilgan = Jonatilgan::count();
        if(Session::has('IDIE')){
            $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
          return view('tavar',[
              'brends'=>$brends,
              'jonatilgan'=>$jonatilgan
          ]);
        }else{
            return redirect('/logaut');
        }
    }
    
    public function indextip()
    {
        $data = Tavarp::all();
        $jonatilgan = Jonatilgan::count();
        if(Session::has('IDIE')){
            $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
          return view('tavartip',[
              'brends'=>$brends,
              'jonatilgan'=>$jonatilgan,
              'tovar'=>$data
          ]);
        }else{
            return redirect('/logaut');
        }
    }

    public function store(Request $request, KlentServis $model)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'tel' => 'required',
            'firma' => 'required',
            'inn' => 'required',
        ]);
        if($validator->passes()){
            return $model->store($request);
        }else{            
            return response()->json(['code'=>0, 'msg'=>'Малумотларни толдирилмаган', 'error'=>$validator->errors()->toArray()]);
        }
    }

    public function show($id)
    {
        $post = Userp::find($id);    
        return response()->json($post);
    }


    public function destroy($id, KlentServis $model)
    {
        return $model->delete($id);
    }

    public function store2(Request $request, KlentServis $model)
    {
        $validator = Validator::make($request->all(), [
            'addmore.*.name' => 'required',
        ]);
        if($validator->passes()){
            return $model->store2($request);
        }else{            
            return response()->json(['code'=>0, 'msg'=>'Малумотларни толдирилмаган', 'error'=>$validator->errors()->toArray()]);
        }
    }

    public function store2tip(Request $request, KlentServis $model)
    {
        $validator = Validator::make($request->all(), [
            'addmore.*.tavarp_id' => 'required',
            'addmore.*.name' => 'required',
        ]);
        if($validator->passes()){
            return $model->store2tip($request);
        }else{            
            return response()->json(['code'=>0, 'msg'=>'Малумотларни толдирилмаган', 'error'=>$validator->errors()->toArray()]);
        }
    }

    public function shower2($id)
    {
        $post = Tavarp::find($id);    
        return response()->json($post);
    }
    public function show2($id)
    {
        $post = Tavar2p::find($id);    
        return response()->json($post);
    }

    public function edit3(KlentServis $model)
    {
        return $model->edit3();
    }
    
    public function update2(Request $request, KlentServis $model)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->passes()){
            return $model->update2($request);
        }else{            
            return response()->json(['code'=>0, 'msg'=>'Малумот киритилмади', 'error'=>$validator->errors()->toArray()]);
        }
    }
    
    public function updateer2(Request $request, KlentServis $model)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validator->passes()){
            return $model->updateer2($request);
        }else{            
            return response()->json(['code'=>0, 'msg'=>'Малумот киритилмади', 'error'=>$validator->errors()->toArray()]);
        }
    }
    public function deleteer2($id)
    {
        Tavarp::find($id)->delete($id);
        Tavar::find($id)->delete($id);
        return response()->json(['msg'=>'Мувофакиятли очирилди']);
    }
    public function delete2($id)
    {
        Tavar2p::find($id)->delete($id);
        Tavar2::find($id)->delete($id);
        return response()->json(['msg'=>'Мувофакиятли очирилди']);
    }
    public function store3(Request $request, KlentServis $model)
    {
        $validator = Validator::make($request->all(), [
            'addmore.*.tavarp_id' => 'required',
            'addmore.*.adress' => 'nullable',
            'addmore.*.tavar2p_id' => 'required',
            'addmore.*.raqam' => 'nullable',
            'addmore.*.hajm' => 'required',
            'addmore.*.summa' => 'required|numeric',
            'addmore.*.summa2' => 'required|numeric',
            'addmore.*.summa3' => 'required|numeric',
        ]);
        if($validator->passes()){
            return $model->store3($request);
        }else{            
            return response()->json(['code'=>0, 'msg'=>'Малумотларни толдирилмаган', 'error'=>$validator->errors()->toArray()]);
        }
    }

    public function updates(Request $request, KlentServis $model)
    {
        $validator = Validator::make($request->all(), [
            'tavarp_id' => 'required',
            'adressp' => 'nullable',
            'tavar2p_id' => 'required',
            'raqam' => 'nullable',
            'hajm' => 'required',
            'summa' => 'required|numeric',
            'summa2' => 'required|numeric',
            'summa3' => 'required|numeric',
        ]);
        if($validator->passes()){
            return $model->updates($request);
        }else{            
            return response()->json(['code'=>0, 'msg'=>'Малумотларни толдирилмаган', 'error'=>$validator->errors()->toArray()]);
        }
    }

    public function edit4(Request $request)
    {
        $post = Tayyorsqlad::find($request->id);    
        return response()->json($post);
    }

    public function delete3($id, KlentServis $model)
    {
        return $model->delete3($id);
    }

    public function tiklash($id, KlentServis $model)
    {
        return $model->tiklash($id);
    }

    public function deleetemnu($id, KlentServis $model)
    {
        return $model->deleetemnu($id);
    }

    public function edit5(Request $request)
    {
        $post = Tayyorsqlad::find($request->id);    
        return response()->json($post);
    }

    public function store4(Request $request, KlentServis $model)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'raqam' => 'nullable',
            'hajm' => 'required',
            'summa' => 'required',
            'summa2' => 'required'
        ]);
        if($validator->passes()){
            return $model->store4($request);
        }else{            
            return response()->json(['code'=>0, 'msg'=>'Малумотларни толдирилмаган', 'error'=>$validator->errors()->toArray()]);
        }
    }

    public function adress()
    {
        $tavar = Tavarp::paginate(10);
        $jonatilgan = Jonatilgan::count();
        if(Session::has('IDIE')){
            $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
          return view('adress',[
              'brends'=>$brends,
              'jonatilgan'=>$jonatilgan,
              'tavar'=>$tavar,
          ]);
        }else{
            return redirect('/logaut');
        }
    }

    public function ombor()
    {
        $tavar = Tavarp::paginate(10);
        $jonatilgan = Jonatilgan::count();
        if(Session::has('IDIE')){
            $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
          return view('ombor',[
              'brends'=>$brends,
              'jonatilgan'=>$jonatilgan,
              'tavar'=>$tavar,
          ]);
        }else{
            return redirect('/logaut');
        }
    }

    public function index2()
    {
        // $adress = Adressp::paginate(10);
        $jonatilgan = Jonatilgan::count();
        if(Session::has('IDIE')){
            $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
          return view('adress2',[
              'brends'=>$brends,
              'jonatilgan'=>$jonatilgan
            //   'adress'=>$adress??[],
          ]);
        }else{
            return redirect('/logaut');
        }
    }

    public function pastavka(Request $request, KlentServis $model)
    {
        $validator = Validator::make($request->all(), [
            'addmore.*.adress' => 'required',
        ]);
        if($validator->passes()){
            return $model->pastavka($request);
        }else{            
            return response()->json(['code'=>0, 'msg'=>'Малумотларни толдирилмаган', 'error'=>$validator->errors()->toArray()]);
        }
    }

    public function show3($id)
    {
        $post = DB::table('adresseps')->find($id);
        return response()->json($post);
    }

    public function pastavkaupdate(Request $request, KlentServis $model)
    {
        return $model->pastavkaupdate($request);
    }

    public function delete4($id, KlentServis $model)
    {
        return $model->deletew4($id);
    }

    public function clents(KlentServis $model)
    {
        return $model->clents();
    }

    public function sazdat(Request $request, KlentServis $model)
    {
        return $model->sazdat($request);
    }

    public function belgila(Request $request)
    {
        $post = Karzinap::find($request->id);    
        return response()->json($post);
    }

    public function belgi2(Request $request)
    {
        $post = Karzinap::find($request->id);    
        return response()->json($post);
    }

    public function kursm()
    {
        $post = Itogop::find(1);    
        return response()->json($post);
    }

    public function usdkurd2(Request $request, KlentServis $model)
    {
        return $model->usdkurd2($request);
    }

    public function sotuv(Request $request)
    {
        if($request->ajax())
        {
         $output = '';
         $query = $request->get('query');
         if($query != '')
         {
          $data = DB::table('karzinaps')
            ->where('name', 'like', '%'.$query.'%')
            ->orderBy('id', 'DESC')
            ->get();
         }
         else
         {
          $data = DB::table('karzinaps')
            ->orderBy('id', 'DESC')
            ->get();
         }
         $total_row = $data->count();
         if($total_row > 0)
         {
          foreach($data as $row)
          {
           $output .= '
           <tr onclick="belgilash('.$row->id.')" style="border-bottom: 1px solid;">  
            <td class="ui-widget-content">'.$row->name.'</td>
            <td class="ui-widget-content">'.number_format($row->summa2, 3).'</td>
            <td class="ui-widget-content">'.$row->soni.'</td>
            <td class="ui-widget-content">'.$row->chegirma.'</td>
            <td class="ui-widget-content">'.number_format($row->itog, 3).'</td>
            <td class="ui-widget-content">'.$row->hajm.'</td>
           </tr>
           ';
          }
         }
         $data = array(
          'table_data'  => $output,
          'total_data'  => $total_row
         );   
         echo json_encode($data);
        }
    }

    function live_search(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $data = Tayyorsqlad::where('name', 'like', '%'.$query.'%')->orderBy('id', 'DESC')->get();            
        }
        else
        {
        $data = Tayyorsqlad::orderBy('id', 'DESC')->get();
        }
        $total_row = $data->count();
        if($total_row > 0)
        {
            foreach($data as $row)
            {
                $output .= '
                <tr ondblclick="plus('.$row->id.')" style="border-bottom: 1px solid;" id="asdsad">
                <td class="ui-widget-content">'.$row->name.'</td>
                <td class="ui-widget-content">'.$row->hajm.'</td>
                <td class="ui-widget-content">'.$row->summa3.'</td>
                </tr>
                ';
            }
        }
        else
        {
        $output = '
        <tr>
            <td align="center" colspan="5">No Data Found</td>
        </tr>
        ';
        }
        $data = array(
        'table_data'  => $output,
        'total_data'  => $total_row
        );

        echo json_encode($data);
        }
    }

    function sqladiskizapas(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $data = Tayyorsqlad::where('name', 'like', '%'.$query.'%')->orderBy('id', 'DESC')->get();            
        }
        else
        {
        $data = Tayyorsqlad::orderBy('id', 'DESC')->get();
        }
        $total_row = $data->count();
        if($total_row > 0)
        {
            foreach($data as $row)
            {
                $output .= '
                <tr data-id="'.$row->id.'" id="data" style="border-bottom: 1px solid;">
                <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                <td class="ui-widget-content">'.$row->name.'</td>
                <td class="ui-widget-content">'.$row->hajm.'</td>
                <td class="ui-widget-content">'.$row->summa.'</td>
                <td class="ui-widget-content">'.$row->summa2.'</td>
                <td class="ui-widget-content">'.$row->summa3.'</td>
                </tr>
                ';
            }
        }
        else
        {
        $output = '
        <tr>
            <td align="center" colspan="5">No Data Found</td>
        </tr>
        ';
        }
        $data = array(
            'table_data'  => $output,
        );

        echo json_encode($data);
        }
    }
    
    function sqladiskizapas2(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $data = Sqladpoytaxtp::where('name', 'like', '%'.$query.'%')->orderBy('id', 'DESC')->get();            
        }
        else
        {
        $data = Sqladpoytaxtp::orderBy('id', 'DESC')->get();
        }
        $total_row = $data->count();
        if($total_row > 0)
        {
            foreach($data as $row)
            {
                $output .= '
                <tr data-id="'.$row->id.'" id="asdsad" style="border-bottom: 1px solid;">
                <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                <td class="ui-widget-content">'.$row->name.'</td>
                <td class="ui-widget-content">'.$row->hajm.'</td>
                <td class="ui-widget-content">'.$row->summa.'</td>
                <td class="ui-widget-content">'.$row->summa2.'</td>
                <td class="ui-widget-content">'.$row->summa3.'</td>
                </tr>
                ';
            }
        }

        $data = array(
            'table_data'  => $output,
        );

        echo json_encode($data);
        }
    }

    function tbody3table(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
            $data = Tayyorsqlad::where('name', 'like', '%'.$query.'%')->orderBy('id', 'DESC')->get();            
        }
        else
        {
        $data = Tayyorsqlad::orderBy('id', 'DESC')->get();
        }
        $total_row = $data->count();
        if($total_row > 0)
        {
            foreach($data as $row)
            {
                $output .= '
                <tr data-id="'.$row->id.'" id="asdsad" style="border-bottom: 1px solid;">
                <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                <td class="ui-widget-content">'.$row->name.'</td>
                <td class="ui-widget-content">'.$row->hajm.'</td>
                <td class="ui-widget-content">'.$row->summa.'</td>
                <td class="ui-widget-content">'.$row->summa2.'</td>
                <td class="ui-widget-content">'.$row->summa3.'</td>
                </tr>
                ';
            }
        }

        $data = array(
            'table_data'  => $output,
        );

        echo json_encode($data);
        }
    }

    public function rum()
    {
        $data = Tavar2p::all();
        return response()->json($data);        
    }
    public function rum2(Request $request)
    {
        $data = Tavar2p::where('tavarp_id', $request->id)->get();
        return response()->json($data);        
    }

    public function tbody3table2(Request $request)
    {
        if($request->ajax())
        {
            $output = ''; 
            $data = Tayyorsqlad::whereBetween('updated_at', [$request->date1, $request->date2])->get(); 
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr data-id="'.$row->id.'" id="asdsad" style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                    <td class="ui-widget-content">'.$row->name.'</td>
                    <td class="ui-widget-content">'.$row->hajm.'</td>
                    <td class="ui-widget-content">'.$row->summa.'</td>
                    <td class="ui-widget-content">'.$row->summa2.'</td>
                    <td class="ui-widget-content">'.$row->summa3.'</td>
                    </tr>
                    ';
                }
            }
            $data = array(
                'table_data'  => $output,
            );
            echo json_encode($data);
        }
    }

    public function plus(Request $request, KlentServis $model)
    {
        return $model->plus($request);
    }

    public function minus(Request $request, KlentServis $model)
    {
        return $model->minus($request);
    }

    public function udalit(Request $request, KlentServis $model)
    {
        return $model->udalit($request);
    }

    public function yangilash(Request $request, KlentServis $model)
    {
        $validator = Validator::make($request->all(), [
            'soni' => 'required',
            'summo' => 'required',
            'summ' => 'required'
        ]);
        if($validator->passes()){
            return $model->yangilash($request);
        }else{            
            return response()->json(['code'=>0, 'msg'=>'Малумотни киритинг', 'error'=>$validator->errors()->toArray()]);
        }
    }

    public function tugle(Request $request, KlentServis $model)
    {
        return $model->tugle($request);
    }

    public function rachot()
    {
        $data = Itogop::find(1);
        return response()->json($data);
    }

    public function oplata(Request $request, KlentServis $model)
    {
        if($request->naqt){
            return $model->oplata($request);
        }elseif($request->plastik){
            return $model->oplata($request);
        }elseif($request->bank){
            return $model->oplata($request);
        }else{
            return response()->json(['code'=>0, 'msg'=>'Барча устунлар бош']);
        }
    }

    public function zakazayt(Request $request, KlentServis $model)
    {
        return $model->zakazayt($request);
    }
}
