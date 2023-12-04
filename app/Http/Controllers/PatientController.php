<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Patient::query()->paginate(20);

        

        if(Gate::Allows('admin-only', auth()->user())){
            return Inertia::render('patients', [
                'data' => $data
            ]);
        }else{
            abort(403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePatientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePatientRequest $request)
    {
        Validator::make($request->all(), [
            'prefix' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'suffix' => 'required',
            'sex' => 'required',
            'birth_date' => 'required',
            'educational_attainment' => 'required',
            'occupation' => 'required',
            'barangay' => 'required',
            'facility_household_no' => 'required',
            'household_no' => 'required',
            'pantawid_member' => 'required',
            'pantawid_member_no' => 'required',
            'family_serial_no' => 'required',
            'philhealth_member' => 'required',
            'philhealth_status' => 'required',
            'philhealth_no' => 'required',
            'philhealth_category' => 'required',
            'pcb_member' => 'required',
        ])->validateWithBag('patient');
        $patient = Patient::make($request->all());
        $patient->user_id = auth()->user()->id;
        $patient->save();
        return redirect()->back()
            ->with('message', 'Patient created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        $patient = Patient::where('user_id', $patient)->firstOrFail();
        return $patient;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePatientRequest  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        Validator::make($request->all(), [
            'prefix' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'suffix' => 'required',
            'sex' => 'required',
            'birth_date' => 'required',
            'educational_attainment' => 'required',
            'occupation' => 'required',
            'barangay' => 'required',
            'dsdw_member' => 'required',
            'facility_household_no' => 'required',
            'household_no' => 'required',
            'pantawid_member' => 'required',
            'pantawid_member_no' => 'required',
            'family_serial_no' => 'required',
            'philhealth_member' => 'required',
            'philhealth_status' => 'required',
            'philhealth_no' => 'required',
            'philhealth_category' => 'required',
            'pcb_member' => 'required',
        ])->validateWithBag('patient');

        $patient->update($request->all());
        $patient->user_id = auth()->user()->id;
        $patient->save();

        return redirect()->back()
            ->with('message', 'Patient updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->back()
            ->with('message', 'Patient deleted');
    }

    public function showPatientDetails($user_id)
    {
        $patient = Patient::firstOrNew([
            'user_id' => $user_id]
        );

        return Inertia::render('patient_details', [
            'patient' => $patient
        ]);
    }

    public function getPatients(){
        $patient = Patient::all();

        return $patient;
    }
    public function getPatientsData($patient){
        $patient = Patient::where('user_id', $patient)->firstOrFail();
        return $patient;
    }
}
