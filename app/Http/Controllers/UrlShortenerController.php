<?php

namespace App\Http\Controllers;

use App\Models\UrlShortener;
use App\Models\Visitor;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UrlShortenerController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function index(Request $request)
   {
      $query = $request->q;

      if ($query == "") {
         $urls = UrlShortener::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(6);
      } else {
         $urls = UrlShortener::where('user_id', Auth::user()->id)->where(function ($q) use ($query) {
            $q->where('title', 'like', "%$query%")->orWhere('original_url', 'like', "%$query%");
         })->paginate(6);
      }

      return response()->json(
         [
            'pagination' => [
               'total' => $urls->total(),
               'current_page' => $urls->currentpage(),
               'per_page' => $urls->perpage(),
               'last_page' => $urls->lastpage(),
               'from' => $urls->firstitem(),
               'to' => $urls->lastitem(),
            ], "urls" => $urls->forget('pagination')
         ],
         200
      );
   }

   /**
    * Display a listing of the resource.
    *
    * @return Response
    */
   public function visitors($id)
   {
      $visitors = Visitor::where('url_shortener_id', $id)->orderBy('created_at', 'DESC')->paginate(4);

      return response()->json(
         [
            'pagination' => [
               'total' => $visitors->total(),
               'current_page' => $visitors->currentpage(),
               'per_page' => $visitors->perpage(),
               'last_page' => $visitors->lastpage(),
               'from' => $visitors->firstitem(),
               'to' => $visitors->lastitem(),
            ], "visitors" => $visitors->forget('pagination')
         ],
         200
      );
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  Request  $request
    * @return Response
    */
   public function store(Request $request)
   {
      $this->validate($request, [
         'title' => 'string|min:3|max:255',
         'original_url' => 'required|string|min:6',
         'short_url' => 'required|min:4|max:50|unique:url_shorteners',
      ]);

      try {
         $url_shorten = new UrlShortener;
         $url_shorten->title = $request->input('title');
         $url_shorten->original_url = $request->input('original_url');
         $url_shorten->short_url = $request->input('short_url');
         $url_shorten->visitors = 0;
         $url_shorten->user_id = Auth::user()->id;
         $url_shorten->save();

         return response()->json(['url_shorten' => $url_shorten, 'message' => 'Url short created!'], 201);
      } catch (Exception $e) {
         return response()->json(['message' => 'Url registration failed!'], 409);
      }
   }


   /**
    * Update the specified resource in storage.
    *
    * @param  Request  $request
    * @param  int  $id
    * @return Response
    */
   public function update(Request $request, $id)
   {
      $this->validate($request, [
         'title' => 'string|min:3|max:255',
         'original_url' => 'required|string|min:6',
         'short_url' => "required|min:4|max:50|unique:url_shorteners,id,$id",
      ]);

      try {
         $url_shorten = UrlShortener::findOrFail($id);
         $url_shorten->title = $request->input('title');
         $url_shorten->original_url = $request->input('original_url');
         $url_shorten->short_url = $request->input('short_url');
         $url_shorten->save();

         return response()->json(['url_shorten' => $url_shorten, 'message' => 'Url short updated!'], 200);
      } catch (Exception $e) {
         return response()->json(['message' => 'Url update failed!'], 409);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
   public function destroy($id)
   {
      try {
         $url_shorten = UrlShortener::findOrFail($id);
         $url_shorten->delete();

         return response()->json(['message' => 'Url deleted!'], 200);
      } catch (Exception $e) {
         return response()->json(['message' => 'Url delete failed!'], 409);
      }
   }

   /**
    * Get the specified data from visitors.
    *
    * @param  int  $id
    * @return Response
    */
   public function chart($id)
   {
      try {
         $chart = Visitor::selectRaw('DATE(created_at) as date, COUNT(*) as visitors')
            ->groupBy('date')
            ->where('created_at', '>', Carbon::now()->subWeek())
            ->where('url_shortener_id', $id)
            ->get();

         return response()->json(['dates' => $chart->pluck('date'), 'visitors' => $chart->pluck('visitors')], 200);
      } catch (Exception $e) {
         return response()->json(['message' => 'Generate data chart failed!'], 409);
      }
   }
}
