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
    if ($request->getClientIp() == "127.0.0.1") {
      $visitor = '{"ip": "181.154.103.45","city": "New York","region": "United States","country": "US"}';
    } else {
      $visitor = json_encode($request->ipinfo->all);
    }

    $this->validate($request, [
      'selectedReportType' => 'required|string',
    ]);

    $base_url = UrlShortener::where('short_url', $code)->firstOrFail();

    try {
      $url_report = new UrlReport;
      $url_report->visitor = $visitor;
      $url_report->report_type = $request->input('selectedReportType');
      $url_report->user_id = $base_url->user_id;
      $url_report->url_shortener_id = $base_url->id;
      $url_report->state = 1;

      $url_report->save();

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
  public function redirect(Request $request, $code)
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
