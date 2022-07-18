<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zakaz2p extends Model
{
    use HasFactory;
    public $fillable = [
        'zakazp_id', 
        'tavarp_id', 
        'tayyorsqlad_id',
        'name', 
        'soni', 
        'raqam', 
        'hajm', 
        'summa', 
        'summa2', 
        'chegirma', 
        'itog',
    ];
    public $timestamps = true;

    public function zakazp()
    {
        return $this->belongsTo(Zakazp::class);
    }
    
    public function tavarp()
    {
        return $this->belongsTo(Tavarp::class);
    }

    public function ichkitavarp()
    {
        return $this->belongsTo(Tayyorsqlad::class);
    }
}
