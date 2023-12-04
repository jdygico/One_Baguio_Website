<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Patient;
use App\Models\Consult;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConsultRequest;
use App\Http\Requests\UpdateConsultRequest;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ConsultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $book = Book::query()->with('patients')->paginate(20);
        $consult = Consult::query()->get();
              

        if(Gate::Allows('admin-only', auth()->user())){
            return Inertia::render('consults', [
                'book' => $book,
                'consult' => $consult
            ]);
        }else{
            abort(403);
        }
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
    public function store(StoreConsultRequest $request)
    {
//
    }

    /**
     * Display the specified resource.
     */
    public function show($consult)
    {
        $consult = Consult::where('book_id', $consult)->firstOrFail();
        return $consult;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consult $consult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConsultRequest $request, Consult $consult)
    {
        $data = $request->all();
        $data['consult_datetime'] = date('Y-m-d H:i:s', strtotime($data['consult_datetime']));

        // $id = auth()->user()->id;

        // $book = Book::whereHas('user', function ($query) use ($id) {
        //     $query->where('id', $id);
        // })->firstOrFail();


        $consult->update($data);
        $consult->name_of_attending_provider = auth()->user()->name;
        $consult->save();
        return redirect()->back()
            ->with('message', 'Consultation Form submitted');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consult $consult)
    {
        //
    }

    public function getConsult($book_id){
        $consult = Consult::all();

        return $consult;
    }

    public function getConsults(){
        $consults = Consult::all();

        return $consults;
    }

    public function getConsultsMonthly() {
        $startDate = Carbon::now()->subDays(30)->startOfDay()->toDateTimeString();
        $endDate = Carbon::now()->endOfDay()->toDateTimeString();

        $consults = Consult::whereBetween('consult_datetime', [$startDate, $endDate])->get();
        return $consults;
    }
}
