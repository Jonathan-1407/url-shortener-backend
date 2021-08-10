<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class UserController extends Controller
{
  /**
   * Get all users with role administrator.
   *
   * @return Response
   */
  public function users(Request $request)
  {
    $query = $request->q;

    if ($query == "") {
      $users = User::where('id', '!=', Auth::user()->id)->where('is_admin', '!=', 1)->simplePaginate(8);
    } else {
      $users = User::where('id', '!=', Auth::user()->id)->where('is_admin', '!=', 1)->where(
        function ($q) use ($query) {
          $q->where('name', 'like', "%$query%")->where('email', 'like', "%$query%");
        }
      )->simplePaginate(8);
    }

    return response()->json(["users" => $users], 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  Request  $request
   * @return Response
   */
  public function update(Request $request)
  {
    $user_id =  Auth::user()->id;

    $this->validate($request, [
      'name' => 'required|string|min:3|max:255',
      'avatar' => "required|string|max:255",
      'password' => 'confirmed|min:6',
    ]);

    try {
      $user = User::findOrFail($user_id);
      $user->name = $request->input('name');
      $user->avatar = $request->input('avatar');
      if (strlen($request->password) > 0) {
        $plainPassword = $request->input('password');
        $user->password = app('hash')->make($plainPassword);
      }
      $user->save();

      return response()->json(['user' => $user, 'message' => 'User updated!'], 200);
    } catch (Exception $e) {
      return response()->json(['message' => 'User update failed!'], 409);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  $id
   * @return Response
   */
  public function disable($id)
  {
    try {
      $user = User::find($id);
      $user->state = 0;
      $user->save();

      return response()->json(['user' => $user, 'message' => 'User disabled!'], 200);
    } catch (Exception $e) {
      return response()->json(['message' => 'User disable failed!'], 409);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  $id
   * @return Response
   */
  public function enable($id)
  {
    try {
      $user = User::find($id);
      $user->state = 1;
      $user->save();

      return response()->json(['user' => $user, 'message' => 'User enabled!'], 200);
    } catch (Exception $e) {
      return response()->json(['message' => 'User enable failed!'], 409);
    }
  }
}
