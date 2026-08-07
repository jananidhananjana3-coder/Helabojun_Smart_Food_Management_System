<!DOCTYPE html>
<html>

<head>

<title>Edit Staff</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


<style>

body{
    background:#f5f7fb;
}


.card-box{

    background:white;

    padding:35px;

    border-radius:15px;

    box-shadow:0 5px 15px #ddd;

}


.title{

    color:#075e3b;

    font-weight:bold;

}


.btn-update{

    background:#075e3b;

    color:white;

}


.btn-update:hover{

    background:#0b8050;

    color:white;

}


.profile-img{

    width:120px;

    height:120px;

    border-radius:50%;

    object-fit:cover;

    border:4px solid #075e3b;

}


</style>


</head>



<body>


<div class="container mt-5">


<div class="card-box">


<h2 class="title">

<i class="fa fa-user-edit"></i>

Edit Staff Profile

</h2>


<hr>



<form action="{{ route('users.update',$user->id) }}"
method="POST"
enctype="multipart/form-data">


@csrf

@method('PUT')




<div class="text-center mb-4">


@if($user->profile_image)


<img src="{{asset('storage/'.$user->profile_image)}}"
class="profile-img">


@else


<img src="https://ui-avatars.com/api/?name={{$user->name}}"
class="profile-img">


@endif


</div>





<div class="row">



<div class="col-md-6 mb-3">

<label>Name</label>


<input type="text"
name="name"
class="form-control"
value="{{old('name',$user->name)}}"
required>


</div>




<div class="col-md-6 mb-3">

<label>Email</label>


<input type="email"
name="email"
class="form-control"
value="{{old('email',$user->email)}}"
required>


</div>




<div class="col-md-6 mb-3">

<label>Phone</label>


<input type="text"
name="phone"
class="form-control"
value="{{old('phone',$user->phone)}}">


</div>




<div class="col-md-6 mb-3">

<label>NIC Number</label>


<input type="text"
name="nic_number"
class="form-control"
value="{{old('nic_number',$user->nic_number)}}">


</div>





<div class="col-md-6 mb-3">

<label>Birthday</label>


<input type="date"
name="birthday"
class="form-control"
value="{{ $user->birthday }}">


</div>





<div class="col-md-6 mb-3">

<label>Join Date</label>


<input type="date"
name="join_date"
class="form-control"
value="{{ $user->join_date }}">


</div>





<div class="col-md-12 mb-3">

<label>Address</label>


<textarea name="address"
class="form-control"
rows="3">{{old('address',$user->address)}}</textarea>


</div>





<div class="col-md-6 mb-3">

<label>Role</label>


<select name="role"
class="form-control">


<option value="admin"
{{$user->role=='admin'?'selected':''}}>

Admin

</option>


<option value="manager"
{{$user->role=='manager'?'selected':''}}>

Manager

</option>



<option value="chef"
{{$user->role=='chef'?'selected':''}}>

Chef

</option>



<option value="cashier"
{{$user->role=='cashier'?'selected':''}}>

Cashier

</option>


</select>


</div>





<div class="col-md-6 mb-3">


<label>Change Profile Image</label>


<input type="file"
name="profile_image"
class="form-control">


</div>





<div class="col-md-6 mb-3">

<label>Outlet</label>


<select name="outlet_id"
class="form-control">


<option value="">Select Outlet</option>


@foreach(\App\Models\Outlet::all() as $outlet)


<option value="{{$outlet->id}}"

{{$user->outlet_id==$outlet->id?'selected':''}}>


{{$outlet->name}}


</option>


@endforeach


</select>


</div>





<div class="col-md-6 mb-3">

<label>Counter</label>


<select name="counter_id"
class="form-control">


<option value="">Select Counter</option>


@foreach(\App\Models\Counter::all() as $counter)


<option value="{{$counter->id}}"

{{$user->counter_id==$counter->id?'selected':''}}>


{{$counter->name}}


</option>


@endforeach


</select>


</div>



</div>





<button class="btn btn-update px-4">


<i class="fa fa-save"></i>

Update Staff


</button>



<a href="{{route('users.index')}}"
class="btn btn-secondary">

Back

</a>



</form>


</div>


</div>



</body>

</html>