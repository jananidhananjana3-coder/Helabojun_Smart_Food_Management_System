<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{


    public function index()
    {

        $admins = User::where('role','admin')->get();

        $cashiers = User::where('role','cashier')->get();

        $chefs = User::where('role','chef')->get();


        return view('admin.staff.index',
        compact(
            'admins',
            'cashiers',
            'chefs'
        ));

    }




    public function create(Request $request)
    {

        $role = $request->role;


        return view('admin.staff.create',
        compact('role'));

    }




    public function store(Request $request)
    {


        $request->validate([

            'name'=>'required',

            'email'=>'required|email|unique:users',

            'password'=>'required|min:8',

            'role'=>'required',

            'profile_image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'

        ]);



        $data = [

            'name'=>$request->name,

            'email'=>$request->email,

            'phone'=>$request->phone,

            'nic_number'=>$request->nic_number,

            'birthday'=>$request->birthday,

            'address'=>$request->address,

            'join_date'=>$request->join_date,

            'role'=>$request->role,

            'outlet_id'=>$request->outlet_id,

            'counter_id'=>$request->counter_id,

            'password'=>Hash::make($request->password)

        ];



        if($request->hasFile('profile_image')){


            $image = $request->file('profile_image');


            $imageName = time().'.'.$image->getClientOriginalExtension();


            $image->storeAs(
                'profile_images',
                $imageName,
                'public'
            );


            $data['profile_image'] =
            'profile_images/'.$imageName;

        }



        $user = User::create($data);

        dd($user);



        return redirect()
        ->route('users.index')
        ->with('success','Staff Added Successfully');


    }

    public function show(User $user)
    {


        return view('admin.staff.show',
        compact('user'));


    }







    public function edit(User $user)
    {


        return view('admin.staff.edit',
        compact('user'));


    }







    public function update(Request $request, User $user)
    {


        $request->validate([


            'name'=>'required',

            'email'=>'required|email|unique:users,email,'.$user->id,

            'profile_image'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'


        ]);



        $data = [


            'name'=>$request->name,

            'email'=>$request->email,

            'phone'=>$request->phone,

            'nic_number'=>$request->nic_number,

            'birthday'=>$request->birthday,

            'address'=>$request->address,

            'join_date'=>$request->join_date,

            'role'=>$request->role,

            'outlet_id'=>$request->outlet_id,

            'counter_id'=>$request->counter_id


        ];




        if($request->hasFile('profile_image')){


            if($user->profile_image){

                Storage::disk('public')
                ->delete($user->profile_image);

            }



            $image = $request->file('profile_image');


            $imageName = time().'.'.$image->getClientOriginalExtension();



            $image->storeAs(
                'profile_images',
                $imageName,
                'public'
            );



            $data['profile_image'] =
            'profile_images/'.$imageName;


        }





        if($request->password){


            $data['password'] =
            Hash::make($request->password);


        }





        $user->update($data);



        return redirect()
        ->route('users.index')
        ->with('success','Staff Updated Successfully');


    }


    public function destroy(User $user)
{

    if($user->email == 'admin@gmail.com'){

        return back()
        ->with('error',
        'Main admin account cannot be deleted');

    }


    if($user->profile_image){

        Storage::disk('public')
        ->delete($user->profile_image);

    }


    $user->delete();


    return redirect()
    ->route('users.index')
    ->with('success','Staff Deleted Successfully');

}


}