@extends('layouts.app')

@section('content')
<div class="wrapper">
<div class="main_content">
    <div class="container">
    <br>
    <p class="alert alert-danger">You Must Change Password on First Log in to the System.</p>   
        @if (session('errorz'))
        <br>
        <div class="alert alert-danger" >
          {{ session('errorz') }}
        </div>
        @endif

      @if ($message = Session::get('success'))
      <br>
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
   <form class="form" method="POST" action="/change_password_details_login">
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