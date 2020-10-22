<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Book;
use App\Models\Issue;
use App\Utilities\Mailler;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Controller extends BaseController
{

    public function index()
    {
        return view('frontend.pages.home');
    }

    public function profile()
    {
        return view('frontend.pages.profile');
    }

    public function bookDetail($isbn)
    {
        $book = Book::where('isbn', $isbn)->first();

        if(!$book){
            return abort(404);
        }

        return view('frontend.pages.book_detail')
            ->with('book', $book);
    }

    public function screen()
    {
        return view('frontend.pages.screen');

    }

    public function returnScreen()
    {
        $issues = Issue::all();
        return view('frontend.pages.return_screen')
            ->with('issues',$issues);

    }
}
