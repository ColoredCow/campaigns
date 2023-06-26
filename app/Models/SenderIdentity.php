<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SenderIdentity extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'is_default'];

    protected function setIsDefaultAttribute($value)
    {
        $this->attributes['is_default'] = boolval($value);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function removeAsDefault()
    {
        return $this->update(['is_default' => false]);
    }
}
