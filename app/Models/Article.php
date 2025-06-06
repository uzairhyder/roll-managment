<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Article extends Model
{
    //
    use HasFactory, Notifiable ,HasRoles;

     protected $fillable = [
         'title',
         'author',
         'text',
     ];
}
