<?php

namespace App\Http\Controllers;

use App\Models\UrlReport;
use Illuminate\Http\Request;
use Exception;

class ReportController extends Controller
{
  /**
   * Get all reports with role administrator.
   *
   * @return Response
   */
  public function reports(Request $request)
  {
    $query = $request->q;

    if ($query == "") {
      $reports = UrlReport::with('url_shortener')->simplePaginate(8);
    } else {
      $reports = UrlReport::where(
        function ($q) use ($query) {
          $q->where('report_type', 'like', "%$query%");
        }
      )->with(['user', 'url_shortener'])->simplePaginate(8);
    }

    return response()->json(["reports" => $reports], 200);
  }

  /**
   * Hide report.
   *
   * @return Response
   */
  public function hide($id)
  {
    try {
      $report = UrlReport::find($id);
      $report->state = 0;
      $report->save();

      return response()->json(['message' => 'Report hidden!'], 200);
    } catch (Exception $e) {
      return response()->json(['message' => 'Report hide failed!'], 409);
    }
  }
}
