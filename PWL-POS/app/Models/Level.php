<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $table = 'm_level';
    protected $primaryKey = 'level_id';
    protected $fillable = ['level_kode', 'level_nama'];

    // Relationship One to Many ke UserModel
    public function users(): HasMany
    {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }
}
