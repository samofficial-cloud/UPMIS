@extends('layouts.app')

@section('content')
<div class="wrapper">
<div class="sidebar">
        <ul style="list-style-type:none;">

            <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>
            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
            <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>

          <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>


            <li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>

            @admin
            <li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin

        </ul>
    </div>
<div class="main_content">
<div class="flex-container">
<div style="flex-grow: 1" class="card shadow-sm p-10 mb-10 bg-white  flex_container_div">
<div class="flex_container_inside">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100 h-75" src="/images/mcity_1.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 h-75" src="/images/mcity_2.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 h-75" src="/images/mcity_3.jpg" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  </div>
</div>
<br>
<div class="card-deck">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title"><i class="fas fa-bullhorn blink" style="font-size:24px;"></i> Announcements</h4>
      <ul class="list-group list-group-flush">
    <li class="list-group-item"> Call for Tender Application</li>
    <li class="list-group-item">University of Dar es salaam Insurance Agency</li>
    <li class="list-group-item">Elimika kuhusu ugonjwa wa homa kali ya mapafu unaosababishwa na virusi vya CORONA</li>
  </ul>
    </div>
    </div>
    <div class="card">
    <div class="card-body">
      <h4 class="card-title"><i class="fas fa-external-link-alt"></i> Quick Links</h4>
      <ul class="list-group list-group-flush">
    <li class="list-group-item"><a href="#">VoteBook</a></li>
    <li class="list-group-item"><a href="#">UDSM Site</a></li>
    <li class="list-group-item"><a href="#">Aris</a></li>
  </ul>
    </div>
  </div>
  </div>
</div>
</div>
</div>
@endsection

@section('pagescript')


  <script>

    setInterval(function () {

      $.ajax({
        url : '{{ route("create_space_invoice")}}',
        type : "GET",
        success : function(data){

          console.log(data);

        },
        error : function(data) {

        }
      });

    }, 10000000);


  </script>


@endsection
