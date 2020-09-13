@extends('layouts.app')

@section('style')
<style type="text/css">
tr{
  border-bottom:1px solid #dcdcdc;;
}
td{
    height: 40px;
    padding: 10px;
}
.row2
 {
   height: 564px;
  }

  .badge-info {
    color: #fff;
    background-color: #38c172;
    float: right;
}
</style>
@endsection

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
    <br>
    <div class="container">
        <div class="row2">
          <div class="col-3">

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
        <a data-toggle="modal" data-target="#chat" class="btn btn-success button_color active" style="
    padding: 10px;

    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">New Chat</a>

    <div class="modal fade" id="chat" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">New Message</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('sendchat') }}">
        {{csrf_field()}}
          <div class="form-group row">
            <label for="client_names" class="col-sm-2">To</label>
            <div class="col-sm-9">
            <div id="myDropdown">
            <select type="text" id="client_names" name="receiver_name" class="form-control" value="" required="" onkeyup="filterFunction()">
            <option value="" disabled selected hidden>Select Intended Recipient</option>
            @foreach($name as $name)
            <option value="{{$name->name}}">{{$name->name}}</option>
            @endforeach
            </select>
            </div>
          </div>
        </div>
        
         <br>
         
        <div class="form-group row">
            <label for="message" class="col-sm-2">Message</label>
            <div class="col-sm-9">
              <textarea type="text" id="message" name="content" class="form-control" value="" rows="7"></textarea>
          </div>
        </div>
        <br>
        <input type="text" name="sender_name" hidden="" value="{{ Auth::user()->name }}">
        

        <div align="right">
  <button class="btn btn-primary" type="submit">Send</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>
  </form>
                 </div>
             </div>
         </div>
     </div>
<br>
<br>
  <div>
    <div class="card bg-light">
<table>
    @foreach($chats1 as $chat)
    <?php
     $chats_count=DB::table('system_chats')->where('sender',$chat->sender)->where('receiver',Auth::user()->name)->where('flag','1')->count('id');
    ?>
    <tr>
       <td><i class="fas fa-user-circle" style="font-size: 25px;"></i><a class="chatz" href="{{ route('viewchat',[$chat->sender]) }}" id="{{$chat->sender}}">{{$chat->sender}}<span class="badge badge-info">{{$chats_count}}</span></a></td>
    </tr>
    @endforeach
    @foreach($chats2 as $chat)
    <?php
     $chats_count2=DB::table('system_chats')->where('sender',$chat->sender)->where('receiver',Auth::user()->name)->where('flag','1')->count('id');
    ?>
    <tr>
        <td><i class="fas fa-user-circle" style="font-size: 25px;"></i> <a class="chatz" href="{{ route('viewchat',[$chat->receiver]) }}" id="{{$chat->receiver}}">{{$chat->receiver}}<span class="badge badge-info">{{$chats_count2}}</a></td>
    </tr>
    @endforeach
</table>
</div>
</div>
        
    </div>
    <div class="col-9 hero-image">
      <br>
      
      <input type="text" name="cid" id="cid" value="{{$_GET['id']}}" hidden="">
      {{-- <div id="loading" style="margin: auto;"></div> --}}
    <div id="content">
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
   $(".chatz").click(function(e){
  e.preventDefault();
     theurl=$(this).attr('href');
    $.ajax({
      url: theurl,
      context: document.body
    }).done(function(fragment) { 
      $("#content").html(fragment);
    });
    return false;
});
   });
</script>
<script type="text/javascript">
  $(document).ready(function() {
  var nid = $('#cid').val();
  console.log(nid);
  if(nid!=""){

    var tablink = document.getElementById(nid).href;
    location.search.split('id=')[1]="3";
       //tablink.click();
    $.ajax({
    url: tablink,
    context: document.body
    }).done(function(fragment) { 
      $("#content").html(fragment);
    });
    return false;
  }    
 });
</script>
<script type="text/javascript">
    function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("client_names");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("option");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
</script>
{{-- <script type="text/javascript">
  $(document).ajaxSend(function(){
    $("#loading").fadeIn(250);
});
$(document).ajaxComplete(function(){
    $("#loading").fadeOut(250);
});
</script> --}}
   
@endsection