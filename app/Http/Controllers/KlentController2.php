<?php

namespace App\Http\Controllers;

use App\Providers\KlentServis;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Tavarp;
use App\Models\Userp;
use App\Models\Admin;
use App\Models\Adressp;
use App\Models\Arxivp;
use App\Models\Clentitogp;
use App\Models\Datap;
use App\Models\Ichkitavar;
use App\Models\Tayyorsqlad;
use App\Models\Itogop;
use App\Models\Karzinap;
use App\Models\Karzina2p;
use App\Models\Karzina3p;
use App\Models\Sqladpoytaxtp;
use App\Models\Tavar2p;
use App\Models\Umumiyp;
use App\Models\Updatetavrp;
use App\Models\Zakazp;
use App\Models\Zakaz2p;
use App\Models\Ishchilar;
use App\Models\Jonatilgan;
use App\Models\Jonatilgan2;
use App\Models\Trvarcktosh;
use App\Models\Trvarcktoshtosh;
use App\Models\Trvarkеtosh;

class KlentController2 extends Controller
{
    public function tavar(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('id');
        $data = Tayyorsqlad::where('tavarp_id', $query)->get();
        $get = Tayyorsqlad::all();
        $total_row = $data->count();
        if($total_row > 0)
        {
            foreach($data as $row)
            {
                $output .= '
                <tr style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                    <td class="ui-widget-content">'.$row->adress.'</td>
                    <td class="ui-widget-content">'.$row->name.'</td>
                    <td class="ui-widget-content">'.$row->hajm.'</td>
                    <td class="ui-widget-content">'.$row->summa.'</td>
                    <td class="ui-widget-content">'.$row->summa2.'</td>
                    <td class="ui-widget-content">'.$row->summa3.'</td>
                    <td class="ui-widget-content">'.$row->updated_at.'</td>
                </tr>
                ';
            }
            $foo = Datap::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->dateitog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($data as $value) {            
                    $fool = Datap::find(1);        
                    $shtuk = $fool->shtuk + $value->hajm;
                    $dateitog = $fool->dateitog + $value->summa;
                    Datap::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                        'dateitog'=>$dateitog,
                    ]);
                }
                foreach ($get as $value) {
                    $fool2 = Datap::find(1);
                    $a = $fool2->opshi + $value->summa;
                    Datap::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
            }else{
                Datap::create([
                    'dateitog'=>0
                ]);
                foreach ($data as $value) {
                    $foo = Datap::find(1);        
                    $shtuk2 = $foo->shtuk + $value->hajm;
                    $dateitog2 = $foo->dateitog + $value->summa;
                    Datap::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                        'dateitog'=>$dateitog2,
                    ]);
                }
                foreach ($get as $value) {
                    $fool3 = Datap::find(1);
                    $a1 = $fool3->opshi + $value->summa;
                    Datap::find(1)->update([
                        'opshi'=>$a1,
                    ]);
                }
            }
            $foo2 = Datap::find(1);
        }
        return response()->json([
            'output'=>$output, 
            'total_row'=>$total_row,
            'data'=>$data,
            'foo2'=>$foo2??[],
        ]);
        }
    }
    public function tavar_tip(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $datap = DB::table('tavarps')->where('name', 'like', '%'.$query.'%')->get();
        }
        else
        {
        $datap = DB::table('tavarps')->get();
        }
        $total_row = $datap->count();
        if($total_row > 0)
        {
            foreach($datap as $row)
            {
                $output .= '
                <tr data-id="'.$row->id.'" id="data" style="cursor: pointer;" style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->name.'</td>
                </tr>
                ';
            }
        }
        else
        {
        $output = '
            <tr>
                <td align="center" colspan="5">No Datap Found</td>
            </tr>
            ';
        }
        $datap = array(
            'table_data'  => $output,
            'total_data'  => $total_row
        );

        return response()->json($datap);
        }
    }

    public function zzzz(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $datap = DB::table('zakazps')->where('malumot', 'like', '%'.$query.'%')->get();
        }
        else
        {
        $datap = DB::table('zakazps')->get();
        }
        $total_row = $datap->count();
        if($total_row > 0)
        {
            foreach($datap as $row)
            {
                $output .= '
                <tr data-id="'.$row->id.'" id="data2" style="cursor: pointer;" style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->malumot.'</td>
                </tr>
                ';
            }
        }
        else
        {
        $output = '
            <tr>
                <td align="center" colspan="5">No Datap Found</td>
            </tr>
            ';
        }
        return response()->json($output);
        }
    }
    
    public function zzzzcli(Request $request)
    {
        if($request->ajax())
        {
        $output='';
        $datap = Zakaz2p::where('zakazp_id', $request->id)->get();
        $total_row = $datap->count();
        if($total_row > 0)
        {
            foreach($datap as $row)
            {
                $output .= '
                <tr style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->zakazp->malumot.'</td>
                    <td class="ui-widget-content">'.$row->name.'</td>
                    <td class="ui-widget-content">'.$row->summa2.'</td>
                    <td class="ui-widget-content">'.$row->soni.'</td>
                    <td class="ui-widget-content">'.$row->chegirma.'</td>
                    <td class="ui-widget-content">'.$row->itog.'</td>
                </tr>
                ';
            }
        }
        else
        {
        $output = '
            <tr>
                <td align="center" colspan="6">No Datap Found</td>
            </tr>
            ';
        }
        return response()->json($output);
        }
    }

    public function zzzzaaaa(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $datap = DB::table('userps')->where('name', 'like', '%'.$query.'%')->get();
        }
        else
        {
        $datap = DB::table('userps')->get();
        }
        $total_row = $datap->count();
        if($total_row > 0)
        {
            foreach($datap as $row)
            {
                $output .= '
                <tr datap-id="'.$row->id.'" id="data22" style="cursor: pointer;" style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->name.'</td>
                </tr>
                ';
            }
        }
        else
        {
        $output = '
            <tr>
                <td align="center" colspan="5">No Datap Found</td>
            </tr>
            ';
        }
        return response()->json($output);
        }
    }

    public function zzzzclick(Request $request)
    {
        if($request->ajax())
        {
        $output='';
        $da = Userp::find($request->id);
        $datap = Karzina2p::where('userp_id', $da->id)->where('zakazp', 1)->get();
        $total_row = $datap->count();
        if($total_row > 0)
        {
            foreach($datap as $row)
            {
                $output .= '
                <tr style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->userp->name.'</td>
                    <td class="ui-widget-content">'.$row->name.'</td>
                    <td class="ui-widget-content">'.$row->summa2.'</td>
                    <td class="ui-widget-content">'.$row->soni.'</td>
                    <td class="ui-widget-content">'.$row->chegirma.'</td>
                    <td class="ui-widget-content">'.$row->itog.'</td>
                </tr>
                ';
            }
        }
        else
        {
        $output = '
            <tr>
                <td align="center" colspan="6">No Datap Found</td>
            </tr>
            ';
        }
        return response()->json($output);
        }
    }

    public function submitckicked(Request $request)
    {
        if($request->doimiy == 1){
            return $this->doimiyclent($request);
        }else{
            return $this->birlamchiclent($request);
        }
    }

    public function doimiyclent($request)
    {
        $foo = Karzina2p::where('userp_id', $request->id)->where('zakazp', 1)->get();
        foreach ($foo as $value) {
            Karzinap::create([
                'tavarp_id' => $value->tavarp_id,
                'tayyorsqlad_id' => $value->tayyorsqlad_id,
                'name' => $value->name,
                'raqam' => $value->raqam,
                'soni' => $value->soni,
                'hajm' => $value->hajm,
                'summa' => $value->summa,
                'summa2' => $value->summa2,
                'chegirma' =>$value->chegirma,
                'itog' => $value->itog,
            ]);
            $ito = Itogop::find(1);
            if($ito){
                $j = $ito->itogo + $value->itog;
                Itogop::find(1)->update([
                    'itogo'=>$j,
                ]);
                $ito2 = Itogop::find(1);
            }
        }
        Karzina2p::where('userp_id', $request->id)->where('zakaz', 1)->delete();
        return response()->json(['msg'=>'Отказилди', 'data'=>$ito2]);
    }

    public function birlamchiclent($request)
    {
        $foo = Zakaz2p::where('zakazp_id', $request->id)->get();
        foreach ($foo as $value) {
            Karzinap::create([
                'tavarp_id' => $value->tavarp_id,
                'tayyorsqlad_id' => $value->tayyorsqlad_id,
                'name' => $value->name,
                'raqam' => $value->raqam,
                'soni' => $value->soni,
                'hajm' => $value->hajm,
                'summa' => $value->summa,
                'summa2' => $value->summa2,
                'chegirma' =>$value->chegirma,
                'itog' => $value->itog,
            ]);
            $ito = Itogop::find(1);
            if($ito){
                $j = $ito->itogo + $value->itog;
                Itogop::find(1)->update([
                    'itogo'=>$j,
                ]);
                $ito2 = Itogop::find(1);
            }
        }
        Zakaz2p::where('zakazp_id', $request->id)->delete();
        Zakazp::find($request->id)->delete($request->id);
        return response()->json(['msg'=>'Отказилди', 'data'=>$ito2]);
    }

    public function clent_tip(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $datap = DB::table('userps')->where('name', 'like', '%'.$query.'%')->get();
        }
        else
        {
        $datap = DB::table('userps')->get();
        }
        $total_row = $datap->count();
        if($total_row > 0)
        {
            foreach($datap as $row)
            {
                $output .= '
                <tr data-id="'.$row->id.'" id="data" style="cursor: pointer;" style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->name.'</td>
                </tr>
                ';
            }
        }
        else
        {
        $output = '
            <tr>
                <td align="center" colspan="5">No Datap Found</td>
            </tr>
            ';
        }
        $datap = array(
            'table_data'  => $output,
        );
        return response()->json($datap);
        }
    }

    public function savdobirlamchi(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $datap = Karzina3p::where('name', 'like', '%'.$query.'%')->get();
        }
        else
        {
        $datap = Karzina3p::all();
        }
        $total_row = $datap->count();
        if($total_row > 0)
        {
            foreach($datap as $row)
            {
                $output .= '
                <tr style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                    <td class="ui-widget-content">'.$row->raqam.'</td>
                    <td class="ui-widget-content">'.$row->soni.'</td>
                    <td class="ui-widget-content">'.$row->summa2.'</td>
                    <td class="ui-widget-content">'.$row->chegirma.'</td>
                    <td class="ui-widget-content">'.$row->itog.'</td>
                    <td class="ui-widget-content">'.$row->updated_at.'</td>
                </tr>
                ';
            }
        }
        else
        {
        $output = '
            <tr>
                <td align="center" colspan="7">No Datap Found</td>
            </tr>
            ';
        }
        $datap = array(
            'table_data'  => $output,
        );
        return response()->json($datap);
        }
    }
    
    public function vseclent(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $output2 = '';
            $datap = Karzina2p::all();     
            $data222 = Arxivp::all();     
            $total_row = $datap->count();
            if($total_row > 0)
            {
                foreach($datap as $row)
                {
                    $output .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->userp->name.'</td>
                        <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                        <td class="ui-widget-content">'.$row->raqam.'</td>
                        <td class="ui-widget-content">'.$row->soni.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->chegirma.'</td>
                        <td class="ui-widget-content">'.$row->itog.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
                foreach($data222 as $row)
                {
                    $output2 .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->userp->name.'</td>
                        <td class="ui-widget-content">'.$row->itogs.'</td>
                        <td class="ui-widget-content">'.$row->naqt.'</td>
                        <td class="ui-widget-content">'.$row->plastik.'</td>
                        <td class="ui-widget-content">'.$row->bank.'</td>
                        <td class="ui-widget-content">'.$row->karzs.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
            }
            $foo = Clentitogp::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->itog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($datap as $value) {
                    $fool = Clentitogp::find(1);
                    $shtuk = $fool->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->karzs;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
            }else{
                Clentitogp::create([
                    'tavarshtuk'=>0,
                    'shtuk'=>0,
                    'foiz'=>0,
                    'itog'=>0,
                    'opshi'=>0
                ]);
                foreach ($datap as $value) {
                    $foo = Clentitogp::find(1);        
                    $shtuk2 = $foo->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->karzs;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool3 = Clentitogp::find(1);
                    $a1 = $fool3->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a1,
                    ]);
                }
            }
            $foo2 = Clentitogp::find(1);
            return response()->json([
                'output'=>$output,
                'output2'=>$output2,
                'clent'=>"Все Клент",
                'foo2'=>$foo2??[],
            ]);
        }
    }

    public function clents2(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $output2 = '';
            $da = Userp::find($request->id);   
            $datap = Karzina2p::where('userp_id', $da->id)->get();     
            $data222 = Arxivp::where('userp_id', $da->id)->get();     
            $total_row = $datap->count();
            if($total_row > 0)
            {
                foreach($datap as $row)
                {
                    $output .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->userp->name.'</td>
                        <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                        <td class="ui-widget-content">'.$row->raqam.'</td>
                        <td class="ui-widget-content">'.$row->soni.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->chegirma.'</td>
                        <td class="ui-widget-content">'.$row->itog.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
                foreach($data222 as $row)
                {
                    $output2 .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->userp->name.'</td>
                        <td class="ui-widget-content">'.$row->itogs.'</td>
                        <td class="ui-widget-content">'.$row->naqt.'</td>
                        <td class="ui-widget-content">'.$row->plastik.'</td>
                        <td class="ui-widget-content">'.$row->bank.'</td>
                        <td class="ui-widget-content">'.$row->karzs.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
            }
            $foo = Clentitogp::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->itog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($datap as $value) {            
                    $fool = Clentitogp::find(1);
                    $shtuk = $fool->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->karzs;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
            }else{
                Clentitogp::create([
                    'tavarshtuk'=>0,
                    'shtuk'=>0,
                    'foiz'=>0,
                    'itog'=>0,
                    'opshi'=>0
                ]);
                foreach ($datap as $value) {
                    $foo = Clentitogp::find(1);        
                    $shtuk2 = $foo->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->karzs;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool3 = Clentitogp::find(1);
                    $a1 = $fool3->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a1,
                    ]);
                }
            }
            $foo2 = Clentitogp::find(1);
            return response()->json([
                'output'=>$output,
                'output2'=>$output2,
                'clent'=>$da,
                'foo2'=>$foo2??[],
            ]);
        }
    }

    public function clents3(Request $request)
    {
        if($request->tavar_id){
            return $this->clents4($request);
        }elseif($request->tavar_id && $request->date){
            return $this->clents5($request);
        }elseif($request->tavar_id && $request->date && $request->date2){
            return $this->clents5($request);
        }elseif($request->date){
            return $this->clents6($request);
        }elseif($request->date && $request->date2){
            return $this->clents6($request);
        }else{
            // return $this->clents2($request);
        }
    }
    public function brlamclient(Request $request)
    {
        if($request->tavar_id){
            return $this->clents04($request);
        }elseif($request->tavar_id && $request->date){
            return $this->clents05($request);
        }elseif($request->tavar_id && $request->date && $request->date2){
            return $this->clents05($request);
        }elseif($request->date){
            return $this->clents06($request);
        }elseif($request->date && $request->date2){
            return $this->clents06($request);
        }else{
            // return $this->savdobirlamchi($request);
        }
    }

    public function clents4($request)
    {
        if($request->ajax())
        {
            $output = '';
            $output2 = '';
            $da = Userp::find($request->id);   
            $datap = Karzina2p::where('userp_id', $da->id)
                            ->where('tavarp_id', $request->tavarp_id)
                            ->get();
            $data222 = Arxivp::where('userp_id', $da->id)->get();
            $total_row = $datap->count();
            if($total_row > 0)
            {
                foreach($datap as $row)
                {
                    $output .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->userp->name.'</td>
                        <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                        <td class="ui-widget-content">'.$row->raqam.'</td>
                        <td class="ui-widget-content">'.$row->soni.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->chegirma.'</td>
                        <td class="ui-widget-content">'.$row->itog.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
                foreach($data222 as $row)
                {
                    $output2 .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->userp->name.'</td>
                        <td class="ui-widget-content">'.$row->itogs.'</td>
                        <td class="ui-widget-content">'.$row->naqt.'</td>
                        <td class="ui-widget-content">'.$row->plastik.'</td>
                        <td class="ui-widget-content">'.$row->bank.'</td>
                        <td class="ui-widget-content">'.$row->karzs.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
            }
            $foo = Clentitogp::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->itog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($datap as $value) {            
                    $fool = Clentitogp::find(1);
                    $shtuk = $fool->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->karzs;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
            }else{
                Clentitogp::create([
                    'tavarshtuk'=>0,
                    'shtuk'=>0,
                    'foiz'=>0,
                    'itog'=>0,
                    'opshi'=>0
                ]);
                foreach ($datap as $value) {
                    $foo = Clentitogp::find(1);        
                    $shtuk2 = $foo->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->karzs;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool3 = Clentitogp::find(1);
                    $a1 = $fool3->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a1,
                    ]);
                }
            }
            $foo2 = Clentitogp::find(1);
            return response()->json([
                'output'=>$output,
                'output2'=>$output2,
                'clent'=>$da,
                'foo2'=>$foo2??[],
            ]);
        }
    }

    public function clents5($request)
    {
        if($request->ajax())
        {
            $output = '';
            $output2 = '';
            $da = Userp::find($request->id);   
            $datap = Karzina2p::where('userp_id', $da->id)
                            ->where('tavarp_id', $request->tavarp_id)
                            ->whereBetween('updated_at', [$request->date, $request->date2])
                            ->get(); 
            $data222 = Arxivp::where('userp_id', $da->id)->whereBetween('updated_at', [$request->date, $request->date2])->get();
            $total_row = $datap->count();
            if($total_row > 0)
            {
                foreach($datap as $row)
                {
                    $output .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->userp->name.'</td>
                        <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                        <td class="ui-widget-content">'.$row->raqam.'</td>
                        <td class="ui-widget-content">'.$row->soni.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->chegirma.'</td>
                        <td class="ui-widget-content">'.$row->itog.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
                foreach($data222 as $row)
                {
                    $output2 .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->userp->name.'</td>
                        <td class="ui-widget-content">'.$row->itogs.'</td>
                        <td class="ui-widget-content">'.$row->naqt.'</td>
                        <td class="ui-widget-content">'.$row->plastik.'</td>
                        <td class="ui-widget-content">'.$row->bank.'</td>
                        <td class="ui-widget-content">'.$row->karzs.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
            }
            $foo = Clentitogp::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->itog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($datap as $value) {            
                    $fool = Clentitogp::find(1);
                    $shtuk = $fool->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->karzs;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
            }else{
                Clentitogp::create([
                    'tavarshtuk'=>0,
                    'shtuk'=>0,
                    'foiz'=>0,
                    'itog'=>0,
                    'opshi'=>0
                ]);
                foreach ($datap as $value) {
                    $foo = Clentitogp::find(1);        
                    $shtuk2 = $foo->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->karzs;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool3 = Clentitogp::find(1);
                    $a1 = $fool3->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a1,
                    ]);
                }
            }
            $foo2 = Clentitogp::find(1);
            return response()->json([
                'output'=>$output,
                'output2'=>$output2,
                'clent'=>$da,
                'foo2'=>$foo2??[],
            ]);
        }
    }
    public function clents6($request)
    {
        if($request->id){
            if($request->ajax())
            {
                $output = '';
                $output2 = '';
                $da = Userp::find($request->id);   
                $datap = Karzina2p::where('userp_id', $da->id)
                                ->whereBetween('updated_at', [$request->date, $request->date2])
                                ->get();
                $data222 = Arxivp::where('userp_id', $da->id)->whereBetween('updated_at', [$request->date, $request->date2])->get();
                $total_row = $datap->count();
                if($total_row > 0)
                {
                    foreach($datap as $row)
                    {
                        $output .= '
                        <tr style="border-bottom: 1px solid;">
                            <td class="ui-widget-content">'.$row->userp->name.'</td>
                            <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                            <td class="ui-widget-content">'.$row->raqam.'</td>
                            <td class="ui-widget-content">'.$row->soni.'</td>
                            <td class="ui-widget-content">'.$row->summa2.'</td>
                            <td class="ui-widget-content">'.$row->chegirma.'</td>
                            <td class="ui-widget-content">'.$row->itog.'</td>
                            <td class="ui-widget-content">'.$row->updated_at.'</td>
                        </tr>
                        ';
                    }
                    foreach($data222 as $row)
                    {
                        $output2 .= '
                        <tr style="border-bottom: 1px solid;">
                            <td class="ui-widget-content">'.$row->userp->name.'</td>
                            <td class="ui-widget-content">'.$row->itogs.'</td>
                            <td class="ui-widget-content">'.$row->naqt.'</td>
                            <td class="ui-widget-content">'.$row->plastik.'</td>
                            <td class="ui-widget-content">'.$row->bank.'</td>
                            <td class="ui-widget-content">'.$row->karzs.'</td>
                            <td class="ui-widget-content">'.$row->updated_at.'</td>
                        </tr>
                        ';
                    }
                }
                $foo = Clentitogp::find(1);
                if($foo){
                    $foo->tavarshtuk = 0;
                    $foo->shtuk = 0;
                    $foo->foiz = 0;
                    $foo->itog = 0;
                    $foo->opshi = 0;
                    $foo->save();
                    foreach ($datap as $value) {            
                        $fool = Clentitogp::find(1);
                        $shtuk = $fool->shtuk + $value->soni;
                        Clentitogp::find(1)->update([
                            'tavarshtuk'=>$total_row,
                            'shtuk'=>$shtuk,
                        ]);
                    }
                    foreach ($data222 as $value) {
                        $fool2 = Clentitogp::find(1);
                        $a = $fool2->foiz + $value->karzs;
                        Clentitogp::find(1)->update([
                            'foiz'=>$a,
                        ]);
                    }
                    foreach ($datap as $value) {
                        $fool2 = Clentitogp::find(1);
                        $a = $fool2->opshi + $value->itog;
                        Clentitogp::find(1)->update([
                            'opshi'=>$a,
                        ]);
                    }
                }else{
                    Clentitogp::create([
                        'tavarshtuk'=>0,
                        'shtuk'=>0,
                        'foiz'=>0,
                        'itog'=>0,
                        'opshi'=>0
                    ]);
                    foreach ($datap as $value) {
                        $foo = Clentitogp::find(1);        
                        $shtuk2 = $foo->shtuk + $value->soni;
                        Clentitogp::find(1)->update([
                            'tavarshtuk'=>$total_row,
                            'shtuk'=>$shtuk2,
                        ]);
                    }
                    foreach ($data222 as $value) {
                        $fool2 = Clentitogp::find(1);
                        $a = $fool2->foiz + $value->karzs;
                        Clentitogp::find(1)->update([
                            'foiz'=>$a,
                        ]);
                    }
                    foreach ($datap as $value) {
                        $fool3 = Clentitogp::find(1);
                        $a1 = $fool3->opshi + $value->itog;
                        Clentitogp::find(1)->update([
                            'opshi'=>$a1,
                        ]);
                    }
                }
                $foo2 = Clentitogp::find(1);
                return response()->json([
                    'output'=>$output,
                    'output2'=>$output2,
                    'clent'=>$da,
                    'foo2'=>$foo2??[],
                ]);
            }
        }else{
            if($request->ajax())
            {
                $output = '';
                $output2 = '';
                $da = Userp::find($request->id);   
                $datap = Karzina2p::whereBetween('updated_at', [$request->date, $request->date2])->get();
                $data222 = Arxivp::whereBetween('updated_at', [$request->date, $request->date2])->get();
                $total_row = $datap->count();
                if($total_row > 0)
                {
                    foreach($datap as $row)
                    {
                        $output .= '
                        <tr style="border-bottom: 1px solid;">
                            <td class="ui-widget-content">'.$row->userp->name.'</td>
                            <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                            <td class="ui-widget-content">'.$row->raqam.'</td>
                            <td class="ui-widget-content">'.$row->soni.'</td>
                            <td class="ui-widget-content">'.$row->summa2.'</td>
                            <td class="ui-widget-content">'.$row->chegirma.'</td>
                            <td class="ui-widget-content">'.$row->itog.'</td>
                            <td class="ui-widget-content">'.$row->updated_at.'</td>
                        </tr>
                        ';
                    }
                    foreach($data222 as $row)
                    {
                        $output2 .= '
                        <tr style="border-bottom: 1px solid;">
                            <td class="ui-widget-content">'.$row->userp->name.'</td>
                            <td class="ui-widget-content">'.$row->itogs.'</td>
                            <td class="ui-widget-content">'.$row->naqt.'</td>
                            <td class="ui-widget-content">'.$row->plastik.'</td>
                            <td class="ui-widget-content">'.$row->bank.'</td>
                            <td class="ui-widget-content">'.$row->karzs.'</td>
                            <td class="ui-widget-content">'.$row->updated_at.'</td>
                        </tr>
                        ';
                    }
                }
                $foo = Clentitogp::find(1);
                if($foo){
                    $foo->tavarshtuk = 0;
                    $foo->shtuk = 0;
                    $foo->foiz = 0;
                    $foo->itog = 0;
                    $foo->opshi = 0;
                    $foo->save();
                    foreach ($datap as $value) {            
                        $fool = Clentitogp::find(1);
                        $shtuk = $fool->shtuk + $value->soni;
                        Clentitogp::find(1)->update([
                            'tavarshtuk'=>$total_row,
                            'shtuk'=>$shtuk,
                        ]);
                    }
                    foreach ($data222 as $value) {
                        $fool2 = Clentitogp::find(1);
                        $a = $fool2->foiz + $value->karzs;
                        Clentitogp::find(1)->update([
                            'foiz'=>$a,
                        ]);
                    }
                    foreach ($datap as $value) {
                        $fool2 = Clentitogp::find(1);
                        $a = $fool2->opshi + $value->itog;
                        Clentitogp::find(1)->update([
                            'opshi'=>$a,
                        ]);
                    }
                }else{
                    Clentitogp::create([
                        'tavarshtuk'=>0,
                        'shtuk'=>0,
                        'foiz'=>0,
                        'itog'=>0,
                        'opshi'=>0
                    ]);
                    foreach ($datap as $value) {
                        $foo = Clentitogp::find(1);        
                        $shtuk2 = $foo->shtuk + $value->soni;
                        Clentitogp::find(1)->update([
                            'tavarshtuk'=>$total_row,
                            'shtuk'=>$shtuk2,
                        ]);
                    }
                    foreach ($data222 as $value) {
                        $fool2 = Clentitogp::find(1);
                        $a = $fool2->foiz + $value->karzs;
                        Clentitogp::find(1)->update([
                            'foiz'=>$a,
                        ]);
                    }
                    foreach ($datap as $value) {
                        $fool3 = Clentitogp::find(1);
                        $a1 = $fool3->opshi + $value->itog;
                        Clentitogp::find(1)->update([
                            'opshi'=>$a1,
                        ]);
                    }
                }
                $foo2 = Clentitogp::find(1);
                return response()->json([
                    'output'=>$output,
                    'output2'=>$output2,
                    'clent'=>"Все клент",
                    'foo2'=>$foo2??[],
                ]);
            }
        }
    }
    public function clents04($request)
    {
        if($request->ajax())
        {
            $output = '';
            $output2 = '';  
            $datap = Karzina3p::where('tavarp_id', $request->tavarp_id)->get();
            $total_row = $datap->count();
            if($total_row > 0)
            {
                foreach($datap as $row)
                {
                    $output .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                        <td class="ui-widget-content">'.$row->raqam.'</td>
                        <td class="ui-widget-content">'.$row->soni.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->chegirma.'</td>
                        <td class="ui-widget-content">'.$row->itog.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
            }
            $foo = Clentitogp::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->itog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($datap as $value) {            
                    $fool = Clentitogp::find(1);
                    $shtuk = $fool->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
            }else{
                Clentitogp::create([
                    'tavarshtuk'=>0,
                    'shtuk'=>0,
                    'foiz'=>0,
                    'itog'=>0,
                    'opshi'=>0
                ]);
                foreach ($datap as $value) {
                    $foo = Clentitogp::find(1);        
                    $shtuk2 = $foo->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool3 = Clentitogp::find(1);
                    $a1 = $fool3->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a1,
                    ]);
                }
            }
            $foo2 = Clentitogp::find(1);
            return response()->json([
                'output'=>$output,
                'output2'=>$output2,
                'foo2'=>$foo2??[],
            ]);
        }
    }
    public function clents05($request)
    {
        if($request->ajax())
        {
            $output = '';
            $output2 = '';
            $datap = Karzina3p::where('tavarp_id', $request->tavarp_id)->whereBetween('updated_at', [$request->date, $request->date2])->get(); 
            $total_row = $datap->count();
            if($total_row > 0)
            {
                foreach($datap as $row)
                {
                    $output .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                        <td class="ui-widget-content">'.$row->raqam.'</td>
                        <td class="ui-widget-content">'.$row->soni.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->chegirma.'</td>
                        <td class="ui-widget-content">'.$row->itog.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
            }
            $foo = Clentitogp::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->itog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($datap as $value) {            
                    $fool = Clentitogp::find(1);
                    $shtuk = $fool->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
            }else{
                Clentitogp::create([
                    'tavarshtuk'=>0,
                    'shtuk'=>0,
                    'foiz'=>0,
                    'itog'=>0,
                    'opshi'=>0
                ]);
                foreach ($datap as $value) {
                    $foo = Clentitogp::find(1);        
                    $shtuk2 = $foo->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool3 = Clentitogp::find(1);
                    $a1 = $fool3->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a1,
                    ]);
                }
            }
            $foo2 = Clentitogp::find(1);
            return response()->json([
                'output'=>$output,
                'output2'=>$output2,
                'foo2'=>$foo2??[],
            ]);
        }
    }
    public function clents06($request)
    {
        if($request->ajax())
        {
            $output = '';
            $output2 = '';
            $datap = Karzina3p::whereBetween('updated_at', [$request->date, $request->date2])->get();
            $total_row = $datap->count();
            if($total_row > 0)
            {
                foreach($datap as $row)
                {
                    $output .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                        <td class="ui-widget-content">'.$row->raqam.'</td>
                        <td class="ui-widget-content">'.$row->soni.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->chegirma.'</td>
                        <td class="ui-widget-content">'.$row->itog.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
            }
            $foo = Clentitogp::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->itog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($datap as $value) {            
                    $fool = Clentitogp::find(1);
                    $shtuk = $fool->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
            }else{
                Clentitogp::create([
                    'tavarshtuk'=>0,
                    'shtuk'=>0,
                    'foiz'=>0,
                    'itog'=>0,
                    'opshi'=>0
                ]);
                foreach ($datap as $value) {
                    $foo = Clentitogp::find(1);        
                    $shtuk2 = $foo->shtuk + $value->soni;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool3 = Clentitogp::find(1);
                    $a1 = $fool3->opshi + $value->itog;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a1,
                    ]);
                }
            }
            $foo2 = Clentitogp::find(1);
            return response()->json([
                'output'=>$output,
                'output2'=>$output2,
                'foo2'=>$foo2??[],
            ]);
        }
    }

    public function tavarvse(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $datap = Tayyorsqlad::all();
        $total_row = $datap->count();
        if($total_row > 0)
        {
            foreach($datap as $row)
            {
                $output .= '
                <tr style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                    <td class="ui-widget-content">'.$row->adress.'</td>
                    <td class="ui-widget-content">'.$row->name.'</td>
                    <td class="ui-widget-content">'.$row->hajm.'</td>
                    <td class="ui-widget-content">'.$row->summa.'</td>
                    <td class="ui-widget-content">'.$row->summa2.'</td>
                    <td class="ui-widget-content">'.$row->summa3.'</td>
                    <td class="ui-widget-content">'.$row->updated_at.'</td>
                </tr>
                ';
            }
            $foo = Datap::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->dateitog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($datap as $value) {            
                    $fool = Datap::find(1);
                    $shtuk = $fool->shtuk + $value->hajm;
                    $dateitog = $fool->dateitog + $value->summa;
                    Datap::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                        'dateitog'=>$dateitog,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool2 = Datap::find(1);
                    $a = $fool2->opshi + $value->summa;
                    Datap::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
            }else{
                Datap::create([
                    'dateitog'=>0
                ]);
                foreach ($datap as $value) {
                    $foo = Datap::find(1);        
                    $shtuk2 = $foo->shtuk + $value->hajm;
                    $dateitog2 = $foo->dateitog + $value->summa;
                    Datap::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                        'dateitog'=>$dateitog2,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool3 = Datap::find(1);
                    $a1 = $fool3->opshi + $value->summa;
                    Datap::find(1)->update([
                        'opshi'=>$a1,
                    ]);
                }
            }
            $foo2 = Datap::find(1);
        }
        return response()->json([
            'output'=>$output, 
            'total_row'=>$total_row,
            'datap'=>$datap,
            'foo2'=>$foo2??[],
        ]);
        }
    }

    public function tavarp(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('id');
        $datap = Tayyorsqlad::where('tavarp_id', $query)->get();
        $get = Tayyorsqlad::all();
        $total_row = $datap->count();
        if($total_row > 0)
        {
            foreach($datap as $row)
            {
                $output .= '
                <tr style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                    <td class="ui-widget-content">'.$row->adressp.'</td>
                    <td class="ui-widget-content">'.$row->name.'</td>
                    <td class="ui-widget-content">'.$row->hajm.'</td>
                    <td class="ui-widget-content">'.$row->summa.'</td>
                    <td class="ui-widget-content">'.$row->summa2.'</td>
                    <td class="ui-widget-content">'.$row->summa3.'</td>
                    <td class="ui-widget-content">'.$row->updated_at.'</td>
                </tr>
                ';
            }
            $foo = Datap::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->dateitog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($datap as $value) {            
                    $fool = Datap::find(1);        
                    $shtuk = $fool->shtuk + $value->hajm;
                    $dateitog = $fool->dateitog + $value->summa;
                    Datap::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                        'dateitog'=>$dateitog,
                    ]);
                }
                foreach ($get as $value) {
                    $fool2 = Datap::find(1);
                    $a = $fool2->opshi + $value->summa;
                    Datap::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
            }else{
                Datap::create([
                    'dateitog'=>0
                ]);
                foreach ($datap as $value) {
                    $foo = Datap::find(1);        
                    $shtuk2 = $foo->shtuk + $value->hajm;
                    $dateitog2 = $foo->dateitog + $value->summa;
                    Datap::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                        'dateitog'=>$dateitog2,
                    ]);
                }
                foreach ($get as $value) {
                    $fool3 = Datap::find(1);
                    $a1 = $fool3->opshi + $value->summa;
                    Datap::find(1)->update([
                        'opshi'=>$a1,
                    ]);
                }
            }
            $foo2 = Datap::find(1);
        }
        return response()->json([
            'output'=>$output, 
            'total_row'=>$total_row,
            'datap'=>$datap,
            'foo2'=>$foo2??[],
        ]);
        }
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $datap = Tayyorsqlad::whereBetween('updated_at', [$request->date, $request->date2])->get();
        $total_row = $datap->count();
        if($total_row > 0)
        {
            foreach($datap as $row)
            {
                $output .= '
                <tr style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                    <td class="ui-widget-content">'.$row->adressp.'</td>
                    <td class="ui-widget-content">'.$row->name.'</td>
                    <td class="ui-widget-content">'.$row->hajm.'</td>
                    <td class="ui-widget-content">'.$row->summa.'</td>
                    <td class="ui-widget-content">'.$row->summa2.'</td>
                    <td class="ui-widget-content">'.$row->summa3.'</td>
                    <td class="ui-widget-content">'.$row->updated_at.'</td>
                </tr>
                ';
            }
            $foo = Datap::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->dateitog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($datap as $value) {            
                    $fool = Datap::find(1);        
                    $shtuk = $fool->shtuk + $value->hajm;
                    $dateitog = $fool->dateitog + $value->summa;
                    Datap::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                        'dateitog'=>$dateitog,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool2 = Datap::find(1);
                    $a = $fool2->opshi + $value->summa;
                    Datap::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
            }else{
                Datap::create([
                    'dateitog'=>0
                ]);
                foreach ($datap as $value) {
                    $foo = Datap::find(1);        
                    $shtuk2 = $foo->shtuk + $value->hajm;
                    $dateitog2 = $foo->dateitog + $value->summa;
                    Datap::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                        'dateitog'=>$dateitog2,
                    ]);
                }
                foreach ($datap as $value) {
                    $fool3 = Datap::find(1);
                    $a1 = $fool3->opshi + $value->summa;
                    Datap::find(1)->update([
                        'opshi'=>$a1,
                    ]);
                }
            }
            $foo2 = Datap::find(1);
        }
        return response()->json([
            'output'=>$output, 
            'total_row'=>$total_row,
            'datap'=>$datap,
            'foo2'=>$foo2??[],
        ]);
        }
    }

    public function datap(Request $request)
    {
        $foo = Datap::find(1);
        if($foo){
            $foo->dateitog = 0;
            $foo->save();
            $variable = Tayyorsqlad::whereBetween('updated_at', [$request->date, $request->date2])->get();
            foreach ($variable as $value) {            
                $foo = Datap::find(1);        
                $a = $foo->dateitog + $value->summa;
                Datap::find(1)->update([
                    'dateitog'=>$a
                ]);
                $foo2 = Datap::find(1);
            }
            return $foo2;
        }else{
            Datap::create([
                'dateitog'=>0
            ]);
            return $this->data2($request);
        }
    }

    public function data2($request)
    {
        $variable = Tayyorsqlad::whereBetween('updated_at', [$request->date, $request->date2])->get();
        foreach ($variable as $value) {            
            $foo = Datap::find(1);        
            $a = $foo->dateitog + $value->summa;
            Datap::find(1)->update([
                'dateitog'=>$a
            ]);
            $foo2 = Datap::find(1);
        }
        return $foo2;
    }

    public function datasearche(Request $request)
    {
        if($request->date && $request->date2){
            $variable = Tayyorsqlad::whereBetween('updated_at', [$request->date, $request->date2])->get();
            $datap = Tavarp::all();
            $adressp = Adressp::all();
            $jonatilgan = Jonatilgan::count();
            if(Session::has('IDIE')){
              $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
              return view('tavar2',[
                  'brends'=>$brends,
                  'jonatilgan'=>$jonatilgan,
                  'tayyorsqlad'=>$variable,
                  'datap'=>$datap,
                  'adressp'=>$adressp,
              ]);
            }else{
                return redirect('/logaut');
            }
        }elseif($request->date){
            $variable = Tayyorsqlad::where('updated_at', ">=", $request->date)->get();
            $datap = Tavarp::all();
            $adressp = Adressp::all();
            $jonatilgan = Jonatilgan::count();
            if(Session::has('IDIE')){
              $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
              return view('tavar2',[
                  'brends'=>$brends,
                  'jonatilgan'=>$jonatilgan,
                  'tayyorsqlad'=>$variable,
                  'datap'=>$datap,
                  'adressp'=>$adressp,
              ]);
            }else{
                return redirect('/logaut');
            }
        }elseif($request->date2){
            $variable = Tayyorsqlad::where('updated_at', ">=", $request->date2)->get();
            $datap = Tavarp::all();
            $adressp = Adressp::all();
            $jonatilgan = Jonatilgan::count();
            if(Session::has('IDIE')){
              $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
              return view('tavar2p',[
                  'brends'=>$brends,
                  'jonatilgan'=>$jonatilgan,
                  'tayyorsqlad'=>$variable,
                  'datap'=>$datap,
                  'adressp'=>$adressp,
              ]);
            }else{
                return redirect('/logaut');
            }
        }else{
            return back();
        }
    }

    public function clent2()
    {
        $jonatilgan = Jonatilgan::count();
        $tavarp = Tavarp::all();
        if(Session::has('IDIE')){
            $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
            return view('clent2',[
                'brends'=>$brends,
                'tavar'=>$tavarp,
                'jonatilgan'=>$jonatilgan
            ]);
        }else{
            return redirect('/logaut');
        }
    }

    public function prodacha()
    {
        $jonatilgan = Jonatilgan::count();
        if(Session::has('IDIE')){
            $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
            return view('prodacha',[
                'brends'=>$brends,
                'jonatilgan'=>$jonatilgan
            ]);
        }else{
            return redirect('/logaut');
        }
    }

    public function sqladiski()
    {
        $jonatilgan = Jonatilgan::count();
        if(Session::has('IDIE')){
            $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
            return view('sqladski',[
                'brends'=>$brends,
                'jonatilgan'=>$jonatilgan
            ]);
        }else{
            return redirect('/logaut');
        }
    }

    public function kelgantovar()
    {
        $jonatil = Jonatilgan::all();
        $jonatilgan = Jonatilgan::count();
        if(Session::has('IDIE')){
            $brends = Ishchilar::where('id','=',Session::get('IDIE'))->first();
            return view('kelgantovar',[
                'brends'=>$brends,
                'jonatilgan'=>$jonatilgan,
                'jonatil'=>$jonatil,
            ]);
        }else{
            return redirect('/logaut');
        }
    }

    public function otkazish(Request $request)
    {        
        $datap = Tayyorsqlad::find($request->id);
        $foo = Sqladpoytaxtp::create([
            'tavarp_id' =>$datap->tavarp_id, 
            'adress' =>$datap->adress, 
            'tavar2p_id' =>$datap->tavar2p_id, 
            'name' =>$datap->name, 
            'raqam' =>$datap->raqam, 
            'hajm' =>1, 
            'summa' =>$datap->summa, 
            'summa2' =>$datap->summa2, 
            'summa3' =>$datap->summa3,
        ]);
        return response()->json(['output'=>$foo]);
    }

    public function malumotolish(Request $request)
    {
        return response()->json(Sqladpoytaxtp::find($request->id));
    }

    public function plussqlad(Request $request)
    {
        $foo = Sqladpoytaxtp::find($request->id);
        $datap = Tayyorsqlad::where('tavarp_id', $foo->tavarp_id)
                        ->where('tavar2p_id', $foo->tavar2p_id)
                        ->first();
        $foo2 = $foo->hajm + 1;
        if($datap->hajm < $foo2){
            return response()->json(['status'=>0, 'datap'=>$foo]);
        }else{
            Sqladpoytaxtp::find($request->id)->update([
                'hajm'=>$foo2
            ]);
        }
        $date = Sqladpoytaxtp::find($request->id);
        return response()->json(['status'=>200, 'datap'=>$date]);
    }

    public function minussqlad(Request $request)
    {
        $foo = Sqladpoytaxtp::find($request->id);
        $foo2 = $foo->hajm - 1;
        if($foo2 == 0){
            return response()->json(['status'=>0, 'datap'=>$foo]);
        }else{
            Sqladpoytaxtp::find($request->id)->update([
                'hajm'=>$foo2
            ]);
        }
        $date = Sqladpoytaxtp::find($request->id);
        return response()->json(['status'=>200, 'datap'=>$date]);
    }

    public function udalitsqlad(Request $request)
    {
        Sqladpoytaxtp::find($request->id)->delete($request->id);   
        return response()->json(['status'=>200]);
    }
    public function yangilashsqlad(Request $request)
    {
        return response()->json(Sqladpoytaxtp::find($request->id));
    }
    
    public function saqlashsqlad(Request $request)
    {
        $foo = Sqladpoytaxtp::find($request->id);
        $datap = Tayyorsqlad::where('tavarp_id', $foo->tavarp_id)
                        ->where('tavar2p_id', $foo->tavar2p_id)
                        ->first();
        if($datap->hajm < $request->son){
            return response()->json(['status'=>0, 'datap'=>$foo]);
        }else{
            Sqladpoytaxtp::find($request->id)->update([
                'hajm'=>$request->son
            ]);
        }
        $date = Sqladpoytaxtp::find($request->id);
        return response()->json(['status'=>200, 'datap'=>$date]);
    }

    public function tayyorsqlad(Request $request)
    {
        $datap = Sqladpoytaxtp::all();
        foreach($datap as $data2){
            $sss = Jonatilgan2::where('tavar_id', $data2->tavarp_id)
                        ->where('tavar_id', $data2->tavar2p_id)
                        ->first();
            if($sss){
                $swer = $sss->hajm + $data2->hajm;
                Jonatilgan2::where('tavar_id', $data2->tavarp_id)
                        ->where('tavar2_id', $data2->tavar2p_id)
                        ->update([
                            'name' =>$data2->name, 
                            'raqam' =>$data2->raqam, 
                            'hajm' =>$swer, 
                            'summa' =>$data2->summa, 
                            'summa2' =>$data2->summa2, 
                            'summa3' =>$data2->summa3,
                        ]);
                $ssss = Tayyorsqlad::where('tavarp_id', $data2->tavarp_id)
                                ->where('tavar2p_id', $data2->tavar2p_id)
                                ->first();
                $ccc = $ssss->hajm - $data2->hajm;
                Tayyorsqlad::where('tavarp_id', $data2->tavarp_id)
                        ->where('tavar2p_id', $data2->tavar2p_id)
                        ->update([
                            'hajm'=>$ccc
                        ]);
                Sqladpoytaxtp::where('id', ">", 0)->delete();
            }else{
                Jonatilgan2::create([
                    'tavar_id' =>$data2->tavarp_id, 
                    'adress' =>$data2->adress,
                    'tavar2_id' =>$data2->tavar2p_id,
                    'name' =>$data2->name,
                    'raqam' =>$data2->raqam, 
                    'hajm' =>$data2->hajm, 
                    'summa' =>$data2->summa, 
                    'summa2' =>$data2->summa2, 
                    'summa3' =>$data2->summa3,
                ]);
                $ssss = Tayyorsqlad::where('tavarp_id', $data2->tavarp_id)
                                ->where('tavar2p_id', $data2->tavar2p_id)
                                ->first();
                $ccc = $ssss->hajm - $data2->hajm;
                Tayyorsqlad::where('tavarp_id', $data2->tavarp_id)
                            ->where('tavar2p_id', $data2->tavar2p_id)
                            ->update([
                                'hajm'=>$ccc
                            ]);
                Sqladpoytaxtp::where('id', ">", 0)->delete();
            }
        }
        return response()->json(['status'=>200]);
    }

    public function sinimayt(Request $request)
    {
        $datap = Jonatilgan::all();
        foreach($datap as $data2){
            $sss = Tayyorsqlad::where('tavarp_id', $data2->tavarp_id)
                        ->where('tavarp_id', $data2->tavar2p_id)
                        ->first();
            if($sss){
            $swer = $sss->hajm + $data2->hajm;
            Tayyorsqlad::where('tavarp_id', $data2->tavarp_id)
                ->where('tavarp_id', $data2->tavar2p_id)
                ->update([
                    'name' =>$data2->name, 
                    'raqam' =>$data2->raqam, 
                    'hajm' =>$swer, 
                    'summa' =>$data2->summa, 
                    'summa2' =>$data2->summa2, 
                    'summa3' =>$data2->summa3,
                ]);
                $updates = Updatetavrp::where('tavarp_id', $data2["tavarp_id"])
                                    ->where('tayyorsqlad_id', $sss->id)
                                    ->where('adress', $data2["adress"])
                                    ->where('tavar2p_id', $data2["tavar2p_id"])
                                    ->first();
                if($updates){
                Updatetavrp::where('tavarp_id', $data2["tavarp_id"])
                    ->where('tayyorsqlad_id', $sss->id)
                    ->where('adress', $data2["adress"])
                    ->where('tavar2p_id', $data2["tavar2p_id"])
                    ->update([
                        'raqam'=>$data2["raqam"],
                        'hajm'=>$data2["hajm"],
                        'summa'=>$data2["summa"],
                        'summa2'=>$data2["summa2"],
                        'summa3'=>$data2["summa3"],
                    ]);
                }else{
                    Updatetavrp::create([
                        'tavarp_id'=>$data2["tavarp_id"],
                        'tayyorsqlad_id'=>$sss->id,
                        'adress'=>$data2["adress"],
                        'tavar2p_id'=>$data2["tavar2p_id"],
                        'raqam'=>$data2["raqam"],
                        'hajm'=>$data2["hajm"],
                        'summa'=>$data2["summa"],
                        'summa2'=>$data2["summa2"],
                        'summa3'=>$data2["summa3"],
                    ]);
                }
                Jonatilgan::where('id', ">", 0)->delete();
            }else{
               $sss2 = Tayyorsqlad::create([
                    'tavarp_id' =>$data2->tavarp_id, 
                    'adress' =>$data2->adress,
                    'tavar2p_id' =>$data2->tavar2p_id,
                    'name' =>$data2->name,
                    'raqam' =>$data2->raqam, 
                    'hajm' =>$data2->hajm, 
                    'summa' =>$data2->summa, 
                    'summa2' =>$data2->summa2, 
                    'summa3' =>$data2->summa3,
                ]);
                $updates = Updatetavrp::where('tavarp_id', $data2["tavarp_id"])
                                ->where('tayyorsqlad_id', $sss2->id)
                                ->where('adress', $data2["adress"])
                                ->where('tavar2p_id', $data2["tavar2p_id"])
                                ->first();
                if($updates){
                Updatetavrp::where('tavarp_id', $data2["tavarp_id"])
                        ->where('tayyorsqlad_id', $sss2->id)
                        ->where('adress', $data2["adress"])
                        ->where('tavar2p_id', $data2["tavar2p_id"])
                        ->update([
                            'raqam'=>$data2["raqam"],
                            'hajm'=>$data2["hajm"],
                            'summa'=>$data2["summa"],
                            'summa2'=>$data2["summa2"],
                            'summa3'=>$data2["summa3"],
                        ]);
                }else{
                    Updatetavrp::create([
                        'tavarp_id'=>$data2["tavarp_id"],
                        'tayyorsqlad_id'=>$sss2->id,
                        'adress'=>$data2["adress"],
                        'tavar2p_id'=>$data2["tavar2p_id"],
                        'raqam'=>$data2["raqam"],
                        'hajm'=>$data2["hajm"],
                        'summa'=>$data2["summa"],
                        'summa2'=>$data2["summa2"],
                        'summa3'=>$data2["summa3"],
                    ]);
                }
                Jonatilgan::where('id', ">", 0)->delete();
            }
        }
        return redirect('/glavni');
    }

    public function tav(Request $request)
    {
        if($request->ajax())
        {
        $output = '';
        $query = $request->get('query');
        if($query != '')
        {
        $data = Tayyorsqlad::where('name', 'like', '%'.$query.'%')->get();
        }
        else
        {
        $data = Tayyorsqlad::get();
        }
        $total_row = $data->count();
        if($total_row > 0)
        {
            foreach($data as $row)
            {
                $output .= '
                <tr data-id="'.$row->id.'" id="tav1" style="cursor: pointer;" style="border-bottom: 1px solid;">
                    <td class="ui-widget-content">'.$row->name.'</td>
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
        return response()->json($data);
        }
    }
    public function tavarvseme(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $output2 = '';
            $data = Trvarkеtosh::all();     
            $data222 = Trvarcktosh::all();     
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                        <td class="ui-widget-content">'.$row->tavar2p->name.'</td>
                        <td class="ui-widget-content">'.$row->hajm.'</td>
                        <td class="ui-widget-content">'.$row->summa.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->summa3.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
                foreach($data222 as $row)
                {
                    $output2 .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavar2p->name.'</td>
                        <td class="ui-widget-content">'.$row->hajm.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->summa3.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
            }
            $foo = Clentitogp::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->itog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($data as $value) {
                    $fool = Clentitogp::find(1);
                    $shtuk = $fool->shtuk + $value->hajm;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->summa3;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
                foreach ($data as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->summa;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
            }else{
                Clentitogp::create([
                    'tavarshtuk'=>0,
                    'shtuk'=>0,
                    'foiz'=>0,
                    'itog'=>0,
                    'opshi'=>0
                ]);
                foreach ($data as $value) {
                    $foo = Clentitogp::find(1);        
                    $shtuk2 = $foo->shtuk + $value->hajm;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->summa3;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
                foreach ($data as $value) {
                    $fool3 = Clentitogp::find(1);
                    $a1 = $fool3->foiz + $value->itog;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a1,
                    ]);
                }
            }
            $foo2 = Clentitogp::find(1);
            return response()->json([
                'output'=>$output,
                'output2'=>$output2,
                'clent'=>"Все Товар",
                'foo2'=>$foo2??[],
            ]);
        }
    }

    public function tavarxisob(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $output2 = '';
            $da = Tayyorsqlad::find($request->id);   
            $data = Trvarkеtosh::where('tayyorsqlad_id', $da->id)->get();     
            $data222 = Trvarcktosh::where('tayyorsqlad_id', $da->id)->get();     
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                        <td class="ui-widget-content">'.$row->tavar2p->name.'</td>
                        <td class="ui-widget-content">'.$row->hajm.'</td>
                        <td class="ui-widget-content">'.$row->summa.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->summa3.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
                foreach($data222 as $row)
                {
                    $output2 .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavar2p->name.'</td>
                        <td class="ui-widget-content">'.$row->hajm.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->summa3.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
            }
            $foo = Clentitogp::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->itog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($data as $value) {            
                    $fool = Clentitogp::find(1);
                    $shtuk = $fool->shtuk + $value->hajm;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->summa3;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
                foreach ($data as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->summa;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
            }else{
                Clentitogp::create([
                    'tavarshtuk'=>0,
                    'shtuk'=>0,
                    'foiz'=>0,
                    'itog'=>0,
                    'opshi'=>0
                ]);
                foreach ($data as $value) {
                    $foo = Clentitogp::find(1);        
                    $shtuk2 = $foo->shtuk + $value->hajm;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->summa3;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
                foreach ($data as $value) {
                    $fool3 = Clentitogp::find(1);
                    $a1 = $fool3->foiz + $value->summa;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a1,
                    ]);
                }
            }
            $foo2 = Clentitogp::find(1);
            return response()->json([
                'output'=>$output,
                'output2'=>$output2,
                'clent'=>$da,
                'foo2'=>$foo2??[],
            ]);
        }
    }

    public function tavars333(Request $request)
    {
        if($request->id){
            return $this->ctavar4($request);
        }elseif($request->id && $request->date){
            return $this->ctavars5($request);
        }elseif($request->id && $request->date && $request->date2){
            return $this->ctavars5($request);
        }elseif($request->date){
            return $this->ctavars6($request);
        }elseif($request->date && $request->date2){
            return $this->ctavars6($request);
        }else{
            // return $this->clents2($request);
        }
    }

    public function ctavar4($request)
    {
        if($request->ajax())
        {
            $output = '';
            $output2 = '';
            $da = Tayyorsqlad::find($request->id);   
            $data = Trvarkеtosh::where('tayyorsqlad_id', $request->id)->get();     
            $data222 = Trvarcktosh::where('tayyorsqlad_id', $request->id)->get();     
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                        <td class="ui-widget-content">'.$row->tavar2p->name.'</td>
                        <td class="ui-widget-content">'.$row->hajm.'</td>
                        <td class="ui-widget-content">'.$row->summa.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->summa3.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
                foreach($data222 as $row)
                {
                    $output2 .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavar2p->name.'</td>
                        <td class="ui-widget-content">'.$row->hajm.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->summa3.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
            }
            $foo = Clentitogp::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->itog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($data as $value) {            
                    $fool = Clentitogp::find(1);
                    $shtuk = $fool->shtuk + $value->hajm;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->summa3;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
                foreach ($data as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->summa;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
            }else{
                Clentitogp::create([
                    'tavarshtuk'=>0,
                    'shtuk'=>0,
                    'foiz'=>0,
                    'itog'=>0,
                    'opshi'=>0
                ]);
                foreach ($data as $value) {
                    $foo = Clentitogp::find(1);        
                    $shtuk2 = $foo->shtuk + $value->hajm;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->summa3;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
                foreach ($data as $value) {
                    $fool3 = Clentitogp::find(1);
                    $a1 = $fool3->foiz + $value->summa;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a1,
                    ]);
                }
            }
            $foo2 = Clentitogp::find(1);
            return response()->json([
                'output'=>$output,
                'output2'=>$output2,
                'clent'=>$da,
                'foo2'=>$foo2??[],
            ]);
        }
    }

    public function ctavars5($request)
    {
        if($request->ajax())
        {
            $output = '';
            $output2 = '';
            $da = Tayyorsqlad::find($request->id);   
            $data = Trvarkеtosh::where('tayyorsqlad_id', $request->id)->whereBetween('updated_at', [$request->date, $request->date2])->get();
            $data222 = Trvarcktosh::where('tayyorsqlad_id', $request->id)->whereBetween('updated_at', [$request->date, $request->date2])->get();     
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                        <td class="ui-widget-content">'.$row->tavar2p->name.'</td>
                        <td class="ui-widget-content">'.$row->hajm.'</td>
                        <td class="ui-widget-content">'.$row->summa.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->summa3.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
                foreach($data222 as $row)
                {
                    $output2 .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavar2p->name.'</td>
                        <td class="ui-widget-content">'.$row->hajm.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->summa3.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
            }
            $foo = Clentitogp::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->itog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($data as $value) {            
                    $fool = Clentitogp::find(1);
                    $shtuk = $fool->shtuk + $value->hajm;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->summa3;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
                foreach ($data as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->summa;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
            }else{
                Clentitogp::create([
                    'tavarshtuk'=>0,
                    'shtuk'=>0,
                    'foiz'=>0,
                    'itog'=>0,
                    'opshi'=>0
                ]);
                foreach ($data as $value) {
                    $foo = Clentitogp::find(1);        
                    $shtuk2 = $foo->shtuk + $value->hajm;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->summa3;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
                foreach ($data as $value) {
                    $fool3 = Clentitogp::find(1);
                    $a1 = $fool3->foiz + $value->summa;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a1,
                    ]);
                }
            }
            $foo2 = Clentitogp::find(1);
            return response()->json([
                'output'=>$output,
                'output2'=>$output2,
                'clent'=>$da,
                'foo2'=>$foo2??[],
            ]);
        }
    }

    public function ctavars6($request)
    {
        if($request->ajax())
        {
            $output = '';
            $output2 = '';
            $data = Trvarkеtosh::whereBetween('updated_at', [$request->date, $request->date2])->get();
            $data222 = Trvarcktosh::whereBetween('updated_at', [$request->date, $request->date2])->get();     
            $total_row = $data->count();
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavarp->name.'</td>
                        <td class="ui-widget-content">'.$row->tavar2p->name.'</td>
                        <td class="ui-widget-content">'.$row->hajm.'</td>
                        <td class="ui-widget-content">'.$row->summa.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->summa3.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
                foreach($data222 as $row)
                {
                    $output2 .= '
                    <tr style="border-bottom: 1px solid;">
                        <td class="ui-widget-content">'.$row->tavar2p->name.'</td>
                        <td class="ui-widget-content">'.$row->hajm.'</td>
                        <td class="ui-widget-content">'.$row->summa2.'</td>
                        <td class="ui-widget-content">'.$row->summa3.'</td>
                        <td class="ui-widget-content">'.$row->updated_at.'</td>
                    </tr>
                    ';
                }
            }
            $foo = Clentitogp::find(1);
            if($foo){
                $foo->tavarshtuk = 0;
                $foo->shtuk = 0;
                $foo->foiz = 0;
                $foo->itog = 0;
                $foo->opshi = 0;
                $foo->save();
                foreach ($data as $value) {            
                    $fool = Clentitogp::find(1);
                    $shtuk = $fool->shtuk + $value->hajm;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->summa3;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
                foreach ($data as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->foiz + $value->summa;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a,
                    ]);
                }
            }else{
                Clentitogp::create([
                    'tavarshtuk'=>0,
                    'shtuk'=>0,
                    'foiz'=>0,
                    'itog'=>0,
                    'opshi'=>0
                ]);
                foreach ($data as $value) {
                    $foo = Clentitogp::find(1);        
                    $shtuk2 = $foo->shtuk + $value->hajm;
                    Clentitogp::find(1)->update([
                        'tavarshtuk'=>$total_row,
                        'shtuk'=>$shtuk2,
                    ]);
                }
                foreach ($data222 as $value) {
                    $fool2 = Clentitogp::find(1);
                    $a = $fool2->opshi + $value->summa3;
                    Clentitogp::find(1)->update([
                        'opshi'=>$a,
                    ]);
                }
                foreach ($data as $value) {
                    $fool3 = Clentitogp::find(1);
                    $a1 = $fool3->foiz + $value->summa;
                    Clentitogp::find(1)->update([
                        'foiz'=>$a1,
                    ]);
                }
            }
            $foo2 = Clentitogp::find(1);
            return response()->json([
                'output'=>$output,
                'output2'=>$output2,
                'foo2'=>$foo2??[],
            ]);
        }
    }
}
