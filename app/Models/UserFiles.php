<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;

class UserFiles extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'path',
        'extension',
        'mime_type',
        'size',
        'download'
    ];

    /**
     * Boot function for using with User Files
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model)
        {
            $model->uuid = Str::uuid()->toString();
        });
    }
    
    public function getRouteKeyName()
    {
        return  'uuid';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
