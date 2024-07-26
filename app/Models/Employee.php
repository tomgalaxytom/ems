<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'contact_no',
        'address',
        'register_no',
        'dob'
    ];

    // Define a local scope for whereLike
    public function scopeWhereLike($query, $column, $searchTerm)
    {
        return $query->where($column, 'LIKE', '%' . $searchTerm . '%');
    }
}
