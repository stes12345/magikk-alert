<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeoFence extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_geo_fence';

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function geoFenceTracks()
    {
        return $this->hasMany(GeoFenceTrack::class);
    }
}
