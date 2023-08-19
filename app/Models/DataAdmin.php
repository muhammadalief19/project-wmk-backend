<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class DataAdmin extends Model
{
    use HasFactory;

    public $table = "data_admin";

    protected $guarded = [
        'id'
    ];

    // automatic generated uuid
    protected static function boot() {
        parent::boot();

        static::creating(function($model) {
            if($model->getKey() == null) {
                $model->setAttribute('uuid', Str::uuid()->toString());
            }
        });
    }

    // Get the user that own the data admin.
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
