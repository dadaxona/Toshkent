<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arxivp extends Model
{
    use HasFactory;
    public $fillable = [
        'userp_id',
        'itogs',
        'naqt',
        'plastik',
        'bank',
        'karzs',
    ];
    public $timestamps = true;

    public function userp()
    {
        return $this->belongsTo(Userp::class);
    }
}
