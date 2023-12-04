<?php

namespace App\Http\Controllers;

use App\Models\facility;
use App\Http\Requests\StorefacilityRequest;
use App\Http\Requests\UpdatefacilityRequest;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = facility::query()->paginate(20);

        return Inertia::render('facilities', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorefacilityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorefacilityRequest $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'type' => 'required',
            'services' => 'required',
        ])->validate();

        facility::create($request->all());

        return redirect()->back()
            ->with('message', 'Facility created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function show(facility $facility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function edit(facility $facility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatefacilityRequest  $request
     * @param  \App\Models\facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatefacilityRequest $request, facility $facility)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'type' => 'required',
            'services' => 'required',
        ])->validate();

        $facility->update($request->all());

        return redirect()->back()
            ->with('message', 'Facility updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\facility  $facility
     * @return \Illuminate\Http\Response
     */
    public function destroy(facility $facility)
    {
        $facility->delete();
        return redirect()->back()
            ->with('message', 'Patient deleted');
    }

    public function getFacilities(){
        $facilities = facility::all();

        return $facilities;
    }
}
