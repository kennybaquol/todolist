<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDoList extends Model
{
    use HasFactory;

    // Explicitly set the table name.
    protected $table = 'to_do_lists';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'items',
    ];

    // Default attributes
    protected $attributes = [
        'name' => 'New To-Do List',
        'items' => '[{"value": 0, "checked": false}]',
    ];

    // Casts attributes to the appropriate data type.
    protected $casts = [
        'items' => 'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
