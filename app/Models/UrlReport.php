<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlReport extends Model
{
  protected $fillable = ['visitor', 'report_type', 'user_id', 'url_shortener_id', 'state'];
}
