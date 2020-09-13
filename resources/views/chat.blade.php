<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style type="text/css">
#tid{
    border-collapse: inherit;
    border:0px solid;
    position: relative;
   max-height: 418px;
  overflow: auto;
  display: block;
}
td{
    border: 1px solid #fff;
     padding: 10px;
     border-radius: 25px;
     font-weight: 500;
     min-width: 70px;
}
.classtr{
   width: 100% !important;
   display: inline-block;
    border: none;
    margin-bottom: 5px;
}
#footer {
    position: absolute;
    bottom: 0;
    width: 95%;
}

#send{
    bottom: 0;
    border-radius: 25px;
}
sub{
   bottom: 0;
    right: 0;
    z-index: 10;
    text-align: right;
    vertical-align: bottom;
    margin-left: 35px;
    font-weight: 600;
}

</style>
</head>
<body>
  <?php
  $localtime = new DateTime("now", new DateTimeZone('Africa/Dar_es_Salaam'));
  $time=$localtime->format('H:i');
  ?>
  <div id="mydivv">
<div id="mydiv">
    <div>
        <h5>Chat with {{$receiver}}</h5>
        <hr>
    </div>
        <table id="tid">
            <tbody id="tbid" style="display: block; overflow-y:hidden;">

@if(count((array)$chat3)!=0)
             <tr class="classtr"><td style="width: 100%; text-align: center; display: inline-block;"><strong>{{date('d/m/Y', strtotime("-2 days"))}}</strong></td></tr>

              @foreach($chat3 as $chat)
               <tr class="classtr">
                @if($chat->receiver != Auth::user()->name)
                <td style="background-color:#dcdcdc; float: right; color: black;">{{$chat->content}}<sub>{{$chat->time}}</sub></td>
                @else
                <td style="float: left; background-color:#6cb2eb; color: white; ">{{$chat->content}}<sub>{{$chat->time}}</sub></td>
                @endif
            </tr>
              @endforeach
@endif

@if(count((array)$chat2)!=0)
               <tr class="classtr"><td style="width: 100%; text-align: center; display: inline-block;"><strong>Yesterday</strong></td></tr>

              @foreach($chat2 as $chat)
               <tr class="classtr">
                @if($chat->receiver != Auth::user()->name)
                <td style="background-color:#dcdcdc; float: right; color: black;">{{$chat->content}}<sub>{{$chat->time}}</sub></td>
                @else
                <td style="float: left; background-color:#6cb2eb; color: white; ">{{$chat->content}}<sub>{{$chat->time}}</sub></td>
                @endif
            </tr>
              @endforeach
              @endif

              @if(count((array)$chat1)!=0)
<tr class="classtr"><td style="width: 100%; text-align: center; display: inline-block;"><strong>Today</strong></td></tr>

            @foreach($chat1 as $chat)
            <tr class="classtr">
                @if($chat->receiver != Auth::user()->name)
                <td style="background-color:#dcdcdc; float: right; color: black;">{{$chat->content}}<sub>{{$chat->time}}</sub></td>
                @else
                <td style="float: left; background-color:#6cb2eb; color: white; ">{{$chat->content}}<sub>{{$chat->time}}</sub></td>
                @endif
            </tr>
            @endforeach
@endif
            </tbody>    
        </table>
        <div id="footer">
            <form method="post" action="{{ route('sendchat') }}" id="myform">
        {{csrf_field()}}
        <input type="text" name="receiver_name" value="{{$receiver}}" hidden="">
        <input type="text" name="sender_name" hidden="" value="{{ Auth::user()->name }}">
        <input type="text" name="time" value="{{$time}}" hidden="">
         
        <div class="form-group row" style="margin-bottom: 0rem;">
            <div class="col-11">
              <textarea type="text" id="message" name="mcontent" class="form-control" rows="2" placeholder="Type Message Here..." style="margin-bottom: 5px;" required=""></textarea>
          </div>
          <div class="col-1" >
            <button id="send" class="btn btn-success" type="submit" name="Sendbutton">Send</button>
          </div>
        </div>
  </form>
        </div>
        

</div>
</div>
</body>
</html>


<script type="text/javascript">
  $(document).ready(function() {
    var element = document.getElementById("tid");
    element.scrollTop = element.scrollHeight;
 $('[name="Sendbutton"]').click(function(form){
  e.preventDefault();
    $.ajaxSetup({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var _token = $('input[name="_token"]').val();
    var formData = $(form).serialize();
    var query="receiver_name="+$('input[name="receiver_name"]').val()+"&sender_name="+$('input[name="sender_name"]').val()+"&content="+$('textarea[name="mcontent"]').val();
    $.ajax({
          url:"/system_chats/send?"+query,
          method:"POST",
          data:$('#myform').serialize(),
          success:function(data){
            //var theURLL="/system_chats/view?rid=Samson%20Mero";
            // var theurl= theURLL.replace(/ /g, "%20");
            // console.log(theurl);
            //$("#mydivv").load(theURLL +" #mydiv>*","");

        }
         });

    });
 });
</script>