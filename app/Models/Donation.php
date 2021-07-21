<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice', 'campaign_id', 'donatur_id', 'amount', 'pray', 'status', 'snap_token'
    ];

    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }

    public function donatur(){
        return $this->belongsTo(Donatur::class);
    }

    public function getCreatedAttribute($date){
        return Carbon::parse($date)->format('d-M-Y');
    }

    public function getUpdatedAttribute($date){
        return Carbon::parse($date)->format('d-M-Y');
    }
}
