<?php

namespace App\Models;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Model;

class PendingEmail extends Model
{
    protected $guarded = [];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}
