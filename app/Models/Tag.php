<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
	protected $guarded = [];

	protected $table = 'lists';

	public function subscribers() {
		return $this->belongsToMany(Subscriber::class, 'list_subscriber', 'list_id');
	}
}
