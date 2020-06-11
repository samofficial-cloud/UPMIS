@extends('layouts.app')
@section('content')
<div class="wrapper">
<div class="sidebar">
        <ul style="list-style-type:none;">
            <li><a href="#"><i class="fas fa-home"></i>Home</a></li>
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
      <div class="container" style="max-width: 1308px;">
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
              <form method="get" action="" name="form1" id="form1" onsubmit="return getdata()">
        {{csrf_field()}}

        <div class="form-group row">
          <label for="dept"  class="col-sm-3 col-form-label"><strong>Type:</strong></label>
          <div class="col-sm-7">
            <select name="space_type" >

              <option value="3" id="Option" >Mall-shop</option>
              <option value="1" id="Option">Villa</option>
              <option value="2" id="Option">Office block</option>
              <option value="1" id="Option">Cafeteria</option>
              <option value="2" id="Option">Stationery</option>
            </select>
        </div>
        </div>

        <div class="form-group row">
          <label for="course"  class="col-sm-3 col-form-label"><strong>Location:</strong></label>
          <div class="col-sm-7">
            <select name="space_type" >
              <option value="3" id="Option" >Mlimani City</option>
              <option value="1" id="Option">UDSM Main Campus</option>
            </select>
        </div>
        </div>

        <div class="form-group row">
          <label for="course_name"  class="col-sm-3 col-form-label"><strong>Size:</strong></label>
          <div class="col-sm-7">
          <input type="text" class="form-control" id="course_name" name="space_size" value=""  autocomplete="off">
        </div>
        </div>

        <div class="form-group row">
          <label for="instructor"  class="col-sm-3 col-form-label"><strong>Rent Price Guide:</strong></label>
          <div class="col-sm-7">
            <select name="space_type" >
              <option value="3" id="Option" >200,000-500,000 TZS</option>
              <option value="1" id="Option">500,000-1000,000 TZS</option>
              <option value="1" id="Option">1000,000-2000,000 TZS</option>
              <option value="1" id="Option">2000,000-5000,000 TZS</option>
              <option value="1" id="Option">5000,000-10,000,000 TZS</option>
              <option value="1" id="Option">10,000,000-50,000,000 TZS</option>
              <option value="1" id="Option">50,000,000-200,000,000 TZS</option>
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


    <div class="modal fade" id="edit_space" role="dialog">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <b><h5 class="modal-title">Edit Renting Space Information</h5></b>

            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <div class="modal-body">
            <form method="get" action="" name="form1" id="form1" onsubmit="return getdata()">
              {{csrf_field()}}

              <div class="form-group row">
                <label for="dept"  class="col-sm-3 col-form-label"><strong>Type:</strong></label>
                <div class="col-sm-7">
                  <select disabled name="space_type" >

                    <option value="3" id="Option" >Mall-shop</option>
                    <option value="1" id="Option">Villa</option>
                    <option value="2" id="Option">Office block</option>
                    <option value="1" id="Option">Cafeteria</option>
                    <option value="2" id="Option">Stationery</option>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="course"  class="col-sm-3 col-form-label"><strong>Location:</strong></label>
                <div class="col-sm-7">
                  <select disabled name="space_type" >
                    <option value="3" id="Option" >Mlimani City</option>
                    <option value="1" id="Option">UDSM Main Campus</option>
                  </select>
                </div>
              </div>

              <div class="form-group row">
                <label for="course_name"  class="col-sm-3 col-form-label"><strong>Size:</strong></label>
                <div class="col-sm-7">
                  <input type="text" class="form-control" id="course_name" name="space_size" value=""  autocomplete="off">
                </div>
              </div>

              <div class="form-group row">
                <label for="instructor"  class="col-sm-3 col-form-label"><strong>Rent Price Guide:</strong></label>
                <div class="col-sm-7">
                  <select name="space_type" >
                    <option value="3" id="Option" >200,000-500,000 TZS</option>
                    <option value="1" id="Option">500,000-1000,000 TZS</option>
                    <option value="1" id="Option">1000,000-2000,000 TZS</option>
                    <option value="1" id="Option">2000,000-5000,000 TZS</option>
                    <option value="1" id="Option">5000,000-10,000,000 TZS</option>
                    <option value="1" id="Option">10,000,000-50,000,000 TZS</option>
                    <option value="1" id="Option">50,000,000-200,000,000 TZS</option>
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
          <th scope="col"  style="color:#3490dc;"><center>Size</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Rent Price Guide</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
        </tr>
        </thead>
        <tbody>


          <tr>

            <td><center>1</center></td>
            <td><center>MS001</center></td>
            <td><center>Mall-Shop</center></td>
            <td><center>Mlimani City</center></td>
            <td><center>10 SQM</center></td>
            <td><center>500,000-1000,000 TZS</center></td>
            <td><center><a data-toggle="modal" data-target="#edit_space" role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>



                <a data-toggle="modal" data-target="#Deactivate" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>



              </center>
            </td>
          </tr>


          <tr>

            <td><center>2</center></td>
            <td><center>OB001</center></td>
            <td><center>Office block</center></td>
            <td><center>Mlimani City</center></td>
            <td><center>23 SQM</center></td>
            <td><center>5000,000-10,000,000 TZS</center></td>
            <td><center><a data-toggle="modal" data-target="#edit" role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>



                <a data-toggle="modal" data-target="#Deactivate" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>



              </center>
            </td>
          </tr>

          <tr>

            <td><center>3</center></td>
            <td><center>VL001</center></td>
            <td><center>Villa</center></td>
            <td><center>Mlimani City</center></td>
            <td><center>17 SQM</center></td>
            <td><center>1000,000-2000,000 TZS</center></td>
            <td><center><a data-toggle="modal" data-target="#edit" role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>



                <a data-toggle="modal" data-target="#Deactivate" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>



              </center>
            </td>
          </tr>

          <tr>

            <td><center>4</center></td>
            <td><center>CF001</center></td>
            <td><center>Cafeteria</center></td>
            <td><center>UDSM Main Campus</center></td>
            <td><center>45 SQM</center></td>
            <td><center>5000,000-10,000,000 TZS</center></td>
            <td><center><a data-toggle="modal" data-target="#edit" role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>



                <a data-toggle="modal" data-target="#Deactivate" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>



              </center>
            </td>
          </tr>

          <tr>

            <td><center>5</center></td>
            <td><center>ST001</center></td>
            <td><center>Stationery</center></td>
            <td><center>UDSM Main Campus</center></td>
            <td><center>6 SQM</center></td>
            <td><center>200,000-500,000 TZS</center></td>
            <td><center><a data-toggle="modal" data-target="#edit" role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>



                <a data-toggle="modal" data-target="#Deactivate" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>



              </center>
            </td>
          </tr>

          <tr>

            <td><center>6</center></td>
            <td><center>VL002</center></td>
            <td><center>Villa</center></td>
            <td><center>Mlimani City</center></td>
            <td><center>13 SQM</center></td>
            <td><center>500,000-1000,000 TZS</center></td>
            <td><center><a data-toggle="modal" data-target="#edit" role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>



                <a data-toggle="modal" data-target="#Deactivate" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>



              </center>
            </td>
          </tr>

          <tr>

            <td><center>7</center></td>
            <td><center>ST002</center></td>
            <td><center>Stationery</center></td>
            <td><center>UDSM Main Campus</center></td>
            <td><center>8 SQM</center></td>
            <td><center>200,000-500,000 TZS</center></td>
            <td><center><a data-toggle="modal" data-target="#edit" role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>



                <a data-toggle="modal" data-target="#Deactivate" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>



              </center>
            </td>
          </tr>

          <tr>

            <td><center>8</center></td>
            <td><center>OB002</center></td>
            <td><center>Office block</center></td>
            <td><center>Mlimani City</center></td>
            <td><center>12 SQM</center></td>
            <td><center>2000,000-5000,000 TZS</center></td>
            <td><center><a data-toggle="modal" data-target="#edit" role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>



                <a data-toggle="modal" data-target="#Deactivate" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>



              </center>
            </td>
          </tr>

        </tbody>
      </table>

      </div>
    </div>
  </div>
</div>
</div>
@endsection