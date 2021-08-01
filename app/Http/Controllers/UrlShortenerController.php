<?php

namespace App\Http\Controllers;

use App\Models\UrlShortener;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

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
         $urls = UrlShortener::where('user_id', Auth::user()->id)->simplePaginate(8);
      } else {
         $urls = UrlShortener::where('user_id', Auth::user()->id)->where('title', 'like', "%$query%")->orWhere('original_url', 'like', "%$query%")->simplePaginate(8);
      }

      return response()->json(["data" => $urls], 200);
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
      $url_shorten = UrlShortener::findOrFail($id);
      $url_shorten->delete();

      return response()->json(['message' => 'Url deleted!'], 200);
   }
}
