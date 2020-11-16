<!DOCTYPE html>
<html>
<head>
	<title>System User Report</title>
</head>
<style>
table {
  border-collapse: collapse;
   width: 100%;
}

table, td, th {
  border: 1px solid black;
}
/*table {
  counter-reset: tableCount;
  }*/

 /* .counterCell:before {
  content: counter(tableCount);
  counter-increment: tableCount;
  }*/

  #header,
#footer {
  position: fixed;
  left: 0;
  right: 0;
  color: #aaa;
  font-size: 0.9em;
}
#header {
  top: 0;
  border-bottom: 0.1pt solid #aaa;
}
#footer {
  text-align: center;
  bottom: 0;
  color: black;
  font-size: 15px;
  /*border-top: 0.1pt solid #aaa;*/
}
.page-number:before {
  content: counter(page);
}

@page {
            margin: 77px 75px  !important;
            padding: 0px 0px 0px 0px !important;
        }
</style>
<body>
<div id="footer">
  <div class="page-number"></div>
</div>

<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTMENT  
    </b>
    @if($_GET['report_type']=='user')
    	@if($_GET['st_fil']=='true')
    		@if($_GET['user']=='active')
    		 <br><br>List of <strong>Active</strong> System User.
    		 @elseif($_GET['user']=='inactive')
    		 <br><br>List of <strong>Inactive</strong> System User.
    		@endif
    	@else
    	<br><br>List of <strong>All</strong> System User.
    	@endif
    @endif
    </center>

    <br>
    <?php $i=1;?>

    <table>
          <thead class="thead-dark">
              <tr>
                <th scope="col" style="width: 5%;"><center>S/N</center></th>
                <th scope="col" style="width: 24%;">Name</th>
                <th scope="col" style="width: 22%;">Email</th>
                <th scope="col" style="width: 13%;">Phone Number</th>
                <th scope="col">Role</th>
                <th scope="col" style="width: 12%;">Cost Centre</th>
                @if($_GET['st_fil']!='true')
                <th scope="col" style="width: 10%;">Remarks</th>
                @endif
              </tr>
          </thead>

              <tbody>

              @foreach($users as $var)
                <tr>

                  <td><center>{{$i}}.</center></td>
                  <td>{{$var->first_name}} {{$var->last_name}}</td>
                  <td>{{$var->email}}</td>
                  <td><center>{{$var->phone_number}}</center></td>
                  <td>{{$var->role}}</td>
                  <td><center>{{$var->cost_centre}}</center></td>
                  @if($_GET['st_fil']!='true')
                  	@if($var->status==1)
                  		<td>Active</td>
                  	@elseif($var->status==0)
                  		<td>Inactive</td>
              		@endif
      			  @endif
              </tr>
              <?php $i=$i+1; ?>
              @endforeach
          </tbody>
      </table>
</body>
</html>