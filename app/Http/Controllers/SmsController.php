<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class SmsController extends Controller
{
    public function index()
    {
        return view('sms.messages');
    }

    public function fetchMessage()
    {
        $sms = Sms::all();
        return response()->json([
            'sms'=>$sms,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message'=> 'required',
           
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                
                'errors'=>$validator->messages()
            ]);
        }
        else
        {
            $sms = new Sms;
            $sms->message = $request->input('message');
            
       
         
            $sms->save();
            return response()->json([
                'status'=>200,
                'message'=>'Massege Added Successfully.'
            ]);
        }

    }

    

   

    
}