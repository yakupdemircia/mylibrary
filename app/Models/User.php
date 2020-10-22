<?php

namespace App\Models;

use App\CustomCasts\UrlCast;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Vkovic\LaravelCustomCasts\HasCustomCasts;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasCustomCasts;
    use Searchable;

    use Searchable;

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'card_id' => $this->card_id,
        ];
    }

    protected $fillable = [
        'id',
        'username',
        'name',
        'image',
        'email',
        'email_verified_at',
        'google_id',
        'facebook_id',
        'password',
        'bio',
        'website',
        'phone',
        'birthday',
        'status',
        'gender',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'image' => UrlCast::class,
    ];

    public function checkUsername($username = null)
    {
        if (is_null($username)) {
            return false;
        }

        return $this->where('id', '<>', $this->id)->where('username', $username)->count() > 0;
    }

    public function searchUser($query,$page,$limit) : array
    {
        $query = convert_search_word_by_word($query);

        $total_count = DB::select("SELECT count(*) as cnt
                            FROM users as u 
                            WHERE u.name REGEXP '$query' OR u.card_id REGEXP '$query'
                            "
        )[0]->cnt;

        $books =  DB::select("SELECT u.*,
                            (SELECT COUNT(*) FROM issues AS i WHERE i.user_id=u.id AND ISNULL(i.return_date)) as books_in_rent,
                            (SELECT COUNT(*) FROM issues AS i WHERE i.user_id=u.id AND ISNULL(i.return_date) and i.penalty > 0) as penalties,
                            (SELECT COUNT(*) FROM issues AS i WHERE i.user_id=u.id AND i.return_date > 0) as delayed_count
                            FROM users as u 
                            WHERE u.name REGEXP '$query' OR u.email REGEXP '$query' OR u.card_id REGEXP '$query'
                            LIMIT {$limit} OFFSET ".$page * $limit
        );

        return array(
            'books' => $books,
            'total_count' => $total_count
        );
    }

   /* public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }*/

}