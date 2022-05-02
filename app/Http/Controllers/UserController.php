<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     sleep(1);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $a = 2;
        // return $a ?? "null";
        // $users = User::paginate(3)->through(function ($u) {
        //     return ["name" => $u->name];
        // });
        // return $users;
        $users = UserResource::collection(User::when(isset(request()->search), function ($query) {
            $keyword = request("search");
            return $query->where("name", "like", "%$keyword%")->orWhere("email", "like", "%$keyword%");
        })->latest('id')->paginate(7)->onEachSide(2)->withQueryString());  // un wrap data in app service provider 

        // return $users;
        $query = request()->all();
        // return json_encode($users);
        return Inertia::render("user/Index", ["users" => $users, "query" => $query]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("user/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|min:3",
            "email" => "required|email|unique:users,email",
            "photo" => "nullable|mimes:png,jpeg"
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make("password");
        if ($request->hasFile("photo")) {
            $photo = $request->file("photo");
            $photoName = uniqid() . "-photo." . $photo->extension();
            $photo->storeAs("public/photo/", $photoName);
            $user->photo = $photoName;
        }
        $user->save();
        return redirect()->back()->with("status", $user->name . " is created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $user->photo = $user->photo ? asset("storage/photo/" . $user->photo) : asset("image/user-default.jpg");
        return Inertia::render('user/Edit', ["user" => $user]);
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
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->hasFile('photo')) {
            Storage::delete('public/photo/' . $user->photo);
            $photo = $request->file("photo");
            $photoName = uniqid() . "-photo." . $photo->extension();
            $request->file('photo')->storeAs("public/photo/", $photoName);
            $user->photo = $photoName;
        }
        $user->update();
        return redirect()->back()->with("status", "$user->name is updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route("user.index")->with("status", "$user->name is deleted sucessfully");
    }
}
