@extends('layouts.app')

@section('style')
<style type="text/css">
  .signature-pad {
 /* position: absolute;
  left: 0;
  top: 0;*/
  width:400px;
  height:200px;
  background-color: white;
}
</style>
@endsection

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
          @elseif($category=='Research Flats only')
          <li><a href="{{ route('home6') }}"><i class="fas fa-home active"></i>Home</a></li>
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

            @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

                <li><a href="/businesses"><i class="fa fa-building" aria-hidden="true"></i> Businesses</a></li>
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
            <li><a href="/user_role_management"><i class="fas fa-user-friends hvr-icon" aria-hidden="true"></i>Manage Users</a></li>
<li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>
<div class="main_content">
    <div class="container">
        <br>
        @if ($message = Session::get('errors'))
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p>{{$message}}</p>
          </div>
        @endif

      @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
    <form  method="get" action="{{ route('save_editprofile') }}" onsubmit="return savesignature()" >
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
          <div class="col-sm-3"><strong>Email Address<span style="color: red;"> *</span></strong></div>
          <div class="col-sm-7"><input style="color: black;" required type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" onblur="validateEmail(this);" maxlength="25" class="form-control" id="email" aria-describedby="emailHelp" name="email" placeholder="Enter email address" value="{{ Auth::user()->email }}">
          </div>
          </div>


          <div class="form-group row">
          <div class="col-sm-3"><strong>Phone Number<span style="color: red;"> *</span></strong></div>
          <div class="col-sm-7">
            <input style="color: black;" required type="text" name="phoneNumber"
maxlength = "10" minlength = "10"
class="form-control" id="phone" aria-describedby="emailHelp"  placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;" value="{{ Auth::user()->phone_number }}">
          </div>
          </div>



      <div class="form-group row">
        <div class="col-sm-3"><strong>Signature<span style="color: red;"> *</span></strong></div>
          <div class="col-sm-7">
          <canvas id="signature-pad" class="signature-pad" style="border:1px #000 solid; " width=400 height=200></canvas>
          <center><button id="clear" type="button" class="btn btn-danger">Erase Signature</button></center>
        </div>
      </div>


          <input type="text"  name="user_id" id="user_id" value="{{ Auth::user()->id }}" hidden="">


          <div class="form-group" align="right">
            <input type="button" class="btn btn-primary" value="Back" onclick="history.back()">
            <button type="submit" class="btn btn-danger">Change</button>
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

@section('pagescript')
{{-- <script src="https://szimek.github.io/signature_pad/js/signature_pad.umd.js"></script> --}}
<script src="{{ asset('js/signature_pad.umd.js') }}" ></script>
<script type="text/javascript">
  var canvas = document.getElementById('signature-pad');
  function resizeCanvas() {
    // When zoomed out to less than 100%, for some very strange reason,
    // some browsers report devicePixelRatio as less than 1
    // and only part of the canvas is cleared then.
    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

var signaturePad = new SignaturePad(canvas, {
  backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
});


document.getElementById('clear').addEventListener('click', function () {
  signaturePad.clear();
});

function savesignature(){

  if (signaturePad.isEmpty()) {
     alert("Please provide a signature first.");
    return false;
  }else{

      var data = signaturePad.toDataURL('image/jpeg');

      if(data==''){

      }

      else{
          // AJAX Code To Submit Form.
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          var user_id = $('#user_id').val();
          $.ajax({
              type: 'POST',
              url: '{{ route('save_signature') }}',
              data:{"_token": "{{ csrf_token() }}","signature": data, "user_id":user_id},
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function(data){

              }
          });
      }
      return true;

  }

}
</script>
@endsection
