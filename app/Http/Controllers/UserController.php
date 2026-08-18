<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STAFF LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $admins = User::whereIn('role', ['admin', 'manager'])->get();

        $cashiers = User::where('role', 'cashier')->get();

        $chefs = User::where('role', 'chef')->get();

        return view('admin.staff.index', compact(
            'admins',
            'cashiers',
            'chefs'
        ));
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE STAFF
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        $role = $request->role;

        $outlets = Outlet::orderBy('outlet_name')->get();

        /*
        | Get active counters
        | Counter 1, 2, 3 ... 9 will be available
        */

        $counters = Counter::where('status', 'active')
            ->orderBy('counter_number')
            ->get()
            ->map(function ($counter) {
                return [
                    'id' => $counter->id,
                    'outlet_id' => $counter->outlet_id,
                    'name' => $counter->counter_name,
                    'number' => $counter->counter_number,
                    'status' => $counter->status,
                ];
            })
            ->values()
            ->toArray();

        return view(
            'admin.staff.create',
            compact(
                'role',
                'outlets',
                'counters'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE STAFF
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'name' =>
                'required|string|max:255',

            'email' =>
                'required|email|unique:users,email',

            'password' =>
                'required|min:8',

            'phone' =>
                'nullable|string|max:20',

            'nic_number' =>
                'nullable|string|max:20',

            'birthday' =>
                'nullable|date',

            'address' =>
                'nullable|string',

            'join_date' =>
                'nullable|date',

            'role' =>
                'required|in:admin,manager,chef,cashier',

            'profile_image' =>
                'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'outlet_id' =>
                'nullable|exists:outlets,id',

            'counter_id' =>
                'nullable|exists:counters,id',

            'training_start_date' =>
                'nullable|date',

            'training_end_date' =>
                'nullable|date|after_or_equal:training_start_date',

            'food_specialties' =>
                'nullable|string',
        ]);


        $outletId = null;
        $counterId = null;
        $trainingPeriod = null;
        $foodSpecialties = null;


        /*
        |--------------------------------------------------------------------------
        | CASHIER
        |--------------------------------------------------------------------------
        */

        if ($request->role === 'cashier') {

            $outletId = $request->outlet_id;

            $counterId = null;
        }


        /*
        |--------------------------------------------------------------------------
        | CHEF
        |--------------------------------------------------------------------------
        */

        if ($request->role === 'chef') {

            $outletId = $request->outlet_id;

            $counterId = $request->counter_id;


            /*
            | Make sure counter belongs to selected outlet
            */

            $counterExists = Counter::where('id', $counterId)
                ->where('outlet_id', $outletId)
                ->where('status', 'active')
                ->exists();

            if (!$counterExists) {

                return back()
                    ->withErrors([
                        'counter_id' =>
                            'Selected counter does not belong to the selected outlet.'
                    ])
                    ->withInput();
            }


            /*
            | Training Period
            */

            if (
                $request->training_start_date &&
                $request->training_end_date
            ) {

                $startDate = date(
                    'Y.m.d',
                    strtotime($request->training_start_date)
                );

                $endDate = date(
                    'Y.m.d',
                    strtotime($request->training_end_date)
                );

                $trainingPeriod =
                    $startDate . ' - ' . $endDate;
            }


            $foodSpecialties =
                $request->food_specialties;
        }


        /*
        |--------------------------------------------------------------------------
        | ADMIN / MANAGER
        |--------------------------------------------------------------------------
        */

        if (
            $request->role === 'admin' ||
            $request->role === 'manager'
        ) {

            $outletId = null;

            $counterId = null;

            $trainingPeriod = null;

            $foodSpecialties = null;
        }


        /*
        |--------------------------------------------------------------------------
        | USER DATA
        |--------------------------------------------------------------------------
        */

        $data = [

            'name' =>
                $request->name,

            'email' =>
                $request->email,

            'phone' =>
                $request->phone,

            'nic_number' =>
                $request->nic_number,

            'birthday' =>
                $request->birthday,

            'address' =>
                $request->address,

            'join_date' =>
                $request->join_date,

            'role' =>
                $request->role,

            'outlet_id' =>
                $outletId,

            'counter_id' =>
                $counterId,

            'training_period' =>
                $trainingPeriod,

            'food_specialties' =>
                $foodSpecialties,

            'password' =>
                Hash::make($request->password),

            'verification_code' =>
                null,

            'email_verified_at' =>
                null,
        ];


        /*
        |--------------------------------------------------------------------------
        | PROFILE IMAGE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_image')) {

            $image =
                $request->file('profile_image');

            $imageName =
                time() . '.' .
                $image->getClientOriginalExtension();

            $image->storeAs(
                'profile_images',
                $imageName,
                'public'
            );

            $data['profile_image'] =
                'profile_images/' . $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        User::create($data);


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Staff Added Successfully'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW STAFF
    |--------------------------------------------------------------------------
    */

    public function show(User $user)
    {
        return view(
            'admin.staff.show',
            compact('user')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT STAFF
    |--------------------------------------------------------------------------
    */

    public function edit(User $user)
    {
        $outlets = Outlet::orderBy('outlet_name')->get();

        $counters = Counter::orderBy('counter_number')->get();

        /*
        |--------------------------------------------------------------------------
        | Prepare Counter Data for JavaScript
        |--------------------------------------------------------------------------
        */

        $counterData = $counters->map(function ($counter) {
            return [
                'id' => $counter->id,
                'outlet_id' => $counter->outlet_id,
                'name' => $counter->counter_name,
                'number' => $counter->counter_number,
                'status' => $counter->status,
            ];
        })->values()->toArray();

        return view(
            'admin.staff.edit',
            compact(
                'user',
                'outlets',
                'counters',
                'counterData'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STAFF
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        User $user
    ) {

        $request->validate([

            'name' =>
                'required|string|max:255',

            'email' =>
                'required|email|unique:users,email,' . $user->id,

            'phone' =>
                'nullable|string|max:20',

            'nic_number' =>
                'nullable|string|max:20',

            'birthday' =>
                'nullable|date',

            'address' =>
                'nullable|string',

            'join_date' =>
                'nullable|date',

            'password' =>
                'nullable|min:8',

            'profile_image' =>
                'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'outlet_id' =>
                'nullable|exists:outlets,id',

            'counter_id' =>
                'nullable|exists:counters,id',

            'training_start_date' =>
                'nullable|date',

            'training_end_date' =>
                'nullable|date|after_or_equal:training_start_date',

            'food_specialties' =>
                'nullable|string',

            'role' =>
                'required|in:admin,manager,chef,cashier',
        ]);


        $outletId = null;
        $counterId = null;
        $trainingPeriod = null;
        $foodSpecialties = null;


        /*
        |--------------------------------------------------------------------------
        | CASHIER
        |--------------------------------------------------------------------------
        */

        if ($request->role === 'cashier') {

            $outletId =
                $request->outlet_id;

            $counterId = null;
        }


        /*
        |--------------------------------------------------------------------------
        | CHEF
        |--------------------------------------------------------------------------
        */

        if ($request->role === 'chef') {

            $outletId =
                $request->outlet_id;

            $counterId =
                $request->counter_id;


            /*
            | Validate counter belongs to outlet
            */

            $counterExists = Counter::where('id', $counterId)
                ->where('outlet_id', $outletId)
                ->where('status', 'active')
                ->exists();

            if (!$counterExists) {

                return back()
                    ->withErrors([
                        'counter_id' =>
                            'Selected counter does not belong to the selected outlet.'
                    ])
                    ->withInput();
            }


            /*
            | Training Period
            */

            if (
                $request->training_start_date &&
                $request->training_end_date
            ) {

                $startDate = date(
                    'Y.m.d',
                    strtotime($request->training_start_date)
                );

                $endDate = date(
                    'Y.m.d',
                    strtotime($request->training_end_date)
                );

                $trainingPeriod =
                    $startDate . ' - ' . $endDate;
            } else {

                $trainingPeriod =
                    $user->training_period;
            }


            $foodSpecialties =
                $request->food_specialties;
        }


        /*
        |--------------------------------------------------------------------------
        | ADMIN / MANAGER
        |--------------------------------------------------------------------------
        */

        if (
            $request->role === 'admin' ||
            $request->role === 'manager'
        ) {

            $outletId = null;

            $counterId = null;

            $trainingPeriod = null;

            $foodSpecialties = null;
        }


        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        $data = [

            'name' =>
                $request->name,

            'email' =>
                $request->email,

            'phone' =>
                $request->phone,

            'nic_number' =>
                $request->nic_number,

            'birthday' =>
                $request->birthday,

            'address' =>
                $request->address,

            'join_date' =>
                $request->join_date,

            'role' =>
                $request->role,

            'outlet_id' =>
                $outletId,

            'counter_id' =>
                $counterId,

            'training_period' =>
                $trainingPeriod,

            'food_specialties' =>
                $foodSpecialties,
        ];


        /*
        |--------------------------------------------------------------------------
        | PASSWORD
        |--------------------------------------------------------------------------
        */

        if ($request->filled('password')) {

            $data['password'] =
                Hash::make(
                    $request->password
                );
        }


        /*
        |--------------------------------------------------------------------------
        | PROFILE IMAGE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('profile_image')) {

            if ($user->profile_image) {

                Storage::disk('public')
                    ->delete(
                        $user->profile_image
                    );
            }


            $image =
                $request->file('profile_image');

            $imageName =
                time() . '.' .
                $image->getClientOriginalExtension();

            $image->storeAs(
                'profile_images',
                $imageName,
                'public'
            );

            $data['profile_image'] =
                'profile_images/' . $imageName;
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $user->update($data);


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Staff Updated Successfully'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE STAFF
    |--------------------------------------------------------------------------
    */

    public function destroy(User $user)
    {
        /*
        | Main admin cannot be deleted
        */

        if ($user->email === 'admin@gmail.com') {

            return back()
                ->with(
                    'error',
                    'Main admin account cannot be deleted'
                );
        }


        /*
        | Delete image
        */

        if ($user->profile_image) {

            Storage::disk('public')
                ->delete(
                    $user->profile_image
                );
        }


        /*
        | Delete user
        */

        $user->delete();


        return redirect()
            ->route('users.index')
            ->with(
                'success',
                'Staff Deleted Successfully'
            );
    }
}