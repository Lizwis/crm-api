<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ['created_at_formatted'];

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function createdAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at?->format('Y-m-d'),
        );
    }
}
