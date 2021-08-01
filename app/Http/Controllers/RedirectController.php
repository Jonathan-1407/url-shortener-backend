<?php

namespace App\Http\Controllers;

use App\Models\UrlReport;
use App\Models\UrlShortener;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Redirect;

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
   * Report url.
   *
   * @param  Request  $request
   * @return Response
   */
  public function report(Request $request, $code)
  {
    $this->validate($request, [
      'selectedReportType' => 'required|string',
    ]);

    $base_url = UrlShortener::where('short_url', $code)->firstOrFail();

    try {
      $user = new UrlReport;
      $user->visitor = '[]';
      $user->report_type = $request->input('selectedReportType');
      $user->user_id = $base_url->user_id;
      $user->url_shortener_id = $base_url->id;
      $user->state = 1;

      $user->save();

      return redirect("/");
    } catch (Exception $e) {
      return response()->json(['message' => 'Report registration failed!'], 409);
    }
  }

  /**
   * Redirect visitor to original url.
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
