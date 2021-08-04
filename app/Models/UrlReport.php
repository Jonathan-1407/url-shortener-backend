<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlReport extends Model
{
  protected $fillable = ['visitor', 'report_type', 'url_shortener_id', 'state'];

  /**
   * Get the url shorten with owner user.
   */
  public function url_shortener()
  {
    return $this->belongsTo(UrlShortener::class)->select('id', 'short_url', 'user_id')->with('user');
  }
}
