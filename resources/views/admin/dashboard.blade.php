<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - Hela Bojun</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <style>

        *{
            font-family:'Poppins',sans-serif;
        }


        body{

            background:#f4f7f6;
            margin:0;

        }



        /* SIDEBAR */

        .sidebar{

            width:260px;
            height:100vh;

            position:fixed;
            left:0;
            top:0;

            background:#075e3b;

            color:white;

            padding:20px;

        }



        .logo{

            text-align:center;

            margin-bottom:30px;

        }



        .logo img{

            width:95px;
            height:95px;

            object-fit:contain;

            background:white;

            border-radius:50%;

            padding:8px;

        }



        .logo h4{

            margin-top:15px;

            font-weight:600;

        }



        .menu a{

            display:flex;

            align-items:center;

            gap:12px;

            color:white;

            text-decoration:none;

            padding:13px;

            border-radius:10px;

            margin-bottom:8px;

            transition:0.3s;

        }



        .menu a:hover{

            background:#0a7d50;

        }




        .menu i{

            width:20px;

        }





        /* CONTENT */


        .content{

            margin-left:260px;

            padding:25px;

        }



        .topbar{

            background:white;

            border-radius:15px;

            padding:20px;

            display:flex;

            justify-content:space-between;

            align-items:center;

            box-shadow:0 5px 20px rgba(0,0,0,0.08);

        }





        /* CARDS */


        .dashboard-card{

            background:white;

            padding:25px;

            border-radius:15px;

            box-shadow:0 5px 20px rgba(0,0,0,0.08);

            transition:0.3s;

        }



        .dashboard-card:hover{

            transform:translateY(-5px);

        }




        .card-icon{

            font-size:35px;

            color:#075e3b;

        }



        .count{

            font-size:32px;

            font-weight:700;

            color:#075e3b;

        }





        .section{

            background:white;

            padding:25px;

            margin-top:25px;

            border-radius:15px;

            box-shadow:0 5px 20px rgba(0,0,0,0.08);

        }




        .badge-success{

            background:#075e3b;

        }


    </style>


</head>



<body>




<!-- SIDEBAR -->


<div class="sidebar">


    <div class="logo">


        <img src="{{ asset('images/hela-bojun-logo.png') }}" 
             alt="Hela Bojun Logo">


        <h4>
            Hela Bojun
        </h4>


        <small>
            Admin Panel
        </small>


    </div>




    <div class="menu">


        <a href="#">
            <i class="fa fa-home"></i>
            Dashboard
        </a>



        <a href="#">
            <i class="fa fa-users"></i>
            Staff Management
        </a>



        <a href="#">
            <i class="fa fa-utensils"></i>
            Food Management
        </a>




        <a href="#">
            <i class="fa fa-box"></i>
            Inventory
        </a>



        <a href="#">
            <i class="fa fa-store"></i>
            Outlets
        </a>



        <a href="#">
            <i class="fa fa-chart-line"></i>
            Reports
        </a>




        <form method="POST" action="{{ route('logout') }}">


            @csrf


            <button class="btn btn-danger w-100 mt-4">

                <i class="fa fa-sign-out"></i>

                Logout

            </button>


        </form>



    </div>


</div>







<!-- MAIN CONTENT -->


<div class="content">





<div class="topbar">


    <div>

        <h3>
            Welcome Admin 👋
        </h3>


        <p class="text-muted mb-0">

            Hela Bojun Smart Food Management System

        </p>


    </div>



    <div>

        <i class="fa fa-bell fa-2x text-success"></i>

    </div>



</div>







<!-- SUMMARY CARDS -->


<div class="row mt-4">



<div class="col-md-3 mb-3">

<div class="dashboard-card">


<i class="fa fa-users card-icon"></i>


<h6 class="mt-3">
Total Staff
</h6>


<div class="count">
25
</div>


</div>

</div>






<div class="col-md-3 mb-3">


<div class="dashboard-card">


<i class="fa fa-shopping-cart card-icon"></i>


<h6 class="mt-3">
Today's Orders
</h6>


<div class="count">
120
</div>


</div>


</div>








<div class="col-md-3 mb-3">


<div class="dashboard-card">


<i class="fa fa-money-bill-wave card-icon"></i>


<h6 class="mt-3">
Today's Sales
</h6>


<div class="count">
45K
</div>


</div>


</div>






<div class="col-md-3 mb-3">


<div class="dashboard-card">


<i class="fa fa-box-open card-icon"></i>


<h6 class="mt-3">
Low Stock
</h6>


<div class="count">
8
</div>


</div>


</div>



</div>








<!-- STAFF OVERVIEW -->


<div class="section">


<h4>
Staff Overview
</h4>



<div class="row mt-4">


<div class="col-md-4">

<h6>
Cashiers
</h6>

<h3>
5
</h3>

<p>
Active cashier staff
</p>

</div>




<div class="col-md-4">

<h6>
Chefs
</h6>

<h3>
8
</h3>

<p>
Kitchen employees
</p>


</div>





<div class="col-md-4">

<h6>
Managers
</h6>


<h3>
3
</h3>


<p>
Outlet managers
</p>


</div>



</div>


</div>









<!-- REPORTS -->


<div class="section">


<h4>
System Reports
</h4>



<table class="table table-hover mt-3">


<tr>

<th>
Report
</th>

<th>
Status
</th>

</tr>



<tr>

<td>
Daily Sales Report
</td>

<td>
<span class="badge badge-success">
Available
</span>
</td>


</tr>




<tr>

<td>
Inventory Report
</td>

<td>
<span class="badge badge-success">
Available
</span>
</td>


</tr>





<tr>

<td>
Staff Performance Report
</td>

<td>
<span class="badge badge-success">
Available
</span>
</td>


</tr>



</table>



</div>









<!-- RECENT ACTIVITY -->


<div class="section">


<h4>
Recent Activities
</h4>



<ul class="list-group mt-3">


<li class="list-group-item">

<i class="fa fa-plus-circle text-success"></i>

New order created by Cashier

</li>



<li class="list-group-item">

<i class="fa fa-check-circle text-success"></i>

Chef completed kitchen ticket

</li>



<li class="list-group-item">

<i class="fa fa-box text-success"></i>

Inventory updated

</li>



</ul>


</div>


</div>

</body>
</html>