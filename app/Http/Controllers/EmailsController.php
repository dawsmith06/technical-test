<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;

class EmailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("emails/index");
    }

    
    /**
     * Get emails data in json data
     *
     * @return \Illuminate\Http\Response
    */
    public function list(){
        $emails = Email::with("user")->where("user_id",\Auth::id());
        return response()->json($emails->paginate(30));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $email = new Email();
        $email->user_id=\Auth::id();
        $email->fill($request->all());
      
        return response()->json([
            "success" => $email->save(),
        ]);
    }
}