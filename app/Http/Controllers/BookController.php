<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Patient;
use App\Models\Consult;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::now()->toDateString();

        $bookNotArrived = Book::query()
        ->with('patients')
        ->where('status','Not Arrived')
        ->whereDate('book_date', $today)
        ->paginate(5);
        $bookWaiting = Book::query()
        ->with('patients')
        ->where('status','Waiting')
        ->whereDate('book_date', $today)
        ->paginate(5);
        $bookConsulting = Book::query()
        ->with('patients')
        ->where('status','Consulting')
        ->whereDate('book_date', $today)
        ->paginate(5);
        $bookFinished = Book::query()
        ->with('patients')
        ->where('status','Finished')
        ->whereDate('book_date', $today)
        ->paginate(5);

        $consult = Consult::all();
              

        if(Gate::Allows('admin-only', auth()->user())){
            return Inertia::render('books', [
                'bookNotArrived' => $bookNotArrived,
                'bookWaiting' => $bookWaiting,
                'bookConsulting' => $bookConsulting,
                'bookFinished' => $bookFinished,
                'consult' => $consult
            ]);
        }else{
            abort(403);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        Validator::make($request->all(), [
            'where' => 'required',
            'book_date' => 'required',
            'purpose' => 'required',
        ])->validate();

        $data = $request->all();
        $data['book_date'] = date('Y-m-d H:i:s', strtotime($data['book_date']));

        $user_id = auth()->user()->id;

        $patient = Patient::whereHas('user', function ($query) use ($user_id) {
            $query->where('id', $user_id);
        })->firstOrFail();

        $book = Book::make($data);
        $book->booked_by = $patient->last_name. ', ' . $patient->first_name;
        $book->user_id = $patient->user_id;
        $book->status = 'Not Arrived';
        $book->save();

        $consult = new Consult();
        $consult->book_id = $book->id;
        $consult->save();

        return redirect()->back()
            ->with('message', 'Booking sent');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        Validator::make($request->all(), [
            'where' => 'required',
            'book_date' => 'required',
            'purpose' => 'required',
        ])->validate();

        $data = $request->all();
        $data['book_date'] = date('Y-m-d H:i:s', strtotime($data['book_date']));

        $book->update($data);

        return redirect()->back()
            ->with('message', 'Book updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->back()
            ->with('message', 'Book deleted');
    }

    public function getBooks() {
        $books = Book::all();
        return $books;
    }

    public function getBooksMonthly() {
        $startDate = Carbon::now()->subDays(30)->startOfDay()->toDateTimeString();
        $endDate = Carbon::now()->endOfDay()->toDateTimeString();

        $books = Book::leftJoin('patients', 'books.user_id', '=', 'patients.user_id')
        ->whereBetween('book_date', [$startDate, $endDate])
        ->get(['books.*', 'patients.barangay as patient_barangay']);
        return $books;
    }

    public function getBooksHistory() {
        $books = Book::all();
        return Inertia::render('books_history', [
            'books' => $books
        ]);
    }

    public function showBookDetails($user_id)
    {
        
        $book = Book::query()->with('patients.user')->where('user_id', $user_id)->paginate(10);
        
        
        return Inertia::render('books_details', [
            'book' => $book
        ]);
    }
}
