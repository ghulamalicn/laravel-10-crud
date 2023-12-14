<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // Model factories are used for seeding databases with test data,
    use HasFactory; //trait

    // By default, Laravel assumes that the table name is the plural form of the model name (e.g., users for the User
    // if our table name is not exact, then we uses the $table
    protected $table = 'roles';

    //  Mass assignment involves assigning an array of attributes to a model, typically through methods like create or update.
    protected $fillable = [
        'name',
        'description',
    ];

    // relation with users model
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}