<!DOCTYPE html>
<html>

<head>

<title>Add Staff</title>

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


.btn-save{

    background:#075e3b;

    color:white;

}


.btn-save:hover{

    background:#0b8050;

    color:white;

}

</style>

</head>


<body>


<div class="container mt-5">


<div class="card-box">


<h2 class="title">

<i class="fa fa-user-plus"></i>

Add Staff

</h2>


<hr>



<form action="{{route('users.store')}}"
method="POST"
enctype="multipart/form-data">


@csrf



<div class="row">


<div class="col-md-6 mb-3">

<label>Name</label>

<input type="text"
name="name"
class="form-control"
required>

</div>




<div class="col-md-6 mb-3">

<label>Email</label>

<input type="email"
name="email"
class="form-control"
required>

</div>



<div class="col-md-6 mb-3">

<label>Password</label>

<input type="password"
name="password"
class="form-control"
required>

</div>



<div class="col-md-6 mb-3">

<label>Phone</label>

<input type="text"
name="phone"
class="form-control">

</div>




<div class="col-md-6 mb-3">

<label>NIC Number</label>

<input type="text"
name="nic_number"
class="form-control">

</div>




<div class="col-md-6 mb-3">

<label>Birthday</label>

<input type="date"
name="birthday"
class="form-control">

</div>




<div class="col-md-12 mb-3">

<label>Address</label>

<textarea name="address"
class="form-control"></textarea>

</div>




<div class="col-md-6 mb-3">

<label>Join Date</label>

<input type="date"
name="join_date"
class="form-control">

</div>




<div class="col-md-6 mb-3">

<label>Role</label>


<select name="role"
class="form-control"
required>


<option value="admin"
@if(request('role')=='admin') selected @endif>

Admin

</option>



<option value="manager"
@if(request('role')=='manager') selected @endif>

Manager

</option>



<option value="chef"
@if(request('role')=='chef') selected @endif>

Chef

</option>



<option value="cashier"
@if(request('role')=='cashier') selected @endif>

Cashier

</option>



</select>


</div>




<div class="col-md-6 mb-3">

<label>Profile Image</label>


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

<option value="{{$outlet->id}}">

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

<option value="{{$counter->id}}">

{{$counter->name}}

</option>

@endforeach


</select>


</div>



</div>



<button class="btn btn-save px-4">

<i class="fa fa-save"></i>

Save Staff

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