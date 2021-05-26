<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php
	use App\operational_expenditure;

		$ops=operational_expenditure::where('vehicle_reg_no',$_GET['reg_no']) ->wherebetween('date_received',[ $_GET['start'] ,$_GET['end']])->get();
		$i =1;
	?>

<table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
      {{-- <th scope="col" style="color:#fff;"><center>Vehicle No.</center></th> --}}
      <th scope="col" style="color:#fff;"><center>LPO No.</center></th>
      <th scope="col" style="color:#fff;"><center>Date Received</center></th>
      <th scope="col" style="color:#fff;"><center>Description of Work</center></th>
      <th scope="col" style="color:#fff;"><center>Service Provider</center></th>
      <th scope="col" style="color:#fff;"><center>Fuel Consumed (litres)</center></th>
      <th scope="col" style="color:#fff;"><center>Amount (TZS)</center></th>
      <th scope="col" style="color:#fff;"><center>Total (TZS)</center></th>
      @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR (Auth::user()->role=='System Administrator' OR Auth::user()->role=='Super Administrator'))
      <th scope="col" style="color:#fff;"><center>Action</center></th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach($ops as $operational)
      <tr>
        <td style="text-align: center;">{{$i}}.</td>
       {{--  <td>{{$operational->vehicle_reg_no}}</td> --}}
        <td>{{$operational->lpo_no}}</td>
        <td><center>{{date("d/m/Y",strtotime($operational->date_received))}}</center></td>
        <td>{{$operational->description}}</td>
        <td>{{$operational->service_provider}}</td>
        <td>{{$operational->fuel_consumed}}</td>
        <td style="text-align: right;">{{number_format($operational->amount)}}</td>
        <td style="text-align: right;">{{number_format($operational->total)}}</td>
        @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR (Auth::user()->role=='System Administrator' OR Auth::user()->role=='Super Administrator'))
        <td>
          <a title="Edit Operational Expenditure" data-toggle="modal" data-target="#editops{{$operational->id}}" role="button" aria-pressed="true" id="{{$operational->id}}"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
         <div class="modal fade" id="editops{{$operational->id}}" role="dialog">

              <div class="modal-dialog modal-dialog-scrollable" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to edit car details</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                <form method="get" action="{{ route('editoperational') }}">
        {{csrf_field()}}
         <input type="text" id="op_vehicle_reg_no{{$operational->id}}" name="op_vehicle_reg_no" class="form-control" required="" value="{{$operational->vehicle_reg_no}}" hidden="">

        <div class="form-group" id="lpodiv">
          <div class="form-wrapper">
            <label for="lpo_no{{$operational->id}}">LPO Number</label>
            <input type="text" id="lpo_no{{$operational->id}}" name="lpo_no" class="form-control" required="" value="{{$operational->lpo_no}}"  onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
          </div>
        </div>
        <br>

        <div class="form-group" id="datediv">
          <div class="form-wrapper">
            <label for="date_received{{$operational->id}}">Date Received</label>
            <input type="date" id="date_received{{$operational->id}}" name="date_received" class="form-control" required="" value="{{$operational->date_received}}" max={{date('Y-m-d')}}>
          </div>
        </div>
        <br>

        <div class="form-group" id="providerdiv">
          <div class="form-wrapper">
            <label for="provider{{$operational->id}}">Service Provider</label>
            <input type="text" id="provider{{$operational->id}}" name="provider" class="form-control" required="" value="{{$operational->service_provider}}">
          </div>
        </div>
        <br>


        <div class="form-group" id="fueldiv">
          <div class="form-wrapper">
            <label for="fuel{{$operational->id}}">Fuel Consumed in Litres</label>
            <input type="text" id="fuel{{$operational->id}}" name="fuel" class="form-control" required="" value="{{$operational->fuel_consumed}}"  onkeypress="if((this.value.length<5)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
          </div>
        </div>
        <br>

        <div class="form-group" id="amountdiv">
          <div class="form-wrapper">
            <label for="amount{{$operational->id}}">Amount</label>
            <input type="text" id="amount{{$operational->id}}" name="amount" class="form-control" required="" value="{{$operational->amount}}"  onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
          </div>
        </div>
        <br>

        <div class="form-group" id="totaldiv">
          <div class="form-wrapper">
            <label for="total{{$operational->id}}">Total</label>
            <input type="text" id="total{{$operational->id}}" name="total" class="form-control" required="" value="{{$operational->total}}"  onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
          </div>
        </div>
        <br>

        <div class="form-group" id="descriptiondiv">
          <div class="form-wrapper">
            <label for="description{{$operational->id}}">Description of Work</label>
            <textarea type="text" id="description{{$operational->id}}" name="description" class="form-control" maxlength="100" required="" value="">{{$operational->description}}</textarea>
          </div>
        </div>
        <br>
        <input type="text" name="id" value="{{$operational->id}}" hidden="">

        <div align="right">
  <button class="btn btn-primary" type="submit">Save</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>

      </form>

                 </div>
               </div>
             </div>
           </div>

            <a title="Delete this Expenditure" data-toggle="modal" data-target="#Deactivateop{{$operational->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red; cursor: pointer;"></i></a>
<div class="modal fade" id="Deactivateop{{$operational->id}}" role="dialog">
        <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

           <div class="modal-body">
            <p style="font-size: 20px;">Are you sure you want to delete this operational expenditure?</p>
            <br>
            <div align="right">
      <a class="btn btn-info" href="{{route('deleteops',$operational->id)}}">Proceed</a>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
</div>

</div>
</div>
</div>
</div>
</td>
@endif
</tr>
<?php $i =$i+1;?>
@endforeach
</tbody>
</table>

</body>
</html>
