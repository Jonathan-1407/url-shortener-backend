<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlShortener extends Model
{
  protected $fillable = ['title', 'original_url', 'short_url', 'visitors', 'user_id'];
}
