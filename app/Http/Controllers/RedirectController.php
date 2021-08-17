<?php

namespace App\Http\Controllers;

use App\Models\UrlReport;
use App\Models\UrlShortener;
use App\Models\Visitor;
use Exception;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location as Location;

class RedirectController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return View
   */
  public function index()
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
      $visitor = '{"ip":"127.0.0.1","countryName":"United States","countryCode":"US","regionCode":"NY","regionName":"New York","cityName":"Brooklyn","zipCode":"11201","isoCode":null,"postalCode":null,"latitude":"40.694","longitude":"-73.9901","metroCode":null,"areaCode":"NY","driver":false}';
    } else {
      $userIp = $request->ip();
      $locationData = Location::get($userIp);
      $locationData->driver = false;
      $visitor = json_encode($locationData);
    }

    $this->validate($request, [
      'selectedReportType' => 'required|string',
    ]);

    $base_url = UrlShortener::where('short_url', $code)->firstOrFail();

    try {
      $url_report = new UrlReport;
      $url_report->visitor = $visitor;
      $url_report->report_type = $request->input('selectedReportType');
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
    if ($request->getClientIp() == "127.0.0.1") {
      $visitor = '{"ip":"127.0.0.1","countryName":"United States","countryCode":"US","regionCode":"NY","regionName":"New York","cityName":"Brooklyn","zipCode":"11201","isoCode":null,"postalCode":null,"latitude":"40.694","longitude":"-73.9901","metroCode":null,"areaCode":"NY","driver": false}';
    } else {
      $userIp = $request->ip();
      $locationData = Location::get($userIp);
      $locationData->driver = false;
      $visitor = json_encode($locationData);
    }

    $base_url = UrlShortener::where('short_url', $code);
    $exists = $base_url->exists();
    $url = $base_url->first();

    if ($exists) {
      $register_visitor = new Visitor;
      $register_visitor->visitor = $visitor;
      $register_visitor->url_shortener_id = $url->id;
      $register_visitor->save();

      $url->visitors += 1;
      $url->save();
    }

    return view("redirect.index", ['exists' => $exists, 'url' => $url]);
  }
}
