<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlShortener extends Model
{
  protected $fillable = ['title', 'original_url', 'short_url', 'visitors', 'user_id'];

  /**
   * Get the user that owns the url.
   */
  public function user()
  {
    return $this->belongsTo(User::class)->select('id', 'name', 'state');
  }
}
