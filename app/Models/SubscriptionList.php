<?php

namespace App\Models;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Model;

class SubscriptionList extends Model {
	protected $guarded = [];

	protected $table = 'lists';

	public function subscribers() {
		return $this->belongsToMany(Subscriber::class, 'list_subscriber', 'list_id');
	}
}
