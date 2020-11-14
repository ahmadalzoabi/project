<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\User; // new
use App\Http\Resources\UsersResource; // new
use App\Http\Resources\UserResource; // new
use App\Http\Resources\AuthorPostsResource; // new
use App\Http\Resources\AuthorCommentsResource; // new
use App\Http\Resources\TokenResource; //new
use Illuminate\Support\Facades\Auth; //new
use Illuminate\Support\Facades\Hash; // new
use Illuminate\Support\Facades\Storage; //new

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function index()
    {
        $users = User::paginate(env('AUTHORS_PER_PAGE'));
        return new UsersResource($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $request ->validate([
            'name' => 'required',
            'email'=> 'required',
            'password'=>'required'
        ]);

        $user = new User();
        $user->name = $request -> get('name');
        $user->email = $request -> get('email');
        $user->password = Hash::make($request -> get('password'));
        $user->save();

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        return new UserResource( User::find( $id ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
          $user = User::find($id);
        if ($request->has('name'))
        {
            $user->name = $request->name;

        }
        if ($request->has('password'))
        {
            $user->password = $request->password;
        }
     
        if( $request->hasFile('avatar') ){
            $featuredImage = $request->file( 'avatar' );
            $filename = time().$featuredImage->getClientOriginalName();
            Storage::disk('images')->putFileAs(
                $filename,
                $featuredImage,
                $filename
            );
            $user->avatar = url('/') . '/images/' .$filename;
        }

        $user->save();

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function posts($id)
    {
        $user = User::find($id);
        $posts = $user->posts()->paginate(env('POSTS_PER_PAGE'));
        return new AuthorPostsResource($posts);
    }

    public function comments($id)
    {
        $user = User::find($id);
        $comments = $user->comments()->paginate(env('COMMENTS_PER_PAGE'));
        return new AuthorCommentsResource($comments);
    }


    public function getToken(Request $request)
    {
        $request ->validate([
            'email'=> 'required',
            'password'=>'required'
        ]);

        $credentials = $request-> only('email','password');
        if(Auth::attempt($credentials))
        {
            $user =User::where('email',$request->get('email'))->first();
            return new TokenResource(['token' => $user->api_token]);
        }

            return 'not found';
    }




}
