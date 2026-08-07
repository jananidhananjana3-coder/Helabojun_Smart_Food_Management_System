<!DOCTYPE html>
<html>

<head>

<title>Admin Dashboard</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<style>


body{

background:#f5f7fb;

}



.sidebar{

width:260px;

height:100vh;

position:fixed;

background:#075e3b;

color:white;

padding:20px;

}



.sidebar a{

display:block;

color:white;

padding:12px;

text-decoration:none;

border-radius:8px;

margin-bottom:5px;

}



.sidebar a:hover{

background:#0b8050;

}



.content{

margin-left:260px;

padding:30px;

}



.card-box{

background:white;

padding:25px;

border-radius:15px;

box-shadow:0 5px 15px #ddd;

}



.icon{

font-size:35px;

color:#075e3b;

}



/* Language Button */


.language-box{

position:fixed;

top:20px;

right:30px;

z-index:1000;

}



.language-btn{

background:#075e3b;

color:white;

border:none;

width:45px;

height:45px;

border-radius:50%;

font-size:20px;

}



.language-menu{

display:none;

position:absolute;

right:0;

top:55px;

background:white;

width:160px;

border-radius:10px;

box-shadow:0 5px 15px #ccc;

overflow:hidden;

}



.language-menu a{

display:block;

padding:12px;

color:#333;

text-decoration:none;

}



.language-menu a:hover{

background:#f1f1f1;

}



.language-box:hover .language-menu{

display:block;

}

.calendar-box{

background:white;

padding:20px;

border-radius:15px;

box-shadow:0 5px 15px #ddd;

}


.calendar-box input{

width:100%;

padding:10px;

border-radius:8px;

border:1px solid #ddd;

}



</style>


</head>



<body>



<!-- Language Selector -->

<div class="language-box">


<button class="language-btn">

<i class="fa fa-globe"></i>

</button>


<div class="language-menu">


<a href="/language/en">

🇬🇧 English

</a>


<a href="/language/si">

🇱🇰 සිංහල

</a>


<a href="/language/ta">

🇮🇳 தமிழ்

</a>


</div>


</div>





<div class="sidebar">


<h3>

<i class="fa fa-leaf"></i>

Hela Bojun

</h3>



<hr>




<a href="/admin-dashboard">

<i class="fa fa-home"></i>

{{ __('messages.dashboard') }}

</a>




<a href="{{ route('users.index') }}">

<i class="fa fa-users"></i>

{{ __('messages.staff_management') }}

</a>





<a href="{{ route('outlets.index') }}">

<i class="fa fa-store"></i>

{{ __('messages.outlets') }}

</a>





<a href="{{ route('foods.index') }}">

<i class="fa fa-utensils"></i>

{{ __('messages.foods') }}

</a>





<a href="#">

<i class="fa fa-box"></i>

{{ __('messages.inventory') }}

</a>





<a href="#">

<i class="fa fa-chart-line"></i>

{{ __('messages.reports') }}

</a>





<form method="POST" action="{{ route('logout') }}">


@csrf


<button class="btn btn-danger w-100 mt-4">


<i class="fa fa-sign-out"></i>


{{ __('messages.logout') }}


</button>
</form>

</div>

<div class="content">



<h2>

{{ __('messages.welcome_admin') }} 👋

</h2>



<p>

{{ __('messages.system_name') }}

</p>




<div class="row mt-4">

<div class="col-md-3">

<div class="card-box">


<i class="fa fa-users icon"></i>


<h6 class="mt-3">

{{ __('messages.total_staff') }}

</h6>


<h2>

{{ $totalStaff }}

</h2>


</div>

</div>





<div class="col-md-3">

<div class="card-box">


<i class="fa fa-shopping-cart icon"></i>


<h6 class="mt-3">

{{ __('messages.today_orders') }}

</h6>


<h2>

{{ $todayOrders }}

</h2>


</div>

</div>





<div class="col-md-3">

<div class="card-box">


<i class="fa fa-money-bill icon"></i>


<h6 class="mt-3">

{{ __('messages.today_sales') }}

</h6>


<h2>

Rs {{ number_format($todaySales,2) }}

</h2>


</div>

</div>






<div class="col-md-3">

<div class="card-box">


<i class="fa fa-store icon"></i>


<h6 class="mt-3">

{{ __('messages.outlets') }}

</h6>


<h2>

{{ $totalOutlets }}

</h2>


</div>

</div>



</div>






<div class="row mt-4">


<div class="col-md-8">


<div class="card-box">


<h4>

{{ __('messages.sales_analysis') }}

</h4>



<canvas id="salesChart"></canvas>


</div>


</div>







<div class="col-md-4">


<div class="card-box">


<h4>

{{ __('messages.order_status') }}

</h4>


<p>

{{ __('messages.pending') }} :

{{ $pendingOrders }}

</p>


<p>

{{ __('messages.completed') }} :

{{ $completedOrders }}

</p>


<p>

{{ __('messages.foods') }} :

{{ $totalFoods }}

</p>


</div>



<br>



<div class="calendar-box">


<h4>

<i class="fa fa-calendar"></i>

{{ __('messages.calendar') }}

</h4>



<input type="date" 
class="form-control"
value="{{ date('Y-m-d') }}">



</div>



</div>



</div>







<div class="card-box mt-4">


<h4>

{{ __('messages.recent_orders') }}

</h4>





<table class="table">


<tr>


<th>

{{ __('messages.order') }}

</th>



<th>

{{ __('messages.amount') }}

</th>



<th>

{{ __('messages.status') }}

</th>


</tr>






@foreach($recentOrders as $order)


<tr>


<td>

#{{ $order->id }}

</td>



<td>

Rs {{ $order->total_amount }}

</td>



<td>

{{ $order->status }}

</td>


</tr>



@endforeach



</table>


</div>






</div>



<script>


new Chart(

document.getElementById('salesChart'),

{


type:'line',


data:{


labels:[

'Mon',

'Tue',

'Wed',

'Thu',

'Fri',

'Sat',

'Sun'

],



datasets:[{


label:'Sales',


data:[

10000,

15000,

12000,

25000,

30000,

20000,

40000

]


}]
}


});


</script>
</body>

</html>