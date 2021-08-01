<?php

namespace App\Http\Controllers;

use App\Models\UrlShortener;
use Illuminate\Http\Request;
use Exception;

class RedirectController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index(Request $request)
  {
    return view("home");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  Request  $request
   * @return Response
   */
  public function redirect($code)
  {
    $base_url = UrlShortener::where('short_url', $code);
    $exists = $base_url->exists();
    $url = $base_url->first();

    if ($exists) {
      $url->visitors += 1;
      $url->save();
    }

    return view("redirect.index", ['exists' => $exists, 'url' => $url]);
  }
}
