<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("users/index");
    }

    /**
     * Get users data in json data
     *
     * @return \Illuminate\Http\Response
    */
    public function list(){
        $users = User::with("city");
        return response()->json($users->paginate(3));
    }


    /**
     * Update all edited users in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            DB::transaction(function () use ($request){
                foreach($request->users as $data){
                    $user = User::find($data["id"]);
                    $user->fill($data);
                    $user->update();
                }
            });
            return response()->json([
                "success" => true,
            ]);
        }

        catch(Exception $ex){
            return response()->json([
                "error" => $ex->getMessage(),
            ]);
        }
    }

    /**
     * Remove  specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       return response()->json([
           "success" => User::destroy($id)
       ]);
    }
}