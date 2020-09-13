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
        </ul>
    </div>
<div class="main_content">
    <div class="container">
        <br>
        @if (session('error'))
        <div class="alert alert-danger">
          {{ session('error') }}
        </div>
        @endif

      @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{$message}}</p>
      </div>
    @endif
        <div class="row2 justify-content-center">
  <div class="col-sm-8">

<div class="card">

  <div class="card-header" style="text-align: center;">
    <h4>Change Password</h4>
  </div>
  <div class="card-body">
   <form class="form" method="POST" action="/change_password_details">
          {{ csrf_field() }}

                  <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }} row">
            <label for="new-password" class="col-sm-3 control-label"><strong>Current Password :</strong></label>

            <div class="col-sm-7">
              <input id="current-password" type="password" class="form-control" name="current-password" required>

              @if ($errors->has('current-password'))
              <span class="help-block" style="color: red;">
                <strong>{{ $errors->first('current-password') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }} row">
            <label for="new-password" class="col-sm-3 control-label"><strong>New Password :</strong></label>

            <div class="col-sm-7">
              <input id="new-password" type="password" class="form-control" name="new-password" required>

              @if ($errors->has('new-password'))
              <span class="help-block" style="color: red;">
                <strong>{{ $errors->first('new-password') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group row">
            <label for="new-password-confirm" class="col-sm-3 control-label"><strong>Confirm Password :</strong></label>

            <div class="col-sm-7">
              <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
            </div>
          </div>

           <div class="form-group">
              <center><button type="submit" class="btn btn-primary">Submit</button>
              </center>
          </div>
        </form>
  </div>
</div>
</div>
</div>
    </div>
</div>
</div>
@endsection