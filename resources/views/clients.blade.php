@extends('layouts.app')

@section('content')
<div class="wrapper">
<div class="sidebar">
        <ul style="list-style-type:none;">
            <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>
            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            <li><a href="#"><i class="fas fa-address-card"></i>Insurance</a></li>
            <li><a href="#"><i class="fas fa-car-side"></i>Car Rental</a></li>
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
            <li><a href="#"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="#"><i class="fas fa-file-invoice"></i>Invoice</a></li>
            <li><a href="#"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="#"><i class="fas fa-file-pdf"></i>Reports</a></li>
        </ul> 
    </div>
<div class="main_content">
<div class="container" style="max-width: 1308px;">
        <a data-toggle="modal" data-target="#client" class="btn btn-success button_color active" style="
    padding: 10px;
    margin-left: -16px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add Client</a>

    <div class="modal fade" id="client" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                 	<form method="get">
        {{csrf_field()}}
        <div class="form-group">
					<div class="form-wrapper" id="clientdiv">
          <label for="client_type">Client Type</label>
            <select class="form-control" required="" id="client_type" name="client_type">
              <option value=""disabled selected hidden>select type</option>
              <option value="1">Individual</option>
              <option value="2">Company/Organization</option>
            </select>
        
        </div>
    </div>

        <div class="form-group row" id="namediv" style="display: none;">
						<div class="form-wrapper col-6">
							<label for="first_name">First Name</label>
							<input type="text" id="first_name" name="first_name" class="form-control" required="" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
						</div>
						<div class="form-wrapper col-6">
							<label for="last_name">Last Name</label>
							<input type="text" id="last_name" name="last_name" class="form-control" required="" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
						</div>
					</div>

					<div class="form-group" id="companydiv" style="display: none;">
					<div class="form-wrapper">
						<label for="company_name">Company Name</label>
						<input type="text" id="company_name" name="company_name" class="form-control">
					</div>
				</div>

    <div class="form-group">
					<div class="form-wrapper">
						<label for="email">Email</label>
						<input type="text" name="email" id="email" class="form-control" placeholder="someone@example.com" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="25">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="phone_number">Phone Number</label>
						<input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="075xxxxxxxx" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
					</div>
				</div>

				<div class="form-group">
					<div class="form-wrapper">
						<label for="address">Address</label>
						<input type="text" id="address" name="address" class="form-control">
					</div>
				</div>

				<div align="right">
  <button class="btn btn-primary" type="submit">Submit</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
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
<script type="text/javascript">
   $(document).ready(function() {
    $('#client_type').click(function(){
       var query = $(this).val();
       if(query=='1'){
        $('#namediv').show();
        $('#companydiv').hide();
        $('#company_name').val("");
       }
       else if(query=='2'){
        $('#companydiv').show();
        $('#namediv').hide();
        $('#first_name').val("");
        $('#last_name').val("");
       }
       else{
        $('#namediv').hide();
        $('#companydiv').hide();
        $('#first_name').val("");
        $('#last_name').val("");
        $('#company_name').val("");
       }

      });
    });
</script>
@endsection