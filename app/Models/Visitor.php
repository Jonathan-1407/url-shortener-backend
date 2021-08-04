<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
  protected $fillable = ['visitor', 'url_shortener_id'];
}
