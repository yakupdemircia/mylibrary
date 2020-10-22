<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller as BaseController;

use App\Models\Book;
use App\Models\Issue;
use App\Models\User;
use Auth;

class Controller extends BaseController
{
    function __construct()
    {

    }

    public function index()
    {
        return redirect('/panel/login');
    }

    public function home()
    {
        $books = Book::all()->count();
        $issues = Issue::all()->count();
        $users = User::all()->count();
        $delayed = (new Issue())->delayed();
        return view('panel.home')
            ->with('books',$books)
            ->with('users',$users)
            ->with('issues',$issues)
            ->with('delayed',$delayed);
    }


}
