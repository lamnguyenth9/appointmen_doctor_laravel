<?php

namespace App\Http\Controllers;

use App\Models\Apointment;
use App\Models\Doctor;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=array();
        $user=Auth::user();
        $doctor=User::where('type','doctor')->get();
        $doctorData=Doctor::all();
        $date=now()->format('n/j/Y');
        $appointments=Apointment::where('status', 'up coming')->where('date',$date)->first();

        foreach($doctorData as $data){
            foreach($doctor as $infor){
                if($data['doc_id']==$infor['id']){
                    $data['doctor_name']=$infor['name'];
                    $data['doctor_profile']=$infor['profile_photo_path'];
                    if(isset($appointments)&& $appointments['doc_id']==$infor['id']){
                        $data['apointments']=$appointments;
                    }
                }
            }
        }
        $user['doctor']=$doctorData;
        return $user;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user=User::where('email',$request->email)->first();

        if(!$user || ! Hash::check($request->password,$user->password)){
            throw ValidationException::withMessages([
                'email'=>['The provided credentials are incorrect'],
            ]);
        }
        return $user->createToken($request->email)->plainTextToken; 
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'type'=>'user',
            'password'=>Hash::make($request->password)
        ]);
        $userInfo=UserDetails::create([
            'user_id'=>$user->id,
            'status'=>'active',

        ]);
        return $user;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
