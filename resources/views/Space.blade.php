@extends('layouts.app')
@section('content')
<div class="wrapper">
<div class="sidebar">
        <ul style="list-style-type:none;">
            <li><a href="/"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="#"><i class="fas fa-building"></i>Space</a></li>
            <li><a href="#"><i class="fas fa-address-card"></i>Insurance</a></li>
            <li><a href="#"><i class="fas fa-car-side"></i>Car Rental</a></li>
            <li><a href="#"><i class="fas fa-user"></i>Clients</a></li>
            <li><a href="#"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="#"><i class="fas fa-file-invoice"></i>Invoice</a></li>
            <li><a href="#"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="#"><i class="fas fa-file-pdf"></i>Reports</a></li>
        </ul>
    </div>

    <div class="main_content">
      <div class="container " style="max-width: 1308px;">
        @if ($message = Session::get('success'))
          <div class="alert alert-success row col-xs-12" style="margin-left: -13px;
    margin-bottom: -1px;
    margin-top: 4px;">
            <p>{{$message}}</p>
          </div>
        @endif

        <a data-toggle="modal" data-target="#space" class="btn button_color active" style="    background-color: lightgrey;
    padding: 10px;
    margin-left: -16px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add New Space</a>
  <br>

  <div class="row justify-content-center">
      <div class="modal fade" id="space" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Add New Renting Space</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
              <form method="post" action="{{ route('add_space')}}"  id="form1" >
        {{csrf_field()}}
                <div class="form-group row">
                  <label for="course_name"  class="col-sm-3 col-form-label"><strong>Space Id <span style="color: red;">*</span> :</strong></label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" id="course_name" name="space_id" value="" Required autocomplete="off">
                  </div>
                </div>



        <div class="form-group row">
          <label for="dept"  class="col-sm-3 col-form-label"><strong>Type:</strong></label>
          <div class="col-sm-7">
            <select name="space_type" >

              <option value="Mall-shop" id="Option" >Mall-shop</option>
              <option value="Villa" id="Option">Villa</option>
              <option value="Office block" id="Option">Office block</option>
              <option value="Cafeteria" id="Option">Cafeteria</option>
              <option value="Stationery" id="Option">Stationery</option>
            </select>
        </div>
        </div>

        <div class="form-group row">
          <label for="course"  class="col-sm-3 col-form-label"><strong>Location:</strong></label>
          <div class="col-sm-7">
            <select name="space_location" >
              <option value="Mlimani City" id="Option" >Mlimani City</option>
              <option value="UDSM Main Campus" id="Option">UDSM Main Campus</option>
            </select>
        </div>
        </div>

        <div class="form-group row">
          <label for="course_name"  class="col-sm-3 col-form-label"><strong>Size (SQM):</strong></label>
          <div class="col-sm-7">
          <input type="text" class="form-control" id="course_name" name="space_size" value="" required autocomplete="off">
        </div>
        </div>

        <div class="form-group row">
          <label for="instructor"  class="col-sm-3 col-form-label"><strong>Rent Price Guide:</strong></label>
          <div class="col-sm-7">
            <select name="rent_price_guide" >
              <option value="200,000-500,000 TZS"  >200,000-500,000 TZS</option>
              <option value="500,000-1000,000 TZS" >500,000-1000,000 TZS</option>
              <option value="1000,000-2000,000 TZS" >1000,000-2000,000 TZS</option>
              <option value="2000,000-5000,000 TZS" >2000,000-5000,000 TZS</option>
              <option value="5000,000-10,000,000 TZS" >5000,000-10,000,000 TZS</option>
              <option value="10,000,000-50,000,000 TZS" >10,000,000-50,000,000 TZS</option>
              <option value="50,000,000-200,000,000 TZS" >50,000,000-200,000,000 TZS</option>
            </select>
      </div>
      </div>

      <div align="right">
  <button class="btn btn-primary" type="submit" id="newdata">Save</button>
  <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
