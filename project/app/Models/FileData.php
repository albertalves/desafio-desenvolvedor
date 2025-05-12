<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FileData extends Model
{
    protected $fillable = [
        'rpt_dt',
        'tckr_symb',
        'mkt_nm',
        'scty_ctgy_nm',
        'isin',
        'crpn_mm',
        'file_history_id',
    ];

    public function getRptDtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
