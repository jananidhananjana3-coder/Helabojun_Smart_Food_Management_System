<!DOCTYPE html>
<html>

<head>

<title>Hela Bojun Queue Display</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<style>

body{

background:#075e3b;

color:white;

}


.title{

text-align:center;
padding:30px;

}


.token-card{

background:white;
color:#075e3b;

border-radius:20px;

padding:25px;

text-align:center;

box-shadow:0 5px 15px #333;

}


.token{

font-size:60px;

font-weight:700;

}



</style>


</head>


<body>


<div class="title">

<h1>
🍛 Hela Bojun
</h1>

<h2>
Order Ready
</h2>

</div>



<div class="container">


<div class="row justify-content-center">


@foreach($readyOrders as $order)


<div class="col-md-3 mb-4">


<div class="token-card">


<h5>
TOKEN
</h5>


<div class="token">

{{$order->token_number}}

</div>



<h4>

READY

</h4>



@if($order->counter)

<p>

Counter :
{{$order->counter->counter_name}}

</p>

@endif



</div>


</div>


@endforeach


</div>


</div>


</body>


</html>