</div>

      </form>
      </div>
      </div>
      </div>


    </div>





      <table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
          <th scope="col" style="color:#3490dc;"><center>Space Id</center></th>
          <th scope="col" style="color:#3490dc;"><center>Type</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Location</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Size (SQM)</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Rent Price Guide</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($spaces as $var)
          <tr>

            <td class="counterCell text-center"></td>
            <td><center>{{$var->space_id}}</center></td>
            <td><center>{{$var->type}}</center></td>
            <td><center>{{$var->location}}</center></td>
            <td><center>{{$var->size}}</center></td>
            <td><center>{{$var->rent_price_guide}}</center></td>
            <td><center><a data-toggle="modal" data-target="#edit_space{{$var->id}}" role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>

                <a data-toggle="modal" data-target="#deactivate{{$var->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>
                <div class="modal fade" id="edit_space{{$var->id}}" role="dialog">

                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <b><h5 class="modal-title">Edit Renting Space Information</h5></b>

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <div class="modal-body">
                        <form method="get" action="{{ route('edit_space',$var->id)}}" >
                          {{csrf_field()}}

                          <div class="form-group row">
                            <label for="course_name"  class="col-sm-3 col-form-label"><strong>Space Id:</strong></label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="course_name" name="space_id" value="{{$var->space_id}}" Required autocomplete="off">
                            </div>
                          </div>


                          <div class="form-group row">
                            <label for="dept"  class="col-sm-3 col-form-label"><strong>Type:</strong></label>
                            <div class="col-sm-7">
                              <select  name="space_type" >

                                <option value=" {{$var->type}}" id="Option" >{{$var->type}}</option>
                                <option value="Mall-shop" id="Option" >Mall-shop</option>
                                <option value="Villa" id="Option">Villa</option>
                                <option value="Office block" id="Option">Office block</option>
                                <option value="Cafeteria" id="Option">Cafeteria</option>
                                <option value="Stationery" id="Option">Stationery</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="course"  class="col-sm-3 col-form-label"><strong>Location:</strong></label>
                            <div class="col-sm-7">
                              <select  name="space_location" >

                                <option value="{{$var->location}}" id="Option" >{{$var->location}}</option>
                                <option value="Mlimani City" id="Option" >Mlimani City</option>
                                <option value="UDSM Main Campus" id="Option">UDSM Main Campus</option>
                              </select>
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="course_name"  class="col-sm-3 col-form-label"><strong>Size (SQM):</strong></label>
                            <div class="col-sm-7">
                              <input type="text" class="form-control" id="course_name" name="space_size" value="{{$var->size}}"  autocomplete="off">
                            </div>
                          </div>

                          <div class="form-group row">
                            <label for="instructor"  class="col-sm-3 col-form-label"><strong>Rent Price Guide:</strong></label>
                            <div class="col-sm-7">
                              <select name="rent_price_guide" >
                                <option value="{{$var->rent_price_guide}}"  >{{$var->rent_price_guide}}</option>
                                <option value="200,000-500,000 TZS"  >200,000-500,000 TZS</option>
                                <option value="500,000-1000,000 TZS" >500,000-1000,000 TZS</option>
                                <option value="1000,000-2000,000 TZS" >1000,000-2000,000 TZS</option>
                                <option value="2000,000-5000,000 TZS" >2000,000-5000,000 TZS</option>
                                <option value="5000,000-10,000,000 TZS" >5000,000-10,000,000 TZS</option>
                                <option value="10,000,000-50,000,000 TZS" >10,000,000-50,000,000 TZS</option>
                                <option value="50,000,000-200,000,000 TZS" >50,000,000-200,000,000 TZS</option>
                              </select>
                            </div>
                          </div>


                          <div align="right">
                            <button class="btn btn-primary" type="submit" id="newdata">Save</button>
                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                          </div>


                        </form>
                      </div>
                    </div>
                  </div>


                </div>



                <div class="modal fade" id="deactivate{{$var->id}}" role="dialog">

                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <b><h5 class="modal-title">Are you sure you want to delete the space with space id {{$var->space_id}}?</h5></b>

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <div class="modal-body">
                        <form method="get" action="{{ route('delete_space',$var->id)}}" >
                          {{csrf_field()}}



                          <div align="right">
                            <button class="btn btn-primary" type="submit" id="newdata">Yes</button>
                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">No</button>
                          </div>


                        </form>
                      </div>
                    </div>
                  </div>


                </div>


              </center>
            </td>
          </tr>
        @endforeach





        </tbody>
      </table>

      </div>
    </div>
  </div>
</div>
</div>
@endsection
