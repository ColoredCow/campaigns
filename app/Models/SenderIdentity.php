<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SenderIdentity extends Model
{
    protected $fillable = ['name', 'email', 'is_default'];

    protected function isDefault(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => boolval($value),
        );
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
