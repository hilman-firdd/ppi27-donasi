<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'category_id', 'target_donation', 'max_date', 'description', 'user_id', 'image'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function donation(){
        return $this->hasMany(Donation::class);
    }

    public function sumDonation(){
        return $this->hasMany(Donation::class)->selectRaw('donations.campaign_id, SUM(donations.amount) as total')->where('donations.status','success')->groupBy('donations.campaign_id');
    }

    public function getImageAttribute($image){
        return asset('storage/campaigns/'. $image);
    }
}
