@extends('layouts.app')

@section('content')
<div class="wrapper">
<div class="sidebar">
        <ul style="list-style-type:none;">

            <?php
            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
            ?>
            
            @if($category=='All')
           <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Insurance only')
          <li><a href="{{ route('home2') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Real Estate only')
          <li><a href="{{ route('home4') }}"><i class="fas fa-home active"></i>Home</a></li>
           @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li><a href="{{ route('home3') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif
          @if(($category=='CPTU only') && (Auth::user()->role=='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li><a href="{{ route('home5') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role=='Accountant-Cost Centre'))
            <li><a href="{{ route('home5') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif

            @if($category=='Real Estate only' OR $category=='All')
            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            @else
            @endif

            @if($category=='Insurance only' OR $category=='All')
            <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
    @else
    @endif
            @if(($category=='CPTU only' OR $category=='All') && (Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
            <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
    @else
    @endif
    @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
    
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>      
    @endif
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>

<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
 @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
  @endif
@admin
            <li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>
<div class="main_content">
    <div class="container">
        <br>
        @if ($message = Session::get('errors'))
          <div class="alert alert-danger">
            <p>{{$message}}</p>
          </div>
        @endif

      @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{$message}}</p>
      </div>
    @endif
        <div class="row justify-content-center">
  <div class="col-sm-8">

<div class="card">

  <div class="card-header" style="text-align: center;">
    <h4>Edit Profile</h4>
  </div>
  <div class="card-body">
    <form  method="get" action="/edit_profile_details" >
        {{csrf_field()}}
      
        <div class="form-group row">
          <div class="col-sm-3"><strong>Name :</strong></div>
          <div class="col-sm-7">
            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}"  readonly>
          </div>
          </div>

          <div class="form-group row">
          <div class="col-sm-3"><strong>Role :</strong></div>
          <div class="col-sm-7">
            <input style="color: black;" readonly="" type="text" class="form-control" id="role" aria-describedby="emailHelp" name="role" placeholder="Enter email address" value="{{ Auth::user()->role }}">
          </div>
          </div>

          <div class="form-group row">
          <div class="col-sm-3"><strong>Email Address :</strong></div>
          <div class="col-sm-7"><input style="color: black;" required type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" onblur="validateEmail(this);" maxlength="25" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" value="{{ Auth::user()->email }}">
          </div>
          </div>

          <div class="form-group row">
          <div class="col-sm-3"><strong>Phone Number :</strong></div>
          <div class="col-sm-7">
            <input style="color: black;" required type="text" name="phoneNumber"
maxlength = "10" minlength = "10"
class="form-control" id="phone" aria-describedby="emailHelp"  placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;" value="{{ Auth::user()->phone_number }}">
          </div>
          </div>

          <input type="text"  name="user_id"  value="{{ Auth::user()->id }}" hidden="">


          <center><div class="form-group">
            <input type="button" class="btn btn-primary" value="Back" onclick="history.back()">
              <button type="submit" class="btn btn-danger">Change</button>
          </div></center>
  </form>
  </div>
</div>
</div>
</div>
    </div>
</div>
</div>
@endsection