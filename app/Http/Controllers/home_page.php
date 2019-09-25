<?php

namespace App\Http\Controllers;


use App\models\friend;
use App\models\like;
use App\models\notification;
use App\models\post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use App\models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class home_page extends Controller
{
    public function logout()
    {

        Cookie::queue(Cookie::forget('signed'));
        return redirect(route('user.login'));
    }

    public function signed()
    {
        if(!array_key_exists ('signed' , $_COOKIE)){
            return redirect()->route('user.login');
        }else{
            $post = DB::table('users as u1')
                ->join('friends', 'u1.username', '=', 'friends.user_id_self')
                ->join('users as u2', 'friends.user_id_friend', '=', 'u2.username')
                ->join('posts', 'u2.username', '=', 'posts.user_username')
                ->select('posts.*')
                ->where('u1.username', $_COOKIE['signed'])
                ->orderBy('id','ASC')
                ->get()
                ->toArray();

            $post = DB::select('select posts.*
                                from users as u1 join friends on u1.username=friends.user_id_self
                                join users as u2 on friends.user_id_friend=u2.username
                                join posts on u2.username = posts.user_username
                                where u1.username = ?
                                order by id ASC',[$_COOKIE['signed']]);
            $show_not = DB::select('select notifications.* , users.profile , datediff(Date(NOW()),not_date) as t
                                 from notifications join users on notifications.from_username = users.username
                                 where to_username = ? AND NOT from_username = ? AND datediff(Date(NOW()),not_date)<25
                                 ORDER by id ASC ', [$_COOKIE['signed'],$_COOKIE['signed']]);
            $red = null;

            foreach($show_not as $n){
                    $red = $red + $n->new;
            }

            $data = [
                'posts' => $post,
                'notification' => $show_not,
                'red' => $red
            ];


            return view('home_page\home')->with('data' , $data);
        }
    }

    public function search()
    {
        $searching_username = request()->input('search_username');
        $p = DB::table('users')->where('username', 'LIKE', '%' . $searching_username . '%');
        $found_users = $p->get()->toArray();
        return view('home_page.search_page')->with('found' , $found_users);
    }

    public function username($username)
    {
        if(array_key_exists ('signed' , $_COOKIE)){
            $user = \App\models\user::where('username' , $username);

            $user_self = \App\models\user::where('username' ,$_COOKIE['signed']);
            $my_follower = $user_self->firstOrFail()->friends->toArray();


            $post = $user->firstOrFail()->posts->toArray();
            $number_of_post = count($post);

            $followers = $user->firstOrFail()->friends2->toArray();
            $number_of_follower = count($followers);

            $following = $user->firstOrFail()->friends->toArray();
            $number_of_following = count($following);

            $data = [
                'user' =>  $user->get()->toArray(),
                'following' => $following,
                'followingNumber' => $number_of_following,
                'follower' => $followers,
                'followerNumber' => $number_of_follower,
                'postNumber' => $number_of_post
            ];
            $find_user_inFolloer = friend::where('user_id_self' , '=' , $_COOKIE['signed'])
                ->where('user_id_friend' , '=' , $username)
                ->get()->toArray();

            if($user->get()->toArray()[0]['private'] ==0 || !empty($find_user_inFolloer) || $username==$_COOKIE['signed']){
                $data['post'] = $post;
            }
            $data['followed']=0;

            $is_requested = notification::where([
                ['from_username', '=', $_COOKIE['signed']],
                ['to_username', '=', $username],
                ['kind' , '=' , 'request']
            ])->get()->toArray();

            if(!empty($is_requested)){
                $data['notification_id'] = $is_requested[0]['id'];
                $data['followed']=2;
            }else{
                foreach($my_follower as $follower){
                    if(in_array($username,$follower)){
                        $data['followed'] = 1;
                    }
                }
            }


            if($username==$_COOKIE['signed']){
                $data['who'] = 1;
            }else{
                $data['who'] = 2;
            }
            return view('users.user_page')->with('data',$data);
        }else{
            return redirect()->route('user.login');
        }


    }

    public function edit($user)
    {



        $user = \App\models\user::where('username' , $user);
        $u  = $user->get()->toArray();
        $uu = $u[0];

        
        if(!array_key_exists ('signed' , $_COOKIE)){
            return redirect()->route('user.login');
        }else{
            return view('users\edit')->with('user',$uu);
        }
    }

    public function delete_profile($username)
    {
        $user = \App\models\user::where('username' , $username);
        $user->update(['profile' => 'anon.jpg']);
        $u  = $user->get()->toArray();
        $uu = $u[0];
        return redirect(route('user.edit',$uu));
    }

    public function change_profile($username)
    {
        if(request()->File('image')){
            $file = request()->File('image');

            $file_end = $file->getClientOriginalExtension();

            $file_name = str_random(45).'.'.$file_end;

            $save = $file->move(storage_path('app\profile'),$file_name);

            $user = \App\models\user::where('username' , $username);

            $user->update(['profile' => $file_name]);
            $u  = $user->get()->toArray();
            $uu = $u[0];
            return redirect(route('username',$uu));
        }else{
            $this->validate(request(),[
                'username' => 'required',
                'password' => 'required'
            ]);
            $private = 0;
            $user = \App\models\user::where('username' , $_COOKIE['signed']);
            if(request()->input('private')=='on'){
                $private = 1;
            }
            $user->update([
                'username' => request()->input('username'),
                'bio' => request()->input('bio'),
                'private' => $private

            ]);
            $u  = $user->get()->toArray();
            $uu = $u[0];
            return redirect(route('username',$uu));
        }

    }

    public function postSending()
    {
        $user = \App\models\user::where('username' , $_COOKIE['signed']);
        $u  = $user->get()->toArray();
        $uu = $u[0];
        
        return view('users.postSending')->with('user',$uu);
    }

    public function uploadingPost()
    {
        $this->validate(request(),[
            'file' => 'required'
        ]);
        $hashtag = null;
        $file = request()->file('file');
        $file_end = $file->getClientOriginalExtension();
        $file_name = str_random(45).'.'.$file_end;
        $save = $file->move(storage_path('app\post'),$file_name);
        $caption = request()->input('caption');
        $words = preg_split( '/('." ".'|'."\n".')/',$caption);
        foreach($words as $word){
            if ((substr($word, 0, 1) === '#')){
                $hashtag[] = $word;
            }
        }

        $pos = [
            'caption' => $caption,
            'media' =>$file_name,
            'user_username' => $_COOKIE['signed'] ,
            'like' => 0,
        ];
        $saved = post::create($pos);
        if($saved instanceof post){
            return redirect()->route('user.home');
        }

    }

    public function showPost($media)
    {
        //dd($media);
        $like = like::where([
            ['username', '=', $_COOKIE['signed']],
            ['media', '=', $media],
        ]);
        $z = $like->get()->toArray();


        $post = \App\models\post::where('media' , $media);
        $u  = $post->get()->toArray();
        $uu = $u[0];
        $user = $post->firstOrFail()->user_username;

        $liked = 0;
        if(!empty($z)){
            $liked=1;
        }




        $data = [
            'post' => $uu,
            'user' => $user,
            'liked' => $liked,
        ];

        return view('users.showPost')->with('data',$data);
    }
}
