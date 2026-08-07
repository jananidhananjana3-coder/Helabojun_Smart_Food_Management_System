<!DOCTYPE html>
<html>

<head>

<title>Staff Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


<style>


body{

    background:#f5f7fb;

}


.profile-card{

    background:white;

    border-radius:20px;

    padding:30px;

    box-shadow:0 5px 20px #ddd;

}


.profile-image{

    width:160px;

    height:160px;

    border-radius:50%;

    object-fit:cover;

    border:5px solid #075e3b;

}


.title{

    color:#075e3b;

    font-weight:bold;

}


.info-box{

    background:#f8f9fa;

    padding:15px;

    border-radius:10px;

    margin-bottom:15px;

}


.icon{

    color:#075e3b;

    width:25px;

}


.btn-back{

    background:#075e3b;

    color:white;

}


.btn-back:hover{

    background:#064b30;

    color:white;

}


</style>


</head>


<body>


<div class="container mt-5">


<div class="profile-card">


<div class="text-center">


@if($user->profile_image)


<img src="{{ asset('storage/'.$user->profile_image) }}" 
class="profile-image">


@else


<img src="https://via.placeholder.com/160"
class="profile-image">


@endif



<h2 class="mt-3 title">

{{ $user->name }}

</h2>


<span class="badge bg-success">

{{ ucfirst($user->role) }}

</span>


</div>



<hr>


<div class="row mt-4">


<div class="col-md-6">


<div class="info-box">

<i class="fa fa-envelope icon"></i>

<strong>Email:</strong>

<br>

{{ $user->email }}

</div>



<div class="info-box">

<i class="fa fa-phone icon"></i>

<strong>Phone:</strong>

<br>

{{ $user->phone ?? 'N/A' }}

</div>




<div class="info-box">

<i class="fa fa-id-card icon"></i>

<strong>NIC Number:</strong>

<br>

{{ $user->nic_number ?? 'N/A' }}

</div>




<div class="info-box">

<i class="fa fa-calendar icon"></i>

<strong>Birthday:</strong>

<br>

{{ $user->birthday ?? 'N/A' }}

</div>



</div>





<div class="col-md-6">


<div class="info-box">

<i class="fa fa-location-dot icon"></i>

<strong>Address:</strong>

<br>

{{ $user->address ?? 'N/A' }}

</div>




<div class="info-box">

<i class="fa fa-calendar-check icon"></i>

<strong>Join Date:</strong>

<br>

{{ $user->join_date ?? 'N/A' }}

</div>





<div class="info-box">

<i class="fa fa-store icon"></i>

<strong>Outlet:</strong>

<br>

{{ $user->outlet_id ?? 'N/A' }}

</div>





<div class="info-box">

<i class="fa fa-desktop icon"></i>

<strong>Counter:</strong>

<br>

{{ $user->counter_id ?? 'N/A' }}

</div>


</div>



</div>



<div class="text-center mt-4">


<a href="{{ route('users.index') }}" 
class="btn btn-back px-5">

<i class="fa fa-arrow-left"></i>

Back

</a>


</div>



</div>


</div>


</body>

</html>