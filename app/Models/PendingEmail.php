<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Campaign;
use App\Models\Subscriber;

class PendingEmail extends Model
{
    protected $guarded = [];

    public $subscriber;

    public $campaign;

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}
