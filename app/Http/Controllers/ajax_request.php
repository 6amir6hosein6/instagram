<?php

namespace App\Http\Controllers;

use App\models\friend;
use App\models\notification;
use App\models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;

class ajax_request extends Controller
{
    public function follow($user)
    {
        $user_private = user::where('username' , $user)->get()->toArray()[0]['private'];

        if($user_private){

            $mytime = Carbon::now();
            $notification = [
                'from_username' => $_COOKIE['signed'],
                'to_username' => $user,
                'kind' => 'request',
                'new' => 1,
                'not_date' => $mytime->toDateString()
            ];

            notification::create($notification);
            return 'asked';
        }else {
            $friend_ship = [
                'user_id_self' => $_COOKIE['signed'],
                'user_id_friend' => $user
            ];

            $c = \App\models\friend::create($friend_ship);
            if ($c instanceof \App\models\friend) {

                $mytime = Carbon::now();

                $notification = [
                    'from_username' => $_COOKIE['signed'],
                    'to_username' => $user,
                    'kind' => 'follow',
                    'new' => 1,
                    'not_date' => $mytime->toDateString()
                ];
                notification::create($notification);
                return 'added';
            }
        }
    }

    public function unfollow($user)
    {
        $delete = \App\models\friend::where([
            ['user_id_self', '=', $_COOKIE['signed']],
            ['user_id_friend', '=', $user]
        ])->firstOrFail();
        $delete->delete();
        return 'delete';

    }

    public function like($post)
    {
        $p = \App\models\post::where('media' , $post);
        $like = $p->get()->toArray()[0]['like'];
        $user = $p->get()->toArray()[0]['user_username'];
        $like++;
        $p->update(['like' => $like]);
        $l = [
            'username' =>$_COOKIE['signed'],
            'media' => $post
        ];
        \App\models\like::create($l);

        $kind = 'like:'.$post;
        $mytime = Carbon::now();
        $notification = [
            'from_username' => $_COOKIE['signed'],
            'to_username' => $user,
            'kind' => $kind,
            'new' => 1,
            'not_date' => $mytime->toDateString()
        ];
        notification::create($notification);
        return 'liked';
    }

    public function unlike($post)
    {
        $p = \App\models\post::where('media' , $post);
        $like = $p->get()->toArray()[0]['like'];
        $like--;
        $p->update(['like' => $like]);

        $delete = \App\models\like::where([
            ['username', '=', $_COOKIE['signed']],
            ['media', '=', $post],
        ])->firstOrFail();
        $delete->delete();
        return 'unliked';
    }

    public function like_id($post)
    {
        $p = \App\models\post::where('id' , $post);
        $like = $p->get()->toArray()[0]['like'];
        $user = $p->get()->toArray()[0]['user_username'];
        $media = $p->get()->toArray()[0]['media'];
        $like++;
        $p->update(['like' => $like]);
        $l = [
            'username' =>$_COOKIE['signed'],
            'media' => $media
        ];

        $kind = 'like:'.$media;
        \App\models\like::create($l);

        $mytime = Carbon::now();
        $notification = [
            'from_username' => $_COOKIE['signed'],
            'to_username' => $user,
            'kind' => $kind,
            'new' => 1,
            'not_date' => $mytime->toDateString()
        ];
        notification::create($notification);
        return 'liked';
    }

    public function unlike_id($post)
    {
        $p = \App\models\post::where('id' , $post);
        $like = $p->get()->toArray()[0]['like'];
        $media = $p->get()->toArray()[0]['media'];
        $like--;
        $p->update(['like' => $like]);

        $delete = \App\models\like::where([
            ['username', '=', $_COOKIE['signed']],
            ['media', '=', $media],
        ])->firstOrFail();
        $delete->delete();
        return 'unliked';
    }

    public function seen()
    {
        $not = notification::where('to_username',$_COOKIE['signed']);
        $not->update(['new'=>0]);
        return 'did it';
    }

    public function ask_follow_request_no($not_id)
    {
        $delete = \App\models\notification::where('id',$not_id)->firstOrFail();
        $delete->delete();
        return 'reject';
    }
    public function ask_follow_request_yes($not_id)
    {
        $delete = \App\models\notification::where('id',$not_id);
        $friend = $delete->get()->toArray()[0]['from_username'];
        $adding_friend = [
            'user_id_self' => $friend,
            'user_id_friend' => $_COOKIE['signed']
        ];
        friend::create($adding_friend);
        $delete->firstOrFail()->delete();
        return 'accept';

    }

    public function getFollowRequestBack($username)
    {
        $delete = notification::where([
            ['from_username', '=', $_COOKIE['signed']],
            ['to_username', '=', $username]
        ])->firstOrFail();
        $delete->delete();
        return 'back';
    }
    public function getSuggest($suggest)
    {

        $user = DB:: table('friends')
            ->select('friends.user_id_friend', DB::raw('COUNT(users.username) AS leadsCount'))
            ->join('users', 'users.username', '=', 'friends.user_id_self')
            ->groupBy('friends.user_id_friend')
            ->having('friends.user_id_friend', 'LIKE', '%' . $suggest . '%')
            ->orderBy('leadsCount' , 'DESC')
            ->limit(5)
            ->get()
            ->toArray();


       //dd($user[0]->user_id_friend);

        foreach($user as $u){
            $each = user::where('username',$u->user_id_friend)->get()->toArray();
            $each_user[] = [
                'username' => $u->user_id_friend,
                'profile' => $each[0]['profile']];
        }



//        dd($u->get()->toArray());
        $json = json_encode($each_user);

        echo $json;
    }
}
