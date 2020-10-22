<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Book;
use App\Models\Issue;
use App\Models\User;
use Carbon\Carbon;
use Hamcrest\Core\Is;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends BaseController
{

    public function searchBook()
    {

        $query = trim(request()->input('query'));
        $page = request()->input('page');

        if (mb_strlen($query) < 3) {

            return response()->json([
                'result'  => 'error',
                'message' => 'min 3 characters',
            ]);

        }

        $result = (new Book())->searchBook($query,$page,30);

        return response()->json($result);
    }

    public function searchUser()
    {

        $query = trim(request()->input('query'));
        $page = request()->input('page');

        if (mb_strlen($query) < 3) {

            return response()->json([
                'result'  => 'error',
                'message' => 'min 3 characters',
            ]);

        }

        $result = (new User())->searchUser($query,$page,30);

        return response()->json($result);
    }

    public function rentBook()
    {
        $arr = array(
          'book_id' => request()->input('book_id'),
          'user_id' => request()->input('user_id'),
          'start_date' => request()->input('start_date'),
          'end_date' => request()->input('end_date'),
        );

        $book = Book::findOrFail(request()->input('book_id'));

        //books available for rent
        if(($book->stock - $book->in_rent) > 0){

            $issue = Issue::create($arr);

            return response()->json([
                'result'  => 'success',
                'message' => 'Book issued to selected user',
            ]);
        }

        $book->in_rent += 1;
        $book->save();

        return response()->json([
            'result'  => 'error',
            'message' => 'Book is not available',
        ]);

    }

    public function returnBook()
    {
        $book_id = request()->input('book_id');
        $user_id = request()->input('user_id');

        $book = Book::findOrFail($book_id);

        $book->in_rent -= 1;
        $book->save();

        $issue = Issue::where(['book_id' => $book_id,'user_id' => $user_id,'return_date' => null])->first();

        $issue->return_date = date('Y-m-d H:i:s');
        $issue->save();

        return response()->json([
            'result'  => 'success',
            'message' => 'Book returned from user',
        ]);


    }

    public function deleteIssue()
    {
        $id = request()->input('id');
        $book_id = request()->input('book_id');
        $user_id = request()->input('user_id');

        $issue = Issue::where(['id' => $id, 'book_id' => $book_id,'user_id' => $user_id])->first();

        $book = Book::findOrFail($book_id);

        if(!$issue->return_date){
            $book->in_rent -= 1;
            $book->save();
        }

        $issue->delete();

        return response()->json([
            'result'  => 'success',
            'message' => 'Issue deleted successfully',
        ]);


    }

}
