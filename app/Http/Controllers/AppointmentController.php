<?php

namespace App\Http\Controllers;

use App\Models\Apointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointment=Apointment::where('user_id',Auth::user()->id)->get();
        $doctor=User::where('type','doctor')->get();

        foreach($appointment as $data){
            foreach($doctor as $infor){
                $details=$infor->doctor;
                if($data['doc_id']==$infor['id']){
                    $data['doctor_name']=$infor['name'];
                    $data['doctor_profile']=$infor['profile_photo_path'];
                    $data['category']=$details['category'];
                }
            }
        }
        return $appointment;
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
        $appointment= new Apointment();
        $appointment->user_id=Auth::user()->id;
        $appointment->doc_id=$request->get('doctor_id');
        $appointment->date=$request->get('date');
        $appointment->day=$request->get('day');
        $appointment->time=$request->get('time');
        $appointment->status='up coming';
        $appointment->save();
        return response()->json([
            'success'=>'New Appointment has been made succellfully',

        ],200);
        
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
