@extends('layouts.app')

@section('style')
<style type="text/css">
	* {
    margin: 0;
    padding: 0
}

html {
    height: 100%
}

#grad1 {
    background-color: : #9C27B0;
    /*background-image: linear-gradient(120deg, #FF4081, #81D4FA)*/
}

#msform {
    text-align: center;
    position: relative;
    margin-top: 20px
}

#msform fieldset .form-card {
    background: white;
    border: 0 none;
    border-radius: 0px;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    padding: 20px 40px 30px 40px;
    box-sizing: border-box;
    width: 94%;
    margin: 0 3% 20px 3%;
    position: relative
}

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;
    position: relative
}

#msform fieldset:not(:first-of-type) {
    display: none
}

#msform fieldset .form-card {
    text-align: left;
    color: #9E9E9E
}

#msform input,
#msform textarea {
    padding: 0px 8px 4px 8px;
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    /*font-family: montserrat;*/
    color: #2C3E50;
    font-size: 16px;
    letter-spacing: 1px
}

#msform input:focus,
#msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: none;
    font-weight: bold;
    border-bottom: 2px solid skyblue;
    outline-width: 0
}

#msform .action-button {
    width: 150px;
    background: skyblue;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px
}

#msform .action-button:hover,
#msform .action-button:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue
}

#msform .action-button-previous {
    width: 150px;
    background: #616161;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px
}

#msform .action-button-previous:hover,
#msform .action-button-previous:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px #616161
}

select.list-dt {
    border: none;
    outline: 0;
    border-bottom: 1px solid #ccc;
    padding: 2px 5px 3px 5px;
    margin: 2px
}

select.list-dt:focus {
    border-bottom: 2px solid skyblue
}

.card {
    z-index: 0;
    border: none;
    border-radius: 0.5rem;
    position: relative
}

.fs-title {
    font-size: 25px;
    color: #2C3E50;
    margin-bottom: 10px;
    font-weight: bold;
    text-align: left
}

#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey;
    margin-left: 20%;
}

#progressbar .active {
    color: #000000
}

#progressbar li {
    list-style-type: none;
    font-size: 12px;
    width: 25%;
    float: left;
    position: relative
}

#progressbar #account:before {
    font-family: FontAwesome;
    content: "\f04d"
}

#progressbar #vehicle:before {
    font-family: FontAwesome;
    content: "\f1b9"
}

    #progressbar #insurance:before {
        font-family: FontAwesome;
        content: "\f15c"
    }

#progressbar #payment:before {
    font-family: FontAwesome;
    content: "\f09d"
}

#progressbar #confirm:before {
    font-family: FontAwesome;
    content: "\f00c"
}

#progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 18px;
    color: #ffffff;
    background: lightgray;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px
}

#progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: lightgray;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1
}

#progressbar li.active:before,
#progressbar li.active:after {
    background: skyblue
}

.radio-group {
    position: relative;
    margin-bottom: 25px
}

.radio {
    display: inline-block;
    width: 204;
    height: 104;
    border-radius: 0;
    background: lightblue;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
    cursor: pointer;
    margin: 8px 2px
}

.radio:hover {
    box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3)
}

.radio.selected {
    box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1)
}

.fit-image {
    width: 100%;
    object-fit: cover
}
</style>
@endsection

@section('content')
<?php
$today=date('Y-m-d');
?>
<!-- MultiStep Form -->
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
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-12 col-sm-9 col-md-7 col-lg-9 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2><strong>Insurance Contract Information</strong></h2>

                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform" onsubmit="return submitFunction()"  METHOD="POST" action="{{ route('create_insurance_contract')}}">

                        {{csrf_field()}}
                            <!-- progressbar -->
                            <ul id="progressbar">

                            	<li class="" id="insurance"><strong>Insurance</strong></li>
                                <li id="payment"><strong>Payment</strong></li>
                                <li id="confirm"><strong>Confirm</strong></li>
                            </ul>


                             <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                                   <h2 style="text-align: center" class="fs-title">Insurance Information</h2>
                                    <div class="form-group">






                                        <div class="form-group row">

                                            <div class="form-wrapper col-12">
                                                <br>
                                                <label for="insurance_class"><strong>Class <span style="color: red;"> *</span></strong></label>
                                                <span id="class_msg"></span>
                                                <select id="insurance_class" class="form-control"   name="insurance_class">
                                                    <?php
                                                    $classes=DB::table('insurance_parameters')->get();
                                                    ?>
                                                    <option value=""></option>
                                                    @foreach($classes as $class)
                                                        @if($class->classes!='')
                                                            <option value="{{$class->classes}}">{{$class->classes}}</option>
                                                        @else
                                                        @endif

                                                    @endforeach
                                                </select>


                                            </div>


                                            <div id="insurance_companyDiv" class="form-wrapper col-12" style="display: none;" >
                                                <br>
                                                <label for="client_type"><strong>Principal <span style="color: red;"> *</span></strong></label>
                                                <span id="principal_msg"></span>
                                                <?php
                                                $companies=DB::table('insurance_parameters')->get();
                                                ?>
                                                <select id="insurance_company" class="form-control"  name="insurance_company">
                                                    <option value=""></option>
                                                    @foreach($companies as $var)
                                                        @if($var->company!=null)
                                                            <option value="{{$var->company}}" >{{$var->company}}</option>
                                                        @else
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div id="vehicle_classDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="vehicle_class"  ><strong>Vehicle class <span style="color: red;"> *</span></strong></label>
                                                <span id="vehicle_class_msg"></span>
                                                <select id="vehicle_class"  class="form-control" name="vehicle_use" >
                                                    <option value=""></option>
                                                    <option value="Private Cars" id="Option">Private Cars</option>
                                                    <option value="M/cycle/3 Wheelers" id="Option">M/cycle/3 Wheelers</option>
                                                    <option value="Commercial Vehicles" id="Option" >Commercial Vehicles</option>
                                                    <option value="Passenger Carrying" id="Option" >Passenger Carrying</option>
                                                    <option value="Special Type Vehicles" id="Option" >Special Type Vehicles</option>
                                                </select>
                                            </div>

{{--                                            UPDATE `fidelity_guarantee` SET `no_of_employees`=10 WHERE no_of_employees='x'--}}


                                            <div id="TypeDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="insurance_type"  ><strong>Type <span style="color: red;"> *</span></strong></label>
                                                <span id="insurance_type_msg"></span>
                                                <select id="insurance_type"  class="form-control" name="insurance_type" >

                                                </select>
                                            </div>



                                            <div id="number_of_employeesDiv" class="form-wrapper col-12 pt-4" style="display: none;">
                                                <label for="number_of_employees">Number of employees<span style="color: red;"> *</span></label>
                                                <span id="number_of_employees_msg"></span>
                                                <select id="number_of_employees" class="number_of_employees form-control" name="number_of_employees">
                                                    <option value="" ></option>
                                                    <?php
                                                    $number_of_employees=DB::table('fidelity_guarantee')->select('no_of_employees')->get();


                                                    $tempOut = array();
                                                    foreach($number_of_employees as $values){
                                                        $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($values));
                                                        $val = (iterator_to_array($iterator,true));
                                                        $tempoIn=$val['no_of_employees'];

                                                        if(!in_array($tempoIn, $tempOut))
                                                        {
                                                            print('<option value="'.$val['no_of_employees'].'">'.$val['no_of_employees'].'</option>');
                                                            array_push($tempOut,$tempoIn);
                                                        }

                                                    }
                                                    ?>
                                                </select>
                                            </div>




                                            <div id="Type_moneyDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="insurance_type_money"  ><strong>Type <span style="color: red;"> *</span></strong></label>
                                                <span id="insurance_type_money_msg"></span>
                                                <select id="insurance_type_money"  class="form-control" name="insurance_type_money" >
                                                    <option value=""></option>
                                                    <option value="Estimated annual cash carryings">1- Estimated annual cash carryings</option>
                                                    <option value="Cash in transit limit">2- Cash in transit limit</option>
                                                    <option value="Money in custody of collectors">3- Money in custody of collectors</option>
                                                    <option value="Money in safe during working hours">4- Money in safe during working hours</option>
                                                    <option value="Money in safe outside working hours">5- Money in safe outside working hours</option>
                                                    <option value="Money in residence of director or partner">6- Money in residence of director or partner</option>
                                                    <option value="Value of safe">7- Value of safe</option>
                                                </select>
                                            </div>



                                            <div id="Type_liabilityDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="insurance_type_liability"  ><strong>Type <span style="color: red;"> *</span></strong></label>
                                                <span id="insurance_type_liability_msg"></span>
                                                <select id="insurance_type_liability"  class="form-control" name="insurance_type_liability" >
                                                    <option value=""></option>
                                                    <option value="Public Liability">1- Public Liability</option>
                                                    <option value="Products Liability">2- Products Liability</option>

                                                </select>
                                            </div>



                                            <div id="commodityDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="commodity"  ><strong>Commodity <span style="color: red;"> *</span></strong></label>
                                                <span id="commodity_msg"></span>
                                                <select id="commodity"  class="commodity form-control" name="commodity" >
                                                    <option value=""></option>
                                                    <option value="Produce Raw Agricultural products including sisal cotton coffee tea cocoa rice in bags/bales/chests">1.A- Produce Raw Agricultural products including sisal cotton coffee tea cocoa rice in bags/bales/chests</option>
                                                    <option value="Grains in bags- maize, beans,peas excluding rain water, damage,infestation, contamination other than by  sea water">1.B- Grains in bags- maize, beans,peas excluding rain water, damage,infestation, contamination other than by sea water </option>
                                                    <option value="Non fragile merchandise/manufact e.g machinery, iron products, not susceptible to pilferage Rust, oxidation and discolorization">2.A- Non fragile merchandise/manufact e.g machinery, iron products, not susceptible to pilferage Rust, oxidation and discolorization</option>
                                                    <option value="If susceptible to pilferage/water demage e.g spare parts,batteries,tyres,cigarettes, paper">2.B- If susceptible to pilferage/water demage e.g spare parts,batteries,tyres,cigarettes, paper</option>
                                                    <option value="Semi-fragile general merchandise/manufactured goods e.g electrical appliances like refrigerators, radios etc. and domestic appliances like Thermos flasks, washing machine">3- Semi-fragile general merchandise/manufactured goods e.g electrical appliances like refrigerators, radios etc. and domestic appliances like Thermos flasks, washing machine</option>
                                                    <option value="Fragile General Merchandise/manufactured goods e.g glass, glassware, glass louvers/sheets, chinaware, wines">4- Fragile General Merchandise/manufactured goods e.g glass, glassware, glass louvers/sheets, chinaware, wines</option>
                                                    <option value="emical/products Tins">5.A- emical/products Tins</option>
                                                    <option value="Chemicals/Cement/fertilizer in bags excluding spillage, rain water damage, infestation other than by sea water">5.B- Chemicals/Cement/fertilizer in bags excluding spillage, rain water damage, infestation other than by sea water</option>
                                                    <option value="Pharmaceuticals">5.C- Pharmaceuticals</option>
                                                    <option value="Foodstuffs and cans">6.A- Foodstuffs and cans</option>
                                                    <option value="In Bags/cartons">6.B- In Bags/cartons</option>
                                                    <option value="Bulk Cargo(petroleum products & edible oils)">7.A- Bulk Cargo(petroleum products & edible oils)</option>
                                                    <option value="Bulk cargo (grain & others)">7.B- Bulk cargo (grain & others)</option>
                                                    <option value="Matches, fireworks, explosives, gunpowder, flammables, acids">8- Matches, fireworks, explosives, gunpowder, flammables, acids</option>
                                                    <option value="Copper and other precious metals">9- Copper and other precious metals</option>
                                                    <option value="Household goods and personal effects- professionally packed">10.A- Household goods and personal effects- professionally packed</option>
                                                    <option value="Household goods and personal effects- if otherwise">10.B- Household goods and personal effects- if otherwise</option>

                                                </select>
                                            </div>




                                            <div id="marine_containerizedDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="marine_containerized"  ><strong>State <span style="color: red;"> *</span></strong></label>
                                                <span id="marine_containerized_msg"></span>
                                                <select id="marine_containerized"  class="form-control" name="marine_containerized" >
                                                    <option value=""></option>
                                                    <option value="Containerized">Containerized</option>
                                                    <option value="Non-containerized">Non-containerized</option>
                                                </select>
                                            </div>





{{--                                            <div id="TypeDivNA" style="display: none;" class="form-wrapper col-12">--}}
{{--                                                <br>--}}
{{--                                                <label for="insurance_type_na"><strong>Type <span style="color: red;"> *</span></strong></label>--}}
{{--                                                <input type="text" class="form-control" id="insurance_type_na" name="insurance_type" readonly  value="N/A" autocomplete="off">--}}

{{--                                            </div>--}}


                                            <input type="hidden" class="form-control" id="insurance_type_na" name="insurance_type" readonly  value="N/A" autocomplete="off">


                                            <div id="type_of_riskDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="type_of_risk"  ><strong>Type of Risk<span style="color: red;"> *</span></strong></label>
                                                <span id="type_of_risk_msg"></span>
                                                <select id="type_of_risk"  class="form-control" name="type_of_risk" >
                                                    <option value=""></option>
                                                    <option value="Class 1 construction risks" id="Option">Class 1 construction risks</option>
                                                    <option value="Makuti/Thatched risks" id="Option">Makuti/Thatched risks</option>
                                                    <option value="Other" id="Option">Other</option>
                                                </select>
                                            </div>


                                            <div id="group_of_riskDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="group_of_risk"  ><strong>Group<span style="color: red;"> *</span></strong></label>
                                                <span id="group_of_risk_msg"></span>
                                                <select id="group_of_risk"  class="form-control" name="group_of_risk" >
                                                    <option value=""></option>
                                                    <option value="Non-manufacturing risks" id="Option">Non-manufacturing risks</option>
                                                    <option value="Storage risks" id="Option">Storage risks</option>
                                                    <option value="Manufacturing/industrial risks" id="Option">Manufacturing/industrial risks</option>
                                                </select>

                                            </div>








                                            <div id="risk_non_manufacturingDiv" style="display: none; " class="form-wrapper col-12">
                                                <br>
                                                <label for="risk_non_manufacturing"  ><strong>Risk(Non-manufacturing)<span style="color: red;"> *</span></strong></label>
                                                <span id="risk_non_manufacturing_msg"></span>
                                                <select id="risk_non_manufacturing" style="width: 100%;" class="risk_non_manufacturing form-control" name="risk_non_manufacturing" >
                                                    <option value=""></option>
                                                    <option value="Residences, Libraries, Museums, Schools and College and other educational institutions, places of worship, office">01- Residences, Libraries, Museums, Schools and College and other educational institutions, places of worship, office</option>
                                                    <option value="Hospitals and Clinics, Auditoriums, club and mess houses">02- Hospitals and Clinics, Auditoriums, club and mess houses</option>
                                                    <option value="Cafes, Restaurants, Kiosks and Shops selling Non-hazardous goods. Dry cleaners and laundries*, Confectioners*">03- Cafes, Restaurants, Kiosks and Shops selling Non-hazardous goods. Dry cleaners and laundries*, Confectioners*</option>
                                                    <option value="Hotels, Inns, Resorts, Shopping Malls with multiple occupancy">04- Hotels, Inns, Resorts, Shopping Malls with multiple occupancy</option>
                                                    <option value="Shops dealing with hazardous goods as per list given, Petrol/Diesel stations, Motor vehicle showrooms(including Sales and service but excluding Garages)">05- Shops dealing with hazardous goods as per list given, Petrol/Diesel stations, Motor vehicle showrooms(including Sales and service but excluding Garages)</option>
                                                </select>

                                            </div>


                                            <div id="risk_storageDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="risk_storage"  ><strong>Risk(Storage)<span style="color: red;"> *</span></strong></label>
                                                <span id="risk_storage_msg"></span>
                                                <select id="risk_storage" style="width: 100%;"  class="risk_storage form-control" name="risk_storage" >
                                                    <option value=""></option>
                                                    <option value="Non-hazardous goods">06- Non-hazardous goods</option>
                                                    <option value="Transporters, Cargo movers, Warehouses in the Airport or Sea port">08- Transporters, Cargo movers, Warehouses in the Airport or Sea port</option>
                                                    <option value="Hazardous goods as per list(ANNEXURE B)">09- Hazardous goods as per list(ANNEXURE B)</option>
                                                </select>

                                            </div>


                                            <div id="stateDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="state"  ><strong>State<span style="color: red;"> *</span></strong></label>
                                                <span id="state_msg"></span>
                                                <select id="state"  class="form-control" name="state" >
                                                    <option value=""></option>
                                                    <option value="In open" id="Option">In open</option>
                                                    <option value="Housed in a building" id="Option">Housed in a building</option>
                                                </select>

                                            </div>


                                            <div id="risk_manufacturingDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="risk_manufacturing"  ><strong>Risk(Manufacturing)<span style="color: red;"> *</span></strong></label>
                                                <span id="risk_manufacturing_msg"></span>
                                                <select id="risk_manufacturing" style="width: 100%;"  class="risk_manufacturing form-control" name="risk_manufacturing" >
                                                    <option value=""></option>
                                                    <option value="Aerated Water Factories">03- Aerated Water Factories</option>
                                                    <option value="Aircraft Hangers">07- Aircraft Hangers</option>
                                                    <option value="Airport Terminal Buildings(including all facilities like Cafes, shops etc.) excluding Cargo complex">03- Airport Terminal Buildings(including all facilities like Cafes, shops etc.) excluding Cargo complex</option>
                                                    <option value="Aluminium, Zinc, Copper Factories">03- Aluminium, Zinc, Copper Factories</option>
                                                    <option value="Atta and Cereal Grinding(excluding Pulse Mills)">04- Atta and Cereal Grinding(excluding Pulse Mills)</option>
                                                    <option value="Bakeries">03- Bakeries</option>
                                                    <option value="Basket Weavers and Cane Furniture Makers">08- Basket Weavers and Cane Furniture Makers</option>
                                                    <option value="Battery Manufacturing">05- Battery Manufacturing</option>
                                                    <option value="Biscuit Factories">03- Biscuit Factories</option>
                                                    <option value="Bituminized Paper and or Hessian Cloth Manufacturing including Tar Felt Manufacturing">08- Bituminized Paper and or Hessian Cloth Manufacturing including Tar Felt Manufacturing</option>
                                                    <option value="Book Binders, Envelope and Paper Bag Manufacturing">06- Book Binders, Envelope and Paper Bag Manufacturing</option>
                                                    <option value="Breweries">04- Breweries</option>
                                                    <option value="Brickworks(including refractories and fire bricks)">03- Brickworks(including refractories and fire bricks)</option>
                                                    <option value="Bridges-Concrete/Steel">03- Bridges-Concrete/Steel</option>
                                                    <option value="Bridges-Wooden">04- Bridges-Wooden</option>
                                                    <option value="Building In Course of Construction">03- Building In Course of Construction</option>
                                                    <option value="Candle Works">07- Candle Works</option>
                                                    <option value="Canning Factories">03- Canning Factories</option>
                                                    <option value="Cardboard Box Manufacturing">05- Cardboard Box Manufacturing</option>
                                                    <option value="Carpenters, Wood wool Manufacturing. Furniture Manufacturing and other wood worker shops(excluding saw-mill)">08- Carpenters, Wood wool Manufacturing. Furniture Manufacturing and other wood worker shops(excluding saw-mill)</option>
                                                    <option value="Cashew nut Factories">07- Cashew nut Factories</option>
                                                    <option value="Cattle feed Mill">04- Cattle feed Mill</option>
                                                    <option value="Cement/asbestos/concrete products Manufacturing">03- Cement/asbestos/concrete products Manufacturing</option>
                                                    <option value="Cement Factories">04- Cement Factories</option>
                                                    <option value="Chemical Manufacturing">06- Chemical Manufacturing</option>
                                                    <option value="Cigar and Cigarette Manufacturing">07- Cigar and Cigarette Manufacturing</option>
                                                    <option value="Video and Sound Recording rooms">03- Video and Sound Recording rooms</option>
                                                    <option value="Cinema Theatres">06- Cinema Theatres</option>
                                                    <option value="Cloth Processing units situated outside the compound of Textile mills">03- Cloth Processing units situated outside the compound of Textile mills</option>
                                                    <option value="Coal/Coke/Charcoal ball & briquettes Manufacturing">09- Coal/Coke/Charcoal ball & briquettes Manufacturing</option>
                                                    <option value="Coal processing plants">06- Coal processing plants</option>
                                                    <option value="Coffee Curing, Roasting/Grinding ">04- Coffee Curing, Roasting/Grinding </option>
                                                    <option value="Coir Factories">07- Coir Factories</option>
                                                    <option value="Collieries- underground Machinery and pit head gear">07- Collieries- underground Machinery and pit head gear</option>
                                                    <option value="Condensed Milk Factories, Milk pasteurizing Plants and Dairies">03- Condensed Milk Factories, Milk pasteurizing Plants and Dairies</option>
                                                    <option value="Confectionery Manufacturing">03- Confectionery Manufacturing</option>
                                                    <option value="Contractors Plant and Machinery- At one location only">06- Contractors Plant and Machinery- At one location only</option>
                                                    <option value="Contractors Plant and Machinery- Anywhere in Tanzania(at specified locations)">08- Contractors Plant and Machinery- Anywhere in Tanzania(at specified locations)</option>
                                                    <option value="Standalone Utilities">02- Standalone Utilities</option>
                                                    <option value="Cotton seed cleaning/Delinting factory">08- Cotton seed cleaning/Delinting factory</option>
                                                    <option value="Dehydration factories">03- Dehydration factories</option>
                                                    <option value="Detergent and soap Manufacturing">06- Detergent and soap Manufacturing</option>
                                                    <option value="Distilleries">06- Distilleries</option>
                                                    <option value="Electric Generation Stations- Hydro Power stations">05- Electric Generation Stations- Hydro Power stations</option>
                                                    <option value="Electric Generation Stations- Other than Hydro">03- Electric Generation Stations- Other than Hydro</option>
                                                    <option value="Electric Lamp/T.V. Picture Tube Manufacturing">04- Electric Lamp/T.V. Picture Tube Manufacturing</option>
                                                    <option value="Electronic goods manufacturing/assembly">05- Electronic goods manufacturing/assembly</option>
                                                    <option value="Electronic software parks">03- Electronic software parks</option>
                                                    <option value="Engineering Workshop- Structural Steel fabricators, Sheet Metal fabricators, Hot/cold Rolling, Pipe Extruding, Stamping, Pressing,Forging Mills, Metal smelting, Foundries, Galvanizing works, Metal extraction, Ore processing(Other than Aluminium, Copper,Zinc)">03- Engineering Workshop- Structural Steel fabricators, Sheet Metal fabricators, Hot/cold Rolling, Pipe Extruding, Stamping, Pressing,Forging Mills, Metal smelting, Foundries, Galvanizing works, Metal extraction, Ore processing(Other than Aluminium, Copper,Zinc)    </option>
                                                    <option value="Engineering Workshop(other than above), Clock/Watch manufacturing, motor vehicle garages">04- Engineering Workshop(other than above), Clock/Watch manufacturing, motor vehicle garages</option>
                                                    <option value="Exhibitions, fetes, shamianas of canvas or other cloth">09- Exhibitions, fetes, shamianas of canvas or other cloth</option>
                                                    <option value="Fish, Sea food and meat processing">04- Fish, Sea food and meat processing</option>
                                                    <option value="Flour Mills">07- Flour Mills</option>
                                                    <option value="Foamed plastics manufacturing and or converting plants">08- Foamed plastics manufacturing and or converting plants</option>
                                                    <option value="Foam rubber manufacturing">08- Foam rubber manufacturing</option>
                                                    <option value="Fruit and vegetable processing including pulp making, drying/dehydration factories">03- Fruit and vegetable processing including pulp making, drying/dehydration factories</option>
                                                    <option value="Garment makers, hats and the like makers">04- Garment makers, hats and the like makers</option>
                                                    <option value="Vegetable or Animal oil manufacturing including clarified butter">04- Vegetable or Animal oil manufacturing including clarified butter</option>
                                                    <option value="Glass wool Manufacturing">07- Glass wool Manufacturing</option>
                                                    <option value="Glass Manufacturing">04- Glass Manufacturing</option>
                                                    <option value="Granite factories">03- Granite factories</option>
                                                    <option value="Grain/seeds disintegrating/crushing/Decorticating factories/pulse mills">06- Grain/seeds disintegrating/crushing/Decorticating factories/pulse mills</option>
                                                    <option value="Grease/wax manufacturing">06- Grease/wax manufacturing</option>
                                                    <option value="Green Houses">03- Green Houses</option>
                                                    <option value="Gum/glue/gelatin manufacturing">04- Gum/glue/gelatin manufacturing</option>
                                                    <option value="Hosiery, lace, embroidery/thread factories">Hosiery, lace, embroidery/thread factories</option>
                                                    <option value="Ice candy and Ice cream Manufacturing">03- Ice candy and Ice cream Manufacturing</option>
                                                    <option value="Ice factories">03- Ice factories</option>
                                                    <option value="Industrial gas manufacturing">07- Industrial gas manufacturing</option>
                                                    <option value="Jaggery(coarse brown sugar) manufacturing">03- Jaggery(coarse brown sugar) manufacturing</option>
                                                    <option value="Leather cloth factories">07- Leather cloth factories</option>
                                                    <option value="Leather goods manufacturing(incl. boot/shoe)">04- Leather goods manufacturing(incl. boot/shoe)</option>
                                                    <option value="Lime Kiln">03- Lime Kiln</option>
                                                    <option value="LPG(liquified petroleum gas) bottling plants">09- LPG(liquified petroleum gas) bottling plants</option>
                                                    <option value="Manure blending works">04- Manure blending works</option>
                                                    <option value="Match factories">09- Match factories</option>
                                                    <option value="Mattress and pillow making">08- Mattress and pillow making</option>
                                                    <option value="Meat, fish or sea food processing">04- Meat, fish or sea food processing</option>
                                                    <option value="Metal/tin printers">06- Metal/tin printers</option>
                                                    <option value="Mosaic factories">03- Mosaic factories</option>
                                                    <option value="Mushroom growing premises(excluding crops)">03- Mushroom growing premises(excluding crops)</option>
                                                    <option value="Oil extraction">08- Oil extraction</option>
                                                    <option value="Oil distillation plants(essential)">06- Oil distillation plants(essential)</option>
                                                    <option value="Oil Mills refining(veg/animal)">04- Oil Mills refining(veg/animal)</option>
                                                    <option value="Oil and leather cloth factories">07- Oil and leather cloth factories</option>
                                                    <option value="Paint factories(water based)">04- Paint factories(water based)</option>
                                                    <option value="Paint(others) & varnish factories">08- Paint(others) & varnish factories</option>
                                                    <option value="Paper and cardboard mills(including lamination)">05- Paper and cardboard mills(including lamination)</option>
                                                    <option value="Particle board manufacturing">05- Particle board manufacturing</option>
                                                    <option value="Pencil manufacturing">08- Pencil manufacturing</option>
                                                    <option value="Plastic goods manufacturing(excluding foam plastics)">07- Plastic goods manufacturing(excluding foam plastics)</option>
                                                    <option value="Polyester film manufacturing/BOPP film manufacturing">07- Polyester film manufacturing/BOPP film manufacturing</option>
                                                    <option value="Port premises including jetties and equipment thereon and other port facilities">04- Port premises including jetties and equipment thereon and other port facilities</option>
                                                    <option value="Poultry Farms(excluding birds therein)">03- Poultry Farms(excluding birds therein)</option>
                                                    <option value="Presses for coir fibres/waste/grass/fodder/boosa/Jute">09- Presses for coir fibres/waste/grass/fodder/boosa/Jute</option>
                                                    <option value="Presses for coir yarn/cotton/senna leaves">08- Presses for coir yarn/cotton/senna leaves</option>
                                                    <option value="Presses for tobacco carpets and rugs">07- Presses for tobacco carpets and rugs</option>
                                                    <option value="Presses for hides and skins">07- Presses for hides and skins</option>
                                                    <option value="Printing Press">06- Printing Press</option>
                                                    <option value="Pulverizing plants(metals and non-hazardous goods)">03- Pulverizing plants(metals and non-hazardous goods)</option>
                                                    <option value="Pulverizing plants(Others)">07- Pulverizing plants(Others)</option>
                                                    <option value="Rice mills">07- Rice mills</option>
                                                    <option value="Rice polishing units">04- Rice polishing units</option>
                                                    <option value="Rope works(plastic), assembling of plastic goods such as toys and the like">06- Rope works(plastic), assembling of plastic goods such as toys and the like</option>
                                                    <option value="Rope works(others)">03- Rope works(others)</option>
                                                    <option value="Rubber factories">07- Rubber factories</option>
                                                    <option value="Rubber goods manufacturing">07- Rubber goods manufacturing</option>
                                                    <option value="Salt crushing factories and refineries">03- Salt crushing factories and refineries</option>
                                                    <option value="Sanitary napkins/diapers/nappies manufacturers">07- Sanitary napkins/diapers/nappies manufacturers</option>
                                                    <option value="Saw Mills(including timber merchants premises where sawing is done)">09- Saw Mills(including timber merchants premises where sawing is done)</option>
                                                    <option value="Sea Food/meat processing">04- Sea Food/meat processing</option>
                                                    <option value="Sponge iron plants">08- Sponge iron plants</option>
                                                    <option value="Spray Painting, Powder coating">07- Spray Painting, Powder coating</option>
                                                    <option value="Stables(excluding animals)">03- Stables(excluding animals)</option>
                                                    <option value="Starch factories">04- Starch factories</option>
                                                    <option value="Stones quarries">03- Stones quarries</option>
                                                    <option value="Sugar candy manufacturing">04- Sugar candy manufacturing</option>
                                                    <option value="Sugar factories">03- Sugar factories</option>
                                                    <option value="Surgical cotton manufacturing">08- Surgical cotton manufacturing</option>
                                                    <option value="Tanneries">03- Tanneries</option>
                                                    <option value="Tapioca factories">04- Tapioca factories</option>
                                                    <option value="Tarpaulin and canvas proofing factories">08- Tarpaulin and canvas proofing factories</option>
                                                    <option value="Tea blending/packing factories">05- Tea blending/packing factories</option>
                                                    <option value="Tea factories">06- Tea factories</option>
                                                    <option value="Telephone exchanges">03- Telephone exchanges</option>
                                                    <option value="Textiles mills- spinning mills">05- Textiles mills- spinning mills</option>
                                                    <option value="Textiles mills- composite mills">04- Textiles mills- composite mills</option>
                                                    <option value="Tile and pottery works">03- Tile and pottery works</option>
                                                    <option value="Tobacco grinding/crushing Manufacturing">07- Tobacco grinding/crushing Manufacturing</option>
                                                    <option value="Tobacco curing/re-drying factories">07- Tobacco curing/re-drying factories</option>
                                                    <option value="Tyre retreading and resoling factories">07- Tyre retreading and resoling factories</option>
                                                    <option value="Weigh bridges">03- Weigh bridges</option>
                                                    <option value="Weaving mills(no blow room or carding activity)">04- Weaving mills(no blow room or carding activity)</option>
                                                    <option value="Wood seasoning/treatment/impregnation">04- Wood seasoning/treatment/impregnation</option>
                                                    <option value="Woolen mills">04- Woolen mills</option>
                                                    <option value="Cotton Gin and Press Houses">Cotton Gin and Press Houses</option>

                                                </select>

                                            </div>



                                            <div id="risk_makutiDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="risk_makuti"  ><strong>Risk(Makuti/Thatched)<span style="color: red;"> *</span></strong></label>
                                                <span id="risk_makuti_msg"></span>
                                                <select id="risk_makuti" style="width: 100%;"  class="risk_makuti form-control" name="risk_makuti">
                                                    <option value=""></option>
                                                    <option value="Structures completely or substantially of makuti/such material serving functionally as roof or walls">Structures completely or substantially of makuti/such material serving functionally as roof or walls</option>
                                                    <option value="Structures with walls of burnt brick, stone or concrete blocks and roof of RCC slab with makuti/such material without functional value but only as a decorative structure">Structures with walls of burnt brick, stone or concrete blocks and roof of RCC slab with makuti/such material without functional value but only as a decorative structure</option>
                                                    <option value="Identifiable functional units of a large complex with full or partial makuti or such material provided the total covered floor area of such units does not exceed 10% of the total built up floor area of the complex">Identifiable functional units of a large complex with full or partial makuti or such material provided the total covered floor area of such units does not exceed 10% of the total built up floor area of the complex</option>
                                                </select>

                                            </div>



                                            <div id="claim_statusDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="claim_status"  ><strong>Status <span style="color: red;"> *</span></strong></label>
                                                <span id="claim_status_msg"></span>
                                                <select id="claim_status"  class="form-control" name="claim_status" >
                                                    <option value=""></option>
                                                    <option value="Claims free" id="Option">Claims free</option>
                                                    <option value="With claim record" id="Option">With claim record</option>
                                                </select>
                                            </div>


                                            <div id="tppDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="tpp"  ><strong>TPP<span style="color: red;"> *</span></strong></label>
                                                <span id="tpp_msg"></span>
                                                <input type="number" id="tpp" name="tpp" class="form-control" autocomplete="off">
                                            </div>



                                            <div id="carry_passengerDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="carry_passenger"  ><strong>Does the vehicle carry passenger?<span style="color: red;"> *</span></strong></label>
                                                <span id="carry_passenger_msg"></span>
                                                <select id="carry_passenger"  class="form-control" name="carry_passenger" >
                                                    <option value=""></option>
                                                    <option value="Yes" id="Option">Yes</option>
                                                    <option value="No" id="Option">No</option>
                                                </select>
                                            </div>


                                            <div id="number_of_tonnesDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="number_of_tonnes"  ><strong>Number of tonnes<span style="color: red;"> *</span></strong></label>
                                                <span id="number_of_tonnes_msg"></span>
                                                <select id="number_of_tonnes"  class="form-control" name="number_of_tonnes" >
                                                    <option value=""></option>
                                                    <option value="Up to 2 tonnes" id="Option">Up to 2 tonnes</option>
                                                    <option value="Above 2 to 5 tonnes" id="Option">Above 2 to 5 tonnes</option>
                                                    <option value="In excess of 5 tonnes but less than 10 tonnes" id="Option">In excess of 5 tonnes but less than 10 tonnes</option>
                                                    <option value="In excess of 10 tonnes" id="Option">In excess of 10 tonnes</option>
                                                </select>
                                            </div>

                                            <div id="number_of_seatsDiv" style="display: none;" class="form-wrapper col-12">
                                                <br>
                                                <label for="number_of_seats"  ><strong>Number of seats<span style="color: red;"> *</span></strong></label>
                                                <span id="number_of_seats_msg"></span>
                                                <input type="number" id="number_of_seats" name="number_of_seats" class="form-control" autocomplete="off">
                                            </div>


                                            <div id="client_nameDiv" class="form-wrapper col-12" style="display: none;">
                                                <br>
                                                <label for="space_location"  ><strong>Client Name</strong> <span style="color: red;"> *</span></label>
                                                <span id="client_msg"></span>
                                                <input type="text" id="full_name" name="full_name" class="form-control" autocomplete="off">
                                                <div id="nameListClientName"></div>
                                            </div>






                                            <div id="phone_numberDiv" class="form-wrapper col-6 pt-4" style="display: none;">
                                                <label for="phone_number">Phone Number <span style="color: red;"> *</span></label>
                                                <span id="phone_msg"></span>
                                                <input type="text" id="phone_number"  name="phone_number" class="form-control" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
                                            </div>

                                                <div id="emailDiv" class="form-wrapper col-6 pt-4" style="display: none;">
                                                    <label for="email">Email <span style="color: red;"> *</span></label>
                                                    <span id="email_msg"></span>
                                                    <input type="text" name="email"  id="email" class="form-control" placeholder="someone@example.com" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" maxlength="50">
                                                </div>



                                            <div id="tinDiv" class="form-group col-12 pt-4" style="display: none;">
                                                <div class="form-wrapper">
                                                    <label for="tin">TIN <span style="color: red;"> *</span></label>
                                                    <span id="tin_msg"></span>
                                                    <input type="number" id="tin" name="tin" class="form-control"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); minCharacters(this.value);" maxlength = "9">
                                                    <p id="error_tin"></p>
                                                </div>
                                            </div>


                                            <div id="vehicle_registration_noDiv"  class="form-wrapper col-12" style="display: none;">
                                                <br>
                                                <label for="client_type"><strong>Vehicle Registration Number</strong> <span style="color: red;"> *</span></label>
                                                <span id="vehicle_registration_no_msg"></span>
                                                <input type="text" id="vehicle_registration_no" name="vehicle_registration_no" class="form-control"  autocomplete="off">
                                                <div id="nameListVehicleRegistrationNumber"></div>

                                            </div>

                                            <br>

{{--                                            <div id="vehicle_useDiv" class="form-wrapper col-12" style="display: none;">--}}
{{--                                                <label for="vehicle_use"  ><strong>Vehicle Use</strong> <span style="color: red;"> *</span></label>--}}
{{--                                                <span id="vehicle_use_msg"></span>--}}
{{--                                                <select class="form-control" id="vehicle_use" name="vehicle_use">--}}
{{--                                                    <option value="" id="Option"></option>--}}
{{--                                                    <option value="PRIVATE" id="Option" >PRIVATE</option>--}}
{{--                                                    <option value="COMMERCIAL" id="Option">COMMERCIAL</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}





                                        </div>



{{--                                        <table class="table table-bordered table-striped" style="width: 100%">--}}

{{--                                            <tr>--}}
{{--                                                <td>Insurance class</td>--}}
{{--                                                <td><b>MOTOR</b></td>--}}
{{--                                            </tr>--}}


{{--                                            <tr>--}}
{{--                                                <td>Principal:</td>--}}
{{--                                                <td><b></b>BRITAM</td>--}}
{{--                                            </tr>--}}

{{--                                            <tr>--}}
{{--                                                <td> Insurance type</td>--}}
{{--                                                <td><b></b>THIRD PARTY </td>--}}
{{--                                            </tr>--}}


{{--                                            <tr>--}}
{{--                                                <td> Client name:</td>--}}
{{--                                                <td><b></b>Abraham K. Temu </td>--}}
{{--                                            </tr>--}}

{{--                                            <tr>--}}
{{--                                                <td> Phone number:</td>--}}
{{--                                                <td><b></b>0789234587</td>--}}
{{--                                            </tr>--}}


{{--                                            <tr>--}}
{{--                                                <td> Email:</td>--}}
{{--                                                <td><b></b>abtemu@gmail.com </td>--}}
{{--                                            </tr>--}}

{{--                                            <tr>--}}
{{--                                                <td> Vehicle Registration Number:</td>--}}
{{--                                                <td><b></b> T782CBZ</td>--}}
{{--                                            </tr>--}}


{{--                                            <tr>--}}
{{--                                                <td>Vehicle Use:</td>--}}
{{--                                                <td><b></b>PRIVATE</td>--}}
{{--                                            </tr>--}}

{{--                                            <hr>--}}

{{--                                            <p>Payment information</p>--}}

{{--                                            <tr>--}}
{{--                                                <td>Commission date:</td>--}}
{{--                                                <td><b></b>07/12/2020</td>--}}
{{--                                            </tr>--}}

{{--                                            <tr>--}}
{{--                                                <td>Duration:</td>--}}
{{--                                                <td><b></b>1 year</td>--}}
{{--                                            </tr>--}}


{{--                                            <tr>--}}
{{--                                                <td>Sum insured:</td>--}}
{{--                                                <td><b></b>677,780 TZS</td>--}}
{{--                                            </tr>--}}

{{--                                            <tr>--}}
{{--                                                <td>Premium:</td>--}}
{{--                                                <td><b></b>118,000 TZS</td>--}}
{{--                                            </tr>--}}



{{--                                            <tr>--}}
{{--                                                <td>Actual (Excluding VAT):</td>--}}
{{--                                                <td>100000 TZS</td>--}}
{{--                                            </tr>--}}


{{--                                            --}}{{--                                        <tr>--}}
{{--                                            --}}{{--                                            <td>Value:</td>--}}
{{--                                            --}}{{--                                            <td></td>--}}
{{--                                            --}}{{--                                        </tr>--}}

{{--                                            <tr>--}}
{{--                                                <td>Commission percentage:</td>--}}
{{--                                                <td>12.5%</td>--}}
{{--                                            </tr>--}}

{{--                                            <tr>--}}
{{--                                                <td>Commission:</td>--}}
{{--                                                <td>12500 TZS</td>--}}
{{--                                            </tr>--}}


{{--                                            <tr>--}}
{{--                                                <td>Cover note:</td>--}}
{{--                                                <td>1323367</td>--}}
{{--                                            </tr>--}}

{{--                                            <tr>--}}
{{--                                                <td>Sticker no:</td>--}}
{{--                                                <td>12405323</td>--}}
{{--                                            </tr>--}}

{{--                                            <tr>--}}
{{--                                                <td>Receipt no:</td>--}}
{{--                                                <td>965989</td>--}}
{{--                                            </tr>--}}







{{--                                        </table>--}}

    </div>

<p id="availability_status"></p>
                                    <br>
                                    <br>

                                </div>
 <input type="button" name="next" id="next1" class="next action-button" value="Next Step" />
                                <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a>
                            </fieldset>

                            {{-- Third Form --}}
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Payment Information</h2>
				<div class="form-group row">
						<div class="form-wrapper col-12">
							<label for="start_date">Commission Date <span style="color: red;"> *</span></label>
                            <span id="commission_date_msg"></span>
							<input type="date" id="commission_date" name="commission_date" class="form-control"  min="{{$today}}">
						</div>
{{--                    <div class="form-wrapper col-6">--}}
{{--                        <label for="duration">Duration <span style="color: red;"> *</span></label>--}}
{{--                    </div>--}}
                    <input type="hidden"  min="1" max="50" id="duration" name="duration" class="form-control" value="1" >



                    <input type="hidden"  id="duration_period" name="duration_period" class="form-control" value="Years" >


                </div>

					<div class="form-group row">

					<div id="sum_insuredDiv" class="form-wrapper col-12" style="display: none;">
						<label for="amount">Sum Insured <span style="color: red;"> *</span></label>
                        <span id="sum_insured_msg"></span>
						<input type="number"  id="sum_insured" name="sum_insured" class="form-control money_validate" >
					</div>


                        <div id="sum_insured_dropdownDiv" class="form-wrapper col-12" style="display: none;">
                            <label for="sum_insured_dropdown">Sum Insured<span style="color: red;"> *</span></label>
                            <span id="sum_insured_dropdown_msg"></span>
                            <select id="sum_insured_dropdown" style="width: 100%;" class="sum_insured_dropdown form-control" name="sum_insured">
                                <option value="" ></option>
                            </select>
                        </div>


                        <div class="form-wrapper col-12 pt-4">
                            <label for="amount">Actual (Excluding VAT) <span style="color: red;"> *</span></label>
                            <span id="actual_ex_vat_msg"></span>
                            <input type="text" readonly id="actual_ex_vat" name="actual_ex_vat" class="form-control money_validate" >
                        </div>


                        <div id="premiumDiv" class="form-wrapper col-12">
                            <label for="amount">Premium </label>
                            <span id="premium_msg"></span>
{{--                            <input type="text" id="premium" readonly name="premium" autocomplete="off" class="form-control">--}}
                            <input type="text" id="premium"  name="premium" readonly autocomplete="off" class="form-control">
                        </div>

                        <div id="mode_of_paymentDiv" class="form-wrapper col-12" style="display: none;">
                            <label for="mode_of_payment">Mode of payment <span style="color: red;"> *</span></label>
                            <span id="mode_of_payment_msg"></span>
                            <select id="mode_of_payment" class="form-control" name="mode_of_payment" >
                                <option value="" ></option>
                                <option value="By installment" >By installment</option>
                                <option value="Full payment" >Full payment</option>
                            </select>
                            <p id="clause" class="pt-4" style="display: none; "><b>N.B: </b> Client will be assisted in case of anything only after paying the full amount</p>

                        </div>


                        <div id="number_of_installmentsDiv" class="form-wrapper col-12 pt-4" style="display: none;">
                            <label for="amount">Number of installments </label>
                            <span id="number_of_installments_msg"></span>
                            <input type="number" min="2" id="number_of_installments" name="number_of_installments" class="form-control">
                        </div>


                        <div id="first_installmentDiv" class="form-wrapper  pt-4" style="display: none;">
                            <label for="amount">First installment </label>
                            <span id="first_installment_msg"></span>
                            <input type="number" id="first_installment"  name="first_installment" class="form-control money_validate">
                        </div>


                        <div id="second_installmentDiv" class="form-wrapper  pt-4" style="display: none;">
                            <label for="amount">Second installment </label>
                            <span id="second_installment_msg"></span>
                            <input type="number" id="second_installment"  name="second_installment" class="form-control money_validate">
                        </div>


                        <div id="third_installmentDiv" class="form-wrapper  pt-4" style="display: none;">
                            <label for="amount">Third installment </label>
                            <span id="third_installment_msg"></span>
                            <input type="number" id="third_installment"  name="third_installment" class="form-control money_validate">
                        </div>


                        <div id="fourth_installmentDiv" class="form-wrapper  pt-4" style="display: none;">
                            <label for="amount">Fourth installment </label>
                            <span id="fourth_installment_msg"></span>
                            <input type="number" id="fourth_installment"  name="fourth_installment" class="form-control money_validate">
                        </div>



                        <div id="fifth_installmentDiv" class="form-wrapper  pt-4" style="display: none;">
                            <label for="amount">Fifth installment </label>
                            <span id="fifth_installment_msg"></span>
                            <input type="number" id="fifth_installment"  name="fifth_installment" class="form-control money_validate">
                        </div>


                        <div id="sixth_installmentDiv" class="form-wrapper  pt-4" style="display: none;">
                            <label for="amount">Sixth installment </label>
                            <span id="sixth_installment_msg"></span>
                            <input type="number" id="sixth_installment"  name="sixth_installment" class="form-control money_validate">
                        </div>


                        <div id="seventh_installmentDiv" class="form-wrapper  pt-4" style="display: none;">
                            <label for="amount">Seventh installment </label>
                            <span id="seventh_installment_msg"></span>
                            <input type="number" id="seventh_installment"  name="seventh_installment" class="form-control money_validate">
                        </div>


                        <div id="eighth_installmentDiv" class="form-wrapper  pt-4" style="display: none;">
                            <label for="amount">Eighth installment</label>
                            <span id="eighth_installment_msg"></span>
                            <input type="number" id="eighth_installment"  name="eighth_installment" class="form-control money_validate">
                        </div>

                        <div id="ninth_installmentDiv" class="form-wrapper  pt-4" style="display: none;">
                            <label for="amount">Ninth installment</label>
                            <span id="ninth_installment_msg"></span>
                            <input type="number" id="ninth_installment"  name="ninth_installment" class="form-control money_validate">
                        </div>

                        <div id="tenth_installmentDiv" class="form-wrapper  pt-4" style="display: none;">
                            <label for="amount">Tenth installment</label>
                            <span id="tenth_installment_msg"></span>
                            <input type="number" id="tenth_installment"  name="tenth_installment" class="form-control money_validate">
                        </div>


                        <div id="eleventh_installmentDiv" class="form-wrapper  pt-4" style="display: none;">
                            <label for="amount">Eleventh installment</label>
                            <span id="eleventh_installment_msg"></span>
                            <input type="number" id="eleventh_installment"  name="eleventh_installment" class="form-control money_validate">
                        </div>

                        <div id="twelfth_installmentDiv" class="form-wrapper  pt-4" style="display: none;">
                            <label for="amount">Twelfth installment</label>
                            <span id="twelfth_installment_msg"></span>
                            <input type="number" id="twelfth_installment"  name="twelfth_installment" class="form-control money_validate">
                        </div>




				</div>

                                    <div class="form-group row">



                                        <div id="valueDiv" style="display: none;" class="form-wrapper col-12">
                                            <label for="amount">Value <span style="color: red;"> *</span></label>
                                            <span id="value_msg"></span>
                                            <input type="number" min="20" id="value" name="value" class="form-control money_validate" >
                                        </div>


                                    </div>

                                    <div class="form-group row">

                                        <div class="form-wrapper col-6">
                                            <label for="amount">Commission(%) <span style="color: red;"> *</span></label>
                                            <input type="text" min="1"  step="0.01" class="form-control"  readonly name="commission_percentage"  value=""  id="commission_percentage" autocomplete="off">
                                        </div>

                                        <div class="form-wrapper col-6">
                                            <label for="amount">Commission <span style="color: red;"> *</span></label>
                                            <input type="text"  id="commission"  class="form-control" name="commission" value=""  readonly autocomplete="off">
                                        </div>


                                        <div class="form-wrapper col-12">
                                            <label for="currency">Currency <span style="color: red;"> *</span></label>
                                            <span id="currency_msg"></span>
                                            <select id="currency" class="form-control" name="currency">
                                                <option value="" ></option>
                                                <option value="TZS" >TZS</option>
                                                <option value="USD" >USD</option>
                                            </select>
                                        </div>



                                        <div id="cover_noteDiv" style="display: none;" class="form-wrapper col-6 pt-4">
                                            <label for="amount">Cover note<span style="color: red;"> *</span></label>
                                            <span id="cover_note_msg"></span>
                                            <input type="text" id="cover_note" name="cover_note" class="form-control">
                                        </div>

                                        <div id="sticker_noDiv" style="display: none;" class="form-wrapper col-6 pt-4">
                                            <label for="amount">Sticker number <span style="color: red;"> *</span></label>
                                            <span id="sticker_no_msg"></span>
                                            <input type="text" id="sticker_no" name="sticker_no" class="form-control">
                                        </div>


                                        <div class="form-wrapper col-12 pt-4">
                                            <label for="amount">Receipt Number <span style="color: red;"> *</span></label>
                                            <span id="receipt_no_msg"></span>
                                            <input type="text" id="receipt_no" name="receipt_no" class="form-control" >
                                        </div>


                                    </div>




                                    <p id="validate_money_msg"></p>
                                    <br>
                                    <br>



                                </div>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                <input type="button" name="next" id="next2" class="submit action-button" value="Next"/>
                                <a href="/contracts_management" style="background-color: red !important;" class="btn  action-button" >Cancel</a>
                            </fieldset>


{{--                            Preview--}}
                            <fieldset>
                                <div class="form-card">
                                    <h2 style="text-align: center !important;" class="fs-title">Full contract details</h2>
                                    <table class="table table-bordered table-striped" style="width: 100%; margin-top:3%;">



                                        <tr>
                                            <td>Insurance class</td>
                                            <td id="insurance_class_confirm"></td>
                                        </tr>


                                        <tr>
                                            <td>Principal:</td>
                                            <td id="insurance_company_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td>Insurance type</td>
                                            <td id="insurance_type_confirm"> </td>
                                        </tr>


                                        <tr>
                                            <td>Client name:</td>
                                            <td id="client_name_confirm"> </td>
                                        </tr>

                                        <tr>
                                            <td> Phone number:</td>
                                            <td id="phone_number_confirm"></td>
                                        </tr>


                                        <tr>
                                            <td> Email:</td>
                                            <td id="email_confirm"> </td>
                                        </tr>

                                        <tr id="vehicle_registration_no_row_confirm" style="display: none;">
                                            <td> Vehicle Registration Number:</td>
                                            <td id="vehicle_registration_no_confirm"> </td>
                                        </tr>


{{--                                        <tr id="vehicle_use_row_confirm" style="display: none;">--}}
{{--                                            <td>Vehicle Use:</td>--}}
{{--                                            <td id="vehicle_use_confirm"></td>--}}
{{--                                        </tr>--}}



                                        <tr>
                                            <td>Commission date:</td>
                                            <td id="commission_date_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td>Duration:</td>
                                            <td><b>1 year</b></td>
                                        </tr>


                                        <tr>
                                            <td>Sum insured:</td>
                                            <td id="sum_insured_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td>Premium:</td>
                                            <td id="premium_confirm"></td>
                                        </tr>



                                        <tr id="mode_of_payment_row_confirm" style="display: none;">
                                            <td>Mode of payment:</td>
                                            <td id="mode_of_payment_confirm"></td>
                                        </tr>


                                        <tr id="number_of_installments_row_confirm" style="display: none;">
                                            <td>Number of installments:</td>
                                            <td id="number_of_installments_confirm"></td>
                                        </tr>


                                        <tr id="first_installment_row_confirm" style="display: none;">
                                            <td>First installment:</td>
                                            <td id="first_installment_confirm"></td>
                                        </tr>


                                        <tr id="second_installment_row_confirm" style="display: none;">
                                            <td>Second installment:</td>
                                            <td id="second_installment_confirm"></td>
                                        </tr>


                                        <tr id="third_installment_row_confirm" style="display: none;">
                                            <td>Third installment:</td>
                                            <td id="third_installment_confirm"></td>
                                        </tr>

                                        <tr id="fourth_installment_row_confirm" style="display: none;">
                                            <td>Fourth installment:</td>
                                            <td id="fourth_installment_confirm"></td>
                                        </tr>


                                        <tr id="fifth_installment_row_confirm" style="display: none;">
                                            <td>Fifth installment:</td>
                                            <td id="fifth_installment_confirm"></td>
                                        </tr>


                                        <tr id="sixth_installment_row_confirm" style="display: none;">
                                            <td>Sixth installment:</td>
                                            <td id="sixth_installment_confirm"></td>
                                        </tr>


                                        <tr id="seventh_installment_row_confirm" style="display: none;">
                                            <td>Seventh installment:</td>
                                            <td id="seventh_installment_confirm"></td>
                                        </tr>


                                        <tr id="eighth_installment_row_confirm" style="display: none;">
                                            <td>Eighth installment:</td>
                                            <td id="eighth_installment_confirm"></td>
                                        </tr>


                                        <tr id="ninth_installment_row_confirm" style="display: none;">
                                            <td>Ninth installment:</td>
                                            <td id="ninth_installment_confirm"></td>
                                        </tr>


                                        <tr id="tenth_installment_row_confirm" style="display: none;">
                                            <td>Tenth installment:</td>
                                            <td id="tenth_installment_confirm"></td>
                                        </tr>

                                        <tr id="eleventh_installment_row_confirm" style="display: none;">
                                            <td>Eleventh installment:</td>
                                            <td id="eleventh_installment_confirm"></td>
                                        </tr>


                                        <tr id="twelfth_installment_row_confirm" style="display: none;">
                                            <td>Twelfth installment:</td>
                                            <td id="twelfth_installment_confirm"></td>
                                        </tr>





                                        <tr>
                                            <td>Actual (Excluding VAT):</td>
                                            <td id="actual_ex_vat_confirm"></td>
                                        </tr>


                                        <tr id="value_row_confirm" style="display: none;" >
                                            <td>Value:</td>
                                            <td id="value_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td>Commission percentage:</td>
                                            <td id="commission_percentage_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td>Commission:</td>
                                            <td id="commission_confirm"></td>
                                        </tr>


                                        <tr id="cover_note_row_confirm" style="display: none;">
                                            <td>Cover note:</td>
                                            <td id="cover_note_confirm"></td>
                                        </tr>

                                        <tr id="sticker_no_row_confirm" style="display: none;">
                                            <td>Sticker number:</td>
                                            <td id="sticker_no_confirm"></td>
                                        </tr>

                                        <tr>
                                            <td>Receipt number:</td>
                                            <td id="receipt_no_confirm"></td>
                                        </tr>







                                    </table>


                                </div>
                                <input type="button" id="previous5" name="previous" class="previous action-button-previous" value="Previous"/>
                                <input type="submit" id="submit5" name="submit" class="submit action-button" value="Save"/>
                                <input type="submit" id="save_and_print_btn"  onclick="openNewTab();" name="submit" class="submit action-button" value="Save and print"/>
                                <input type="button" id="cancel5" class="btn btn-danger action-button" value="Cancel" onclick="history.back()" style="background-color: red !important;">

                            </fieldset>





                        </form>
                    </div>
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

            $('#insurance_class').click(function() {


                $('#vehicle_classDiv').hide();
                $('#TypeDiv').hide();
                $('#number_of_employeesDiv').hide();
                $('#Type_moneyDiv').hide();
                $('#Type_liabilityDiv').hide();
                $('#commodityDiv').hide();
                $('#marine_containerizedDiv').hide();
                $('#type_of_riskDiv').hide();
                $('#group_of_riskDiv').hide();
                $('#risk_non_manufacturingDiv').hide();
                $('#risk_storageDiv').hide();
                $('#stateDiv').hide();
                $('#risk_manufacturingDiv').hide();
                $('#risk_makutiDiv').hide();
                $('#claim_statusDiv').hide();
                $('#tppDiv').hide();
                $('#carry_passengerDiv').hide();
                $('#number_of_tonnesDiv').hide();
                $('#number_of_seatsDiv').hide();





                var query3=$(this).val();
                if(query3!=''){

                    $('#insurance_companyDiv').show();

                }
                else{
                    $('#insurance_companyDiv').hide();
                    $('#TypeDiv').hide();

                    var ele4 = document.getElementById("insurance_type");
                    ele4.required = false;
                    $('#TypeDivNA').hide();
                    document.getElementById("insurance_type_na").disabled = true;
                    $('#client_nameDiv').hide();
                    $('#phone_numberDiv').hide();
                    $('#emailDiv').hide();
                    $('#tinDiv').hide();
                    $('#vehicle_registration_noDiv').hide();
                    // $('#vehicle_useDiv').hide();

                }

                if($('#TypeDivNA:visible').length!=0) {
                    var query=$('#insurance_class').val();
                    if(query=='MOTOR'){
                        $('#TypeDiv').show();
                        $('#TypeDivNA').hide();

                        $('#cover_noteDiv').show();
                        document.getElementById("cover_note").disabled = false;
                        var ele = document.getElementById("cover_note");
                        ele.required = true;

                        // $('#vehicle_useDiv').show();
                        // document.getElementById("vehicle_use").disabled = false;

                        $('#vehicle_registration_noDiv').show();
                        document.getElementById("vehicle_registration_no").disabled = false;

                        $('#client_nameDiv').show();
                        $('#phone_numberDiv').show();
                        $('#emailDiv').show();
                        $('#tinDiv').show();

                        $('#sticker_noDiv').show();
                        document.getElementById("sticker_no").disabled = false;
                        var ele2 = document.getElementById("sticker_no");
                        ele2.required = true;

                        $('#valueDiv').hide();
                        document.getElementById("value").disabled = true;
                        var ele7 = document.getElementById("value");
                        ele7.required = false;


                        document.getElementById("insurance_type_na").disabled = true;

                        //Show vehicle class div
                        $('#vehicle_classDiv').show();



                    }else{
                        $('#TypeDiv').hide();
                        var ele5 = document.getElementById("insurance_type");
                        ele5.required = false;
                        $('#TypeDivNA').show();
                        document.getElementById("insurance_type_na").disabled = false;


                        $('#cover_noteDiv').hide();
                        document.getElementById("cover_note").disabled = true;
                        var ele = document.getElementById("cover_note");
                        ele.required = false;

                        // $('#vehicle_useDiv').hide();
                        // document.getElementById("vehicle_use").disabled = true;

                        $('#vehicle_registration_noDiv').hide();
                        document.getElementById("vehicle_registration_no").disabled = true;

                        $('#client_nameDiv').show();
                        $('#phone_numberDiv').show();
                        $('#emailDiv').show();
                        $('#tinDiv').show();

                        $('#sticker_noDiv').hide();
                        document.getElementById("sticker_no").disabled = true;
                        var ele2 = document.getElementById("sticker_no");
                        ele2.required = false;

                        $('#valueDiv').show();
                        document.getElementById("value").disabled = false;
                        var ele7 = document.getElementById("value");
                        ele7.required = true;


                        //Hide vehicle class div
                        $('#vehicle_classDiv').hide();

                    }
                }else if($('#TypeDiv:visible').length!=0){
                    //starts
                    var query=$('#insurance_class').val();
                    if(query=='MOTOR'){
                        $('#TypeDiv').show();
                        $('#TypeDivNA').hide();

                        $('#cover_noteDiv').show();
                        document.getElementById("cover_note").disabled = false;
                        var ele = document.getElementById("cover_note");
                        ele.required = true;

                        // $('#vehicle_useDiv').show();
                        // document.getElementById("vehicle_use").disabled = false;

                        $('#vehicle_registration_noDiv').show();
                        document.getElementById("vehicle_registration_no").disabled = false;
                        $('#client_nameDiv').show();
                        $('#phone_numberDiv').show();
                        $('#emailDiv').show();
                        $('#tinDiv').show();

                        $('#sticker_noDiv').show();
                        document.getElementById("sticker_no").disabled = false;
                        var ele2 = document.getElementById("sticker_no");
                        ele2.required = true;

                        $('#valueDiv').hide();
                        document.getElementById("value").disabled = true;
                        var ele7 = document.getElementById("value");
                        ele7.required = false;


                        document.getElementById("insurance_type_na").disabled = true;

                        //Show vehicle class div
                        $('#vehicle_classDiv').show();


                    }else{
                        $('#TypeDiv').hide();
                        var ele6 = document.getElementById("insurance_type");
                        ele6.required = false;
                        $('#TypeDivNA').show();
                        document.getElementById("insurance_type_na").disabled = false;

                        $('#cover_noteDiv').hide();
                        document.getElementById("cover_note").disabled = true;
                        var ele = document.getElementById("cover_note");
                        ele.required = false;


                        // $('#vehicle_useDiv').hide();
                        // document.getElementById("vehicle_use").disabled = true;

                        $('#vehicle_registration_noDiv').hide();
                        document.getElementById("vehicle_registration_no").disabled = true;

                        $('#client_nameDiv').show();
                        $('#phone_numberDiv').show();
                        $('#emailDiv').show();
                        $('#tinDiv').show();

                        $('#sticker_noDiv').hide();
                        document.getElementById("sticker_no").disabled = true;
                        var ele2 = document.getElementById("sticker_no");
                        ele2.required = false;

                        $('#valueDiv').show();
                        document.getElementById("value").disabled = false;
                        var ele7 = document.getElementById("value");
                        ele7.required = true;



                        //hide vehicle class div
                        $('#vehicle_classDiv').hide();


                    }
                    //ends
                }else{


                }








            });

            $('#insurance_company').click(function(){
                var query3=$(this).val();
                if(query3!=''){
                    var insurance_class=document.getElementById("insurance_class").value;
                    if(query3==''){

                    }

                    else if(insurance_class=='MOTOR'){

                        $('#cover_noteDiv').show();
                        document.getElementById("cover_note").disabled = false;
                        var ele = document.getElementById("cover_note");
                        ele.required = true;


                        // $('#vehicle_useDiv').show();
                        // document.getElementById("vehicle_use").disabled = false;

                        $('#vehicle_registration_noDiv').show();
                        document.getElementById("vehicle_registration_no").disabled = false;

                        $('#client_nameDiv').show();
                        $('#phone_numberDiv').show();
                        $('#emailDiv').show();
                        $('#tinDiv').show();

                        $('#sticker_noDiv').show();
                        document.getElementById("sticker_no").disabled = false;
                        var ele2 = document.getElementById("sticker_no");
                        ele2.required = true;

                        $('#valueDiv').hide();
                        document.getElementById("value").disabled = true;
                        var ele7 = document.getElementById("value");
                        ele7.required = false;

                        $('#TypeDiv').show();

                        //show vehicle class div
                        $('#vehicle_classDiv').show();

                    }else{

                        $('#TypeDivNA').show();
                        document.getElementById("insurance_type_na").disabled = false;

                        $('#cover_noteDiv').hide();
                        document.getElementById("cover_note").disabled = true;
                        var ele = document.getElementById("cover_note");
                        ele.required = false;

                        // $('#vehicle_useDiv').hide();
                        // document.getElementById("vehicle_use").disabled = true;

                        $('#vehicle_registration_noDiv').hide();
                        document.getElementById("vehicle_registration_no").disabled = true;

                        $('#client_nameDiv').show();
                        $('#phone_numberDiv').show();
                        $('#emailDiv').show();
                        $('#tinDiv').show();

                        $('#sticker_noDiv').hide();
                        document.getElementById("sticker_no").disabled = true;
                        var ele2 = document.getElementById("sticker_no");
                        ele2.required = false;

                        $('#valueDiv').show();
                        document.getElementById("value").disabled = false;
                        var ele7 = document.getElementById("value");
                        ele7.required = true;



                        //hide vehicle class div
                        $('#vehicle_classDiv').hide();


                    }

                    // $('#client_nameDiv').hide();
                    // $('#phone_numberDiv').hide();
                    // $('#emailDiv').hide();
                    // $('#vehicle_registration_noDiv').hide();
                    // $('#vehicle_useDiv').hide();
                }
                else{
                    $('#TypeDiv').hide();
                    var ele7 = document.getElementById("insurance_type");
                    ele7.required = false;

                    $('#TypeDivNA').hide();
                    $('#client_nameDiv').hide();
                    $('#phone_numberDiv').hide();
                    $('#emailDiv').hide();
                    $('#tinDiv').hide();
                    $('#vehicle_registration_noDiv').hide();
                    // $('#vehicle_useDiv').hide();


                    document.getElementById("insurance_type_na").disabled = true;
                }


                if(insurance_class=='FIRE'){
                    $('#type_of_riskDiv').show();

                }else{
                    $('#type_of_riskDiv').hide();

                }




                if(insurance_class=='MONEY'){

                    $('#Type_moneyDiv').show();

                }else{

                    $('#Type_moneyDiv').hide();

                }


                if(insurance_class=='LIABILITY'){

                    $('#Type_liabilityDiv').show();

                }else{

                    $('#Type_liabilityDiv').hide();

                }


                if(insurance_class=='MARINE'){

                    $('#commodityDiv').show();
                    $('#marine_containerizedDiv').show();

                }else{


                    $('#commodityDiv').hide();
                    $('#marine_containerizedDiv').hide();

                }



                if(insurance_class=='FIDELITY GUARANTEE'){

                    $('#number_of_employeesDiv').show();

                }else{

                    $('#number_of_employeesDiv').hide();


                }





            });





            $('#type_of_risk').click(function(){

                var type_of_risk=$(this).val();

                if (type_of_risk=='Class 1 construction risks' || type_of_risk=='Other'){

                   $('#group_of_riskDiv').show();
                    $('#risk_makutiDiv').hide();

                }else{
                    $('#group_of_riskDiv').hide();
                }

                if (type_of_risk=='Makuti/Thatched risks' ){

                    $('#risk_makutiDiv').show();
                    $('#risk_storageDiv').hide();
                    $('#risk_non_manufacturingDiv').hide();
                    $('#risk_manufacturingDiv').hide();
                    $('#stateDiv').hide();
                }else{
                    $('#risk_makutiDiv').hide();
                }



            });



            $('#group_of_risk').click(function(){

                var group_of_risk=$(this).val();

                if (group_of_risk=='Non-manufacturing risks'){

                    $('#risk_non_manufacturingDiv').show();
                }else{
                    $('#risk_non_manufacturingDiv').hide();
                }



                if (group_of_risk=='Storage risks'){

                    $('#risk_storageDiv').show();
                    $('#stateDiv').show();

                }else{
                    $('#risk_storageDiv').hide();
                    $('#stateDiv').hide();
                }



                if (group_of_risk=='Manufacturing/industrial risks'){

                    $('#risk_manufacturingDiv').show();
                }else{
                    $('#risk_manufacturingDiv').hide();
                }



            });





            //When vehicle class is selected starts
            $('#vehicle_class').click(function(){
                var query3=$(this).val();



                if(query3!=''){

                    if(query3==''){

                    }
//                 //Rough sject starts
//                     <option value=""></option>
//                     <option value="COMPREHENSIVE" id="Option" >COMPREHENSIVE</option>
//                     <option value="TPFT" id="Option" >TPFT</option>
//                     <option value="TPO" id="Option" >TPO</option>
// ////
//                     <option value=""></option>
//                     <option value="COMPREHENSIVE(THREE WHEELERS)" id="Option" >COMPREHENSIVE(THREE WHEELERS)</option>
//                     <option value="COMPREHENSIVE(TWO WHEELERS)" id="Option" >COMPREHENSIVE(TWO WHEELERS)</option>
//                     <option value="TPFT(THREE WHEELERS)" id="Option" >TPFT(THREE WHEELERS)</option>
//                     <option value="TPFT(TWO WHEELERS)" id="Option" >TPFT(TWO WHEELERS)</option>
//                     <option value="TPO(THREE WHEELERS)" id="Option" >TPO(THREE WHEELERS)</option>
//                     <option value="TPO(TWO WHEELERS)" id="Option" >TPO(TWO WHEELERS)</option>
// ////
//
//
//                 //Rough special type starts
//                     <option value=""></option>
//                     <option value="COMPREHENSIVE" id="Option" >COMPREHENSIVE</option>
//                     <option value="THIRD PARTY" id="Option" >THIRD PARTY</option>
//                 //
//
//
//
//                 //Rough passwnger carrying starts
//                     <option value=""></option>
//                     <option value="COMPREHENSIVE(Public Taxis, private hire and tour operators)" id="Option" >COMPREHENSIVE(Public Taxis, private hire and tour operators)</option>
//                     <option value="COMPREHENSIVE(Buses-Daladala within city)" id="Option" >COMPREHENSIVE(Buses-Daladala within city)</option>
//                     <option value="COMPREHENSIVE(Buses- Up country)" id="Option" >COMPREHENSIVE(Buses- Up country)</option>
//                     <option value="COMPREHENSIVE(Buses- Private)" id="Option" >COMPREHENSIVE(Buses- Private)</option>
//                     <option value="COMPREHENSIVE(Buses- School)" id="Option" >COMPREHENSIVE(Buses- School)</option>
//
//                     <option value="THIRD PARTY(Public Taxis, private hire and tour operators)" id="Option" >THIRD PARTY(Public Taxis, private hire and tour operators)</option>
//                 <option value="THIRD PARTY(Buses-Daladala within city)" id="Option" >THIRD PARTY(Buses-Daladala within city)</option>
//                 <option value="THIRD PARTY(Buses- Up country)" id="Option" >THIRD PARTY(Buses- Up country)</option>
//                 <option value="THIRD PARTY(Buses- Private)" id="Option" >THIRD PARTY(Buses- Private)</option>
//                     <option value="THIRD PARTY(Buses- School)" id="Option" >THIRD PARTY(Buses- School)</option>
//
//                 //
//
//
//
//                 //COMERCIAL STARTS
//
//
//
//
//
//
//
//
//                     <option value=""></option>
//                         <option value="COMPREHENSIVE(Own goods)">COMPREHENSIVE(Own goods)</option>
//                     <option value="TPFT(Own goods)">TPFT(Own goods)</option>
//                     <option value="General Cartage">General Cartage</option>
//                     <option value="TPFT(General Cartage)">TPFT(General Cartage)</option>
//                     <option value="TPO">TPO</option>
//                     <option value="COMPREHENSIVE(Trailers manufactured locally/bought from the dealer and less than 10 years old)" id="Option" >COMPREHENSIVE(Trailers manufactured locally/bought from the dealer and less than 10 years old)</option>
//                      <option value="COMPREHENSIVE(Buses-Daladala within city)" id="Option" >COMPREHENSIVE(Buses-Daladala within city)</option>
//                     <option value="COMPREHENSIVE(Conversion trailers or trailers over 10)" id="Option" >COMPREHENSIVE(Conversion trailers or trailers over 10)</option>
//                     <option value="THIRD PARTY ONLY(Trailers)" id="Option" >THIRD PARTY ONLY(Trailers)</option>
//                     <option value="COMPREHENSIVE(Steel tankers below 10 years)" id="Option" >COMPREHENSIVE(Steel tankers below 10 years)</option>
//                     <option value="COMPREHENSIVE(Aluminium tankers below)" id="Option" >COMPREHENSIVE(Aluminium tankers below)</option>
//                     <option value="COMPREHENSIVE(Tankers over 10 years old)" id="Option" >COMPREHENSIVE(Tankers over 10 years old)</option>
//                     <option value="TPFT(Tankers)" id="Option" >TPFT(Tankers)</option>
//                     <option value="TPO(Tankers)" id="Option" >TPO(Tankers)</option>
//
//
//
//                 //COMERCIAL ENDS
//
//
//
// //Rough sketch ends


                    else if(query3=='Private Cars'){

                        $('#insurance_type').html('<option value=""></option>\n' +
                            '                    <option value="COMPREHENSIVE" id="Option" >COMPREHENSIVE</option>\n' +
                            '                    <option value="TPFT" id="Option" >TPFT</option>\n' +
                            '                    <option value="TPO" id="Option" >TPO</option>');

                    }

                    else if(query3=='M/cycle/3 Wheelers'){

                        $('#insurance_type').html('<option value=""></option>\n' +
                            '                    <option value="COMPREHENSIVE(THREE WHEELERS)" id="Option" >COMPREHENSIVE(THREE WHEELERS)</option>\n' +
                            '                    <option value="COMPREHENSIVE(TWO WHEELERS)" id="Option" >COMPREHENSIVE(TWO WHEELERS)</option>\n' +
                            '                    <option value="TPFT(THREE WHEELERS)" id="Option" >TPFT(THREE WHEELERS)</option>\n' +
                            '                    <option value="TPFT(TWO WHEELERS)" id="Option" >TPFT(TWO WHEELERS)</option>\n' +
                            '                    <option value="TPO(THREE WHEELERS)" id="Option" >TPO(THREE WHEELERS)</option>\n' +
                            '                    <option value="TPO(TWO WHEELERS)" id="Option" >TPO(TWO WHEELERS)</option>');

                    }


                    else if(query3=='Commercial Vehicles'){

                        $('#insurance_type').html('<option value=""></option>\n' +
                            '                        <option value="COMPREHENSIVE(Own goods)">COMPREHENSIVE(Own goods)</option>\n' +
                            '                    <option value="TPFT(Own goods)">TPFT(Own goods)</option>\n' +
                            '                    <option value="General Cartage">General Cartage</option>\n' +
                            '                    <option value="TPFT(General Cartage)">TPFT(General Cartage)</option>\n' +
                            '                    <option value="TPO">TPO</option>\n' +
                            '                    <option value="COMPREHENSIVE(Trailers manufactured locally/bought from the dealer and less than 10 years old)" id="Option" >COMPREHENSIVE(Trailers manufactured locally/bought from the dealer and less than 10 years old)</option>\n' +
                            '                     <option value="COMPREHENSIVE(Buses-Daladala within city)" id="Option" >COMPREHENSIVE(Buses-Daladala within city)</option>\n' +
                            '                    <option value="COMPREHENSIVE(Conversion trailers or trailers over 10)" id="Option" >COMPREHENSIVE(Conversion trailers or trailers over 10)</option>\n' +
                            '                    <option value="THIRD PARTY ONLY(Trailers)" id="Option" >THIRD PARTY ONLY(Trailers)</option>\n' +
                            '                    <option value="COMPREHENSIVE(Steel tankers below 10 years)" id="Option" >COMPREHENSIVE(Steel tankers below 10 years)</option>\n' +
                            '                    <option value="COMPREHENSIVE(Aluminium tankers below)" id="Option" >COMPREHENSIVE(Aluminium tankers below)</option>\n' +
                            '                    <option value="COMPREHENSIVE(Tankers over 10 years old)" id="Option" >COMPREHENSIVE(Tankers over 10 years old)</option>\n' +
                            '                    <option value="TPFT(Tankers)" id="Option" >TPFT(Tankers)</option>\n' +
                            '                    <option value="TPO(Tankers)" id="Option" >TPO(Tankers)</option>');

                    }


                    else if(query3=='Passenger Carrying'){

                        $('#insurance_type').html(' <option value=""></option>\n' +
                            '                    <option value="COMPREHENSIVE(Public Taxis, private hire and tour operators)" id="Option" >COMPREHENSIVE(Public Taxis, private hire and tour operators)</option>\n' +
                            '                    <option value="COMPREHENSIVE(Buses-Daladala within city)" id="Option" >COMPREHENSIVE(Buses-Daladala within city)</option>\n' +
                            '                    <option value="COMPREHENSIVE(Buses- Up country)" id="Option" >COMPREHENSIVE(Buses- Up country)</option>\n' +
                            '                    <option value="COMPREHENSIVE(Buses- Private)" id="Option" >COMPREHENSIVE(Buses- Private)</option>\n' +
                            '                    <option value="COMPREHENSIVE(Buses- School)" id="Option" >COMPREHENSIVE(Buses- School)</option>\n' +
                            '\n' +
                            '                    <option value="THIRD PARTY(Public Taxis, private hire and tour operators)" id="Option" >THIRD PARTY(Public Taxis, private hire and tour operators)</option>\n' +
                            '                <option value="THIRD PARTY(Buses-Daladala within city)" id="Option" >THIRD PARTY(Buses-Daladala within city)</option>\n' +
                            '                <option value="THIRD PARTY(Buses- Up country)" id="Option" >THIRD PARTY(Buses- Up country)</option>\n' +
                            '                <option value="THIRD PARTY(Buses- Private)" id="Option" >THIRD PARTY(Buses- Private)</option>\n' +
                            '                    <option value="THIRD PARTY(Buses- School)" id="Option" >THIRD PARTY(Buses- School)</option>');

                    }


                    else if(query3=='Special Type Vehicles'){

                        $('#insurance_type').html('<option value=""></option>\n' +
                            '                    <option value="COMPREHENSIVE" id="Option" >COMPREHENSIVE</option>\n' +
                            '                    <option value="THIRD PARTY" id="Option" >THIRD PARTY</option>');

                    }

                    else{


                    }


                }
                else{



                }



            });




            $('#insurance_type').click(function() {
                var insurance_type = $(this).val();
                var vehicle_class = $('#vehicle_class').val();

                //Private cars
                    if(vehicle_class=='Private Cars') {

                        //Show or hide claims div
                        if(insurance_type=='COMPREHENSIVE'){
                           $('#claim_statusDiv').show();
                        }else if(insurance_type=='TPFT'){

                            $('#tppDiv').show();
                            $('#claim_statusDiv').hide();

                        } else{
                            $('#claim_statusDiv').hide();
                            $('#tppDiv').hide();
                        }






                    }else if(vehicle_class=='M/cycle/3 Wheelers'){

                        //Show or hide claims div
                        if(insurance_type=='COMPREHENSIVE(THREE WHEELERS)' || insurance_type=='COMPREHENSIVE(TWO WHEELERS)'){
                            $('#claim_statusDiv').show();
                            $('#tppDiv').hide();
                        }else if(insurance_type=='TPFT(THREE WHEELERS)' || insurance_type=='TPFT(TWO WHEELERS)' ){

                            $('#tppDiv').show();
                            $('#claim_statusDiv').hide();
                        }
                        else{
                            $('#claim_statusDiv').hide();
                            $('#tppDiv').hide();
                        }

                        //Carry passenger
                        if(insurance_type=='COMPREHENSIVE(THREE WHEELERS)' || insurance_type=='COMPREHENSIVE(TWO WHEELERS)' || insurance_type=='TPO(THREE WHEELERS)' || insurance_type=='TPO(TWO WHEELERS)'){
                            $('#carry_passengerDiv').show();
                        }else{
                            $('#carry_passengerDiv').hide();
                        }





                    }else if(vehicle_class=='Passenger Carrying'){

                        //Show or hide claims div
                        if(insurance_type=='COMPREHENSIVE(Public Taxis, private hire and tour operators)'){
                            $('#claim_statusDiv').show();
                        }else{
                            $('#claim_statusDiv').hide();
                        }


                        //Number of seats
                        if(insurance_type=='COMPREHENSIVE(Public Taxis, private hire and tour operators)' || insurance_type==''){
                            $('#number_of_seatsDiv').hide();
                        }else{
                            $('#number_of_seatsDiv').show();
                        }


                    }else if(vehicle_class=='Commercial Vehicles'){

                        //Show or hide claims div
                        if(insurance_type=='COMPREHENSIVE(Trailers manufactured locally/bought from the dealer and less than 10 years old)' || insurance_type=='COMPREHENSIVE(Conversion trailers or trailers over 10)' || insurance_type=='COMPREHENSIVE(Own goods)' || insurance_type=='General Cartage'){
                            $('#claim_statusDiv').show();
                        }else{
                            $('#claim_statusDiv').hide();
                        }

                        //show or hide number of tonnes
                        if(insurance_type=='TPO'){
                            $('#number_of_tonnesDiv').show();

                        }else{

                            $('#number_of_tonnesDiv').hide();

                        }

                        //show or hide tpp
                        if(insurance_type=='TPFT(Tankers)'){
                            $('#tppDiv').show();

                        }else{

                            $('#tppDiv').hide();

                        }


                    }
                    else{
                        $('#number_of_seatsDiv').hide();
                        $('#claim_statusDiv').hide();
                        $('#carry_passengerDiv').hide();
                        $('#number_of_tonnesDiv').hide();
                    }

            });




            //When vehicle class is selected ends




            // $('#insurance_class').click(function() {
            //     var query=$(this).val();
            //     if(query==''){
            //
            //     }
            //
            //     else if(query=='MOTOR'){
            //         $('#vehicle').show();
            //     properNextZero();
            //
            //         $('#cover_noteDiv').show();
            //         document.getElementById("cover_note").disabled = false;
            //         var ele = document.getElementById("cover_note");
            //         ele.required = true;
            //
            //         $('#vehicle_useDiv').show();
            //         document.getElementById("vehicle_use").disabled = false;
            //
            //         $('#vehicle_registration_noDiv').show();
            //         document.getElementById("vehicle_registration_no").disabled = false;
            //
            //         $('#client_nameDiv').show();
            //         $('#phone_numberDiv').show();
            //         $('#emailDiv').show();
            //
            //         $('#sticker_noDiv').show();
            //         document.getElementById("sticker_no").disabled = false;
            //         var ele2 = document.getElementById("sticker_no");
            //         ele2.required = true;
            //
            //         $('#valueDiv').hide();
            //         document.getElementById("value").disabled = true;
            //         var ele7 = document.getElementById("value");
            //         ele7.required = false;
            //
            //
            //     }
            //
            //
            //     else{
            //         $('#vehicle').hide();
            //         properNext();
            //
            //         $('#cover_noteDiv').hide();
            //         document.getElementById("cover_note").disabled = true;
            //         var ele = document.getElementById("cover_note");
            //         ele.required = false;
            //
            //
            //         $('#vehicle_useDiv').hide();
            //         document.getElementById("vehicle_use").disabled = true;
            //
            //         $('#vehicle_registration_noDiv').hide();
            //         document.getElementById("vehicle_registration_no").disabled = true;
            //
            //         $('#client_nameDiv').show();
            //         $('#phone_numberDiv').show();
            //         $('#emailDiv').show();
            //
            //
            //
            //         $('#sticker_noDiv').hide();
            //         document.getElementById("sticker_no").disabled = true;
            //         var ele2 = document.getElementById("sticker_no");
            //         ele2.required = false;
            //
            //         $('#valueDiv').show();
            //         document.getElementById("value").disabled = false;
            //         var ele7 = document.getElementById("value");
            //         ele7.required = true;
            //
            //     }
            //
            //
            // });

        });


    </script>



<script type="text/javascript">

    var button_clicked=null;

    function openNewTab() {

        button_clicked='Save and print';
    }

    function submitFunction(){
        $("#cancel5").css("background-color", "#87ceeb");
        $("#cancel5").val('Finish');
        $("#previous5").hide();
        $("#submit5").hide();
        $("#save_and_print_btn").hide();

        if(button_clicked=='Save and print'){

            $("#msform").attr("target","_blank");

        }else{


        }


        return true;

    }





    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var p1, p2,p3,p4,p5,p6,p7,p8;
    var temp;

    function properNext(){
        temp=1;
    }

    function properNextZero(){
        temp=0;
    }

    $(document).ready(function(){


        $(document).ready(function() {
            $('.risk_non_manufacturing').select2(
                {
                    placeholder: "Select risk",
                    theme: "bootstrap",
                    allowClear: true,
                }
            );
        });



        $(document).ready(function() {
            $('.risk_storage').select2(
                {
                    placeholder: "Select risk",
                    theme: "bootstrap",
                    allowClear: true,
                }
            );
        });


        $(document).ready(function() {
            $('.risk_manufacturing').select2(
                {
                    placeholder: "Select risk",
                    theme: "bootstrap",
                    allowClear: true,
                }
            );
        });


        $(document).ready(function() {
            $('.risk_makuti').select2(
                {
                    placeholder: "Select risk",
                    theme: "bootstrap",
                    allowClear: true,
                }
            );
        });



        $(document).ready(function() {
            $('.commodity').select2(
                {
                    placeholder: "Select commodity",
                    theme: "bootstrap",
                    allowClear: true,
                }
            );
        });


        $(document).ready(function() {
            $('.number_of_employees').select2(
                {
                    placeholder: "Select number of employees",
                    theme: "bootstrap",
                    allowClear: true,
                }
            );
        });


        $(document).ready(function() {
            $('.sum_insured_dropdown').select2(
                {
                    placeholder: "Select sum insured",
                    theme: "bootstrap",
                    allowClear: true,
                }
            );
        });



$("#next1").click(function(){
var p_all;
    if(temp==1) {
        next_fs = $(this).parent().next().next();
    }else{
        next_fs = $(this).parent().next();
    }

current_fs = $(this).parent();


    var client_name=document.getElementById('full_name').value;
    var insurance_class=document.getElementById('insurance_class').value;
    var insurance_company=document.getElementById('insurance_company').value;
    var insurance_type=document.getElementById('insurance_type').value;
    var vehicle_registration_no=document.getElementById('vehicle_registration_no').value;
    // var vehicle_use=document.getElementById('vehicle_use').value;
    var insurance_type_na=document.getElementById('insurance_type_na').value;
    var email=$("#email").val();


    var vehicle_class=$('#vehicle_class').val();
    var number_of_employees=$('#number_of_employees').val();
    var insurance_type_money=$('#insurance_type_money').val();
    var insurance_type_liability=$('#insurance_type_liability').val();
    var commodity=$('#commodity').val();
    var marine_containerized=$('#marine_containerized').val();
    var type_of_risk=$('#type_of_risk').val();
    var group_of_risk=$('#group_of_risk').val();
    var risk_non_manufacturing=$('#risk_non_manufacturing').val();
    var risk_storage=$('#risk_storage').val();
    var state=$('#state').val();
    var risk_manufacturing=$('#risk_manufacturing').val();
    var risk_makuti=$('#risk_makuti').val();
    var claim_status=$('#claim_status').val();
    var tpp=$('#tpp').val();
    var carry_passenger=$('#carry_passenger').val();
    var number_of_tonnes=$('#number_of_tonnes').val();
    var number_of_seats=$('#number_of_seats').val();
    var tin=$('#tin').val();



    if(insurance_class=='FIDELITY GUARANTEE'){

        var number_of_employees=$('#number_of_employees').val();

        $.ajax({
            url:"{{ route('autocomplete.sum_insured') }}",
            method:"get",
            data:{number_of_employees:number_of_employees},
            success:function(data){
                if(data=='0'){



                }
                else{



                   $('#sum_insured_dropdown').html(data);





                }
            }
        });




        $('#sum_insured_dropdownDiv').show();
        $('#sum_insuredDiv').hide();
        document.getElementById("sum_insured_dropdown").disabled = false;
        document.getElementById("sum_insured").disabled = true;

    }else{

        $('#sum_insuredDiv').show();
        $('#sum_insured_dropdownDiv').hide();
        document.getElementById("sum_insured_dropdown").disabled = true;
        document.getElementById("sum_insured").disabled = false;
    }



    if(insurance_class=='MOTOR' || insurance_class=='FIRE'){
        $('#mode_of_paymentDiv').show();


    }else{

        $('#mode_of_paymentDiv').hide();
        $('#number_of_installmentsDiv').hide();
        $('#first_installmentDiv').hide();
        $('#second_installmentDiv').hide();
        $('#third_installmentDiv').hide();
        $('#fourth_installmentDiv').hide();
        $('#fifth_installmentDiv').hide();
        $('#sixth_installmentDiv').hide();
        $('#seventh_installmentDiv').hide();
        $('#eighth_installmentDiv').hide();
        $('#ninth_installmentDiv').hide();
        $('#tenth_installmentDiv').hide();
        $('#eleventh_installmentDiv').hide();
        $('#twelfth_installmentDiv').hide();


    }



if (client_name==""){
    p1=0;
    $('#client_msg').show();
    var message=document.getElementById('client_msg');
    message.style.color='red';
    message.innerHTML="Required";
    $('#full_name').attr('style','border-bottom:1px solid #f00');

}else{
p1=1;
    $('#client_msg').hide();
    $('#full_name').attr('style','border-bottom: 1px solid #ccc');

}


    if (insurance_type==""){
        p6=0;
        $('#insurance_type_msg').show();
        var message=document.getElementById('insurance_type_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#insurance_type').attr('style','border-bottom:1px solid #f00');

    }else{
        p6=1;
        $('#insurance_type_msg').hide();
        $('#insurance_type').attr('style','border-bottom: 1px solid #ccc');

    }


    if (vehicle_registration_no==""){
        p7=0;
        $('#vehicle_registration_no_msg').show();
        var message=document.getElementById('vehicle_registration_no_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#vehicle_registration_no').attr('style','border-bottom:1px solid #f00');

    }else{
        p7=1;
        $('#vehicle_registration_no_msg').hide();
        $('#vehicle_registration_no').attr('style','border-bottom: 1px solid #ccc');

    }

    // if (vehicle_use==""){
    //     p8=0;
    //     $('#vehicle_use_msg').show();
    //     var message=document.getElementById('vehicle_use_msg');
    //     message.style.color='red';
    //     message.innerHTML="Required";
    //     $('#vehicle_use').attr('style','border-bottom:1px solid #f00');
    //
    // }else{
    //     p8=1;
    //     $('#vehicle_use_msg').hide();
    //     $('#vehicle_use').attr('style','border-bottom: 1px solid #ccc');
    //
    // }


    if (insurance_class==""){
        p2=0;
        $('#class_msg').show();
        var message=document.getElementById('class_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#insurance_class').attr('style','border-bottom:1px solid #f00');

    }else{
        p2=1;
        $('#class_msg').hide();
        $('#insurance_class').attr('style','border-bottom: 1px solid #ccc');

    }


    if (insurance_company==""){
        p3=0;
        $('#principal_msg').show();
        var message=document.getElementById('principal_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#insurance_company').attr('style','border-bottom:1px solid #f00');

    }else{
p3=1;
$('#principal_msg').hide();
$('#insurance_company').attr('style','border-bottom: 1px solid #ccc');


    }


    if(email==""){
        p4=0;
        $('#email_msg').show();
        var message=document.getElementById('email_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#email').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p4=1;
        $('#email_msg').hide();
        $('#email').attr('style','border-bottom: 1px solid #ccc');

    }









    var phone_digits=$('#phone_number').val().length;

    if(phone_digits<10) {
        p5=0;
        $('#phone_msg').show();
        var message = document.getElementById('phone_msg');
        message.style.color = 'red';
        message.innerHTML = "Digits cannot be less than 10";
        $('#phone_number').attr('style', 'border-bottom:1px solid #f00');

    }else{
        p5=1;
        $('#phone_msg').hide();
        $('#phone_number').attr('style','border-bottom: 1px solid #ccc');
    }



    if(vehicle_class=='') {

        var message = document.getElementById('vehicle_class_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#vehicle_class').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#vehicle_class_msg').hide();
        $('#vehicle_class').attr('style','border-bottom: 1px solid #ccc');
    }

    if(number_of_employees=='') {

        var message = document.getElementById('number_of_employees_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#number_of_employees').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#number_of_employees_msg').hide();
        $('#number_of_employees').attr('style','border-bottom: 1px solid #ccc');
    }


    if(insurance_type_money=='') {

        var message = document.getElementById('insurance_type_money_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#insurance_type_money').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#insurance_type_money_msg').hide();
        $('#insurance_type_money').attr('style','border-bottom: 1px solid #ccc');
    }



    if(insurance_type_liability=='') {

        var message = document.getElementById('insurance_type_liability_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#insurance_type_liability').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#insurance_type_liability_msg').hide();
        $('#insurance_type_liability').attr('style','border-bottom: 1px solid #ccc');
    }


    if(commodity=='') {

        var message = document.getElementById('commodity_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#commodity').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#commodity_msg').hide();
        $('#commodity').attr('style','border-bottom: 1px solid #ccc');
    }



    if(marine_containerized=='') {

        var message = document.getElementById('marine_containerized_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#marine_containerized').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#marine_containerized_msg').hide();
        $('#marine_containerized').attr('style','border-bottom: 1px solid #ccc');
    }


    if(type_of_risk=='') {

        var message = document.getElementById('type_of_risk_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#type_of_risk').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#type_of_risk_msg').hide();
        $('#type_of_risk').attr('style','border-bottom: 1px solid #ccc');
    }


    if(group_of_risk=='') {

        var message = document.getElementById('group_of_risk_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#group_of_risk').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#group_of_risk_msg').hide();
        $('#group_of_risk').attr('style','border-bottom: 1px solid #ccc');
    }


    if(risk_non_manufacturing=='') {

        var message = document.getElementById('risk_non_manufacturing_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#risk_non_manufacturing').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#risk_non_manufacturing_msg').hide();
        $('#risk_non_manufacturing').attr('style','border-bottom: 1px solid #ccc');
    }


    if(risk_storage=='') {

        var message = document.getElementById('risk_storage_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#risk_storage').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#risk_storage_msg').hide();
        $('#risk_storage').attr('style','border-bottom: 1px solid #ccc');
    }


    if(state=='') {

        var message = document.getElementById('state_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#state').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#state_msg').hide();
        $('#state').attr('style','border-bottom: 1px solid #ccc');
    }



    if(risk_manufacturing=='') {

        var message = document.getElementById('risk_manufacturing_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#risk_manufacturing').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#risk_manufacturing_msg').hide();
        $('#risk_manufacturing').attr('style','border-bottom: 1px solid #ccc');
    }


    if(risk_makuti=='') {

        var message = document.getElementById('risk_makuti_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#risk_makuti').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#risk_makuti_msg').hide();
        $('#risk_makuti').attr('style','border-bottom: 1px solid #ccc');
    }


    if(claim_status=='') {

        var message = document.getElementById('claim_status_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#claim_status').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#claim_status_msg').hide();
        $('#claim_status').attr('style','border-bottom: 1px solid #ccc');
    }


    if(tpp=='') {

        var message = document.getElementById('tpp_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#tpp').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#tpp_msg').hide();
        $('#tpp').attr('style','border-bottom: 1px solid #ccc');
    }


    if(carry_passenger=='') {

        var message = document.getElementById('carry_passenger_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#carry_passenger').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#carry_passenger_msg').hide();
        $('#carry_passenger').attr('style','border-bottom: 1px solid #ccc');
    }


    if(number_of_tonnes=='') {

        var message = document.getElementById('number_of_tonnes_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#number_of_tonnes').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#number_of_tonnes_msg').hide();
        $('#number_of_tonnes').attr('style','border-bottom: 1px solid #ccc');
    }


    if(number_of_seats=='') {

        var message = document.getElementById('number_of_seats_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#number_of_seats').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#number_of_seats_msg').hide();
        $('#number_of_seats').attr('style','border-bottom: 1px solid #ccc');
    }


    if(tin=='') {

        var message = document.getElementById('tin_msg');
        message.style.color = 'red';
        message.innerHTML = "Required";
        $('#tin').attr('style', 'border-bottom:1px solid #f00');

    }else{

        $('#tin_msg').hide();
        $('#tin').attr('style','border-bottom: 1px solid #ccc');
    }



    //setting p_all starts





    if(vehicle_class=='' && $('#vehicle_classDiv:visible').length !=0) {

        p_all=0;

    }

    else if(number_of_employees=='' && $('#number_of_employeesDiv:visible').length !=0) {

        p_all=0;

    }

    else if(tin=='' && $('#tinDiv:visible').length !=0) {

        p_all=0;

    }


    else if(insurance_type_money=='' && $('#Type_moneyDiv:visible').length !=0) {

        p_all=0;

    }

    else if(insurance_type_liability=='' && $('#Type_liabilityDiv:visible').length !=0) {

        p_all=0;

    }
    else if(commodity=='' && $('#commodityDiv:visible').length !=0) {

        p_all=0;

    }

    else if(marine_containerized=='' && $('#marine_containerizedDiv:visible').length !=0) {


        p_all=0;
    }
    else if(type_of_risk=='' && $('#type_of_riskDiv:visible').length !=0) {

        p_all=0;

    }
    else if(group_of_risk=='' && $('#group_of_riskDiv:visible').length !=0) {

        p_all=0;

    }

    else if(risk_non_manufacturing=='' && $('#risk_non_manufacturingDiv:visible').length !=0) {


        p_all=0;
    }


    else if(risk_storage=='' && $('#risk_storageDiv:visible').length !=0) {

        p_all=0;

    }


    else if(state=='' && $('#stateDiv:visible').length !=0) {

        p_all=0;

    }

    else if(risk_manufacturing=='' && $('#risk_manufacturingDiv:visible').length !=0) {

        p_all=0;

    }
    else if(risk_makuti=='' && $('#risk_makutiDiv:visible').length !=0) {


        p_all=0;
    }

    else if(claim_status=='' && $('#claim_statusDiv:visible').length !=0) {

        p_all=0;

    }
    else if(tpp=='' && $('#tppDiv:visible').length !=0) {

        p_all=0;

    }

    else if(carry_passenger=='' && $('#carry_passengerDiv:visible').length !=0) {

        p_all=0;

    }

    else if(number_of_tonnes=='' && $('#number_of_tonnesDiv:visible').length !=0) {

        p_all=0;
    }

    else if(number_of_seats=='' && $('#number_of_seatsDiv:visible').length !=0) {
        p_all=0;

    }else{

       p_all=1;
    }




    //setting p_all ends




    var visible_status=$('#TypeDivNA:visible').length;

    if (insurance_class=="MOTOR"){

        if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p5=='1' & p6=='1' & p7=='1' & p_all=='1'){

            gonext();

            {{--var type_var= document.getElementById("insurance_type").value;--}}
            {{--var type_na_var=document.getElementById("insurance_type_na").value;--}}

            {{--var _token = $('input[name="_token"]').val();--}}

            {{--if(visible_status!=0) {--}}
            {{--    console.log('type_na');--}}
            {{--    var type_var--}}
            {{--    $.ajax({--}}
            {{--        url: "{{ route('autofill_insurance_parameters') }}",--}}
            {{--        method: "GET",--}}
            {{--        data: {--}}
            {{--            insurance_class: insurance_class,--}}
            {{--            insurance_company: insurance_company,--}}
            {{--            insurance_type_na: insurance_type_na,--}}
            {{--            _token: _token--}}
            {{--        },--}}
            {{--        success: function (data) {--}}
            {{--            if(data!=""){--}}
            {{--                gonext();--}}

            {{--                document.getElementById("commission_percentage").value=data[0].commission_percentage;--}}

            {{--                document.getElementById("availability_status").innerHTML ='';--}}

            {{--            }else{--}}
            {{--                document.getElementById("availability_status").style.color='Red';--}}
            {{--                document.getElementById("availability_status").innerHTML ='Selected insurance package does not exist for the given principal, please try again';--}}

            {{--            }--}}
            {{--        },--}}

            {{--        error : function(data) {--}}



            {{--        }--}}
            {{--    });--}}
            {{--}else {--}}
            {{--    console.log('type');--}}
            {{--    $.ajax({--}}
            {{--        url: "{{ route('autofill_insurance_parameters') }}",--}}
            {{--        method: "GET",--}}
            {{--        data: {--}}
            {{--            insurance_class: insurance_class,--}}
            {{--            insurance_company: insurance_company,--}}
            {{--            insurance_type: insurance_type,--}}
            {{--            _token: _token--}}
            {{--        },--}}
            {{--        success: function (data) {--}}

            {{--            if(data!=""){--}}
            {{--                gonext();--}}

            {{--                document.getElementById("commission_percentage").value=data[0].commission_percentage;--}}


            {{--                document.getElementById("availability_status").innerHTML ='';--}}

            {{--            }else{--}}

            {{--                document.getElementById("availability_status").style.color='Red';--}}
            {{--                document.getElementById("availability_status").innerHTML ='Selected insurance package does not exist for the given principal, please try again';--}}

            {{--            }--}}

            {{--        },--}}

            {{--        error : function(data) {--}}



            {{--        }--}}
            {{--    });--}}

            {{--}--}}



        }


    }else{

        if(p1=='1' & p2=='1' & p3=='1' & p4=='1' & p5=='1' & p_all=='1'){

            gonext();
            {{--var type_var= document.getElementById("insurance_type").value;--}}
            {{--var type_na_var=document.getElementById("insurance_type_na").value;--}}

            {{--var _token = $('input[name="_token"]').val();--}}

            {{--if(visible_status!=0) {--}}
            {{--    console.log('type_na');--}}
            {{--    var type_var--}}
            {{--    $.ajax({--}}
            {{--        url: "{{ route('autofill_insurance_parameters') }}",--}}
            {{--        method: "GET",--}}
            {{--        data: {--}}
            {{--            insurance_class: insurance_class,--}}
            {{--            insurance_company: insurance_company,--}}
            {{--            insurance_type_na: insurance_type_na,--}}
            {{--            _token: _token--}}
            {{--        },--}}
            {{--        success: function (data) {--}}
            {{--            if(data!=""){--}}
            {{--                gonext();--}}

            {{--                document.getElementById("commission_percentage").value=data[0].commission_percentage;--}}
            {{--                document.getElementById("availability_status").innerHTML ='';--}}

            {{--            }else{--}}
            {{--                document.getElementById("availability_status").style.color='Red';--}}
            {{--                document.getElementById("availability_status").innerHTML ='Selected insurance package does not exist for the given principal, please try again';--}}

            {{--            }--}}
            {{--        },--}}

            {{--        error : function(data) {--}}



            {{--        }--}}
            {{--    });--}}
            {{--}else {--}}
            {{--    console.log('type');--}}
            {{--    $.ajax({--}}
            {{--        url: "{{ route('autofill_insurance_parameters') }}",--}}
            {{--        method: "GET",--}}
            {{--        data: {--}}
            {{--            insurance_class: insurance_class,--}}
            {{--            insurance_company: insurance_company,--}}
            {{--            insurance_type: insurance_type,--}}
            {{--            _token: _token--}}
            {{--        },--}}
            {{--        success: function (data) {--}}

            {{--            if(data!=""){--}}
            {{--                gonext();--}}

            {{--                document.getElementById("commission_percentage").value=data[0].commission_percentage;--}}

            {{--                document.getElementById("availability_status").innerHTML ='';--}}

            {{--            }else{--}}

            {{--                document.getElementById("availability_status").style.color='Red';--}}
            {{--                document.getElementById("availability_status").innerHTML ='Selected insurance package does not exist for the given principal, please try again';--}}

            {{--            }--}}

            {{--        },--}}

            {{--        error : function(data) {--}}



            {{--        }--}}
            {{--    });--}}

            {{--}--}}



        }


    }






});

$("#next2").click(function(){
    current_fs = $(this).parent();
    next_fs = $(this).parent().next();
    var p1, p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,p18,p19,p20,p21,p22,p23,p_all2;
    var client_name=document.getElementById('full_name').value;
    var insurance_class=document.getElementById('insurance_class').value;
    var insurance_company=document.getElementById('insurance_company').value;
    var insurance_type=document.getElementById('insurance_type').value;
    var vehicle_registration_no=document.getElementById('vehicle_registration_no').value;
    // var vehicle_use=document.getElementById('vehicle_use').value;
    var insurance_type_na=document.getElementById('insurance_type_na').value;
    var phone_number=document.getElementById('phone_number').value;
    var commission_date=document.getElementById('commission_date').value;
    var sum_insured=document.getElementById('sum_insured').value;
    var premium=document.getElementById('premium').value;
    var actual_ex_vat=document.getElementById('actual_ex_vat').value;
    var value=$("#value").val();
    var commission_percentage=document.getElementById('commission_percentage').value;
    var commission=document.getElementById('commission').value;
    var cover_note=$("#cover_note").val();
    var sticker_no=$("#sticker_no").val();
    var receipt_no=$("#receipt_no").val();
    var currency=document.getElementById('currency').value;
    var email=$("#email").val();
    var mode_of_payment=$("#mode_of_payment").val();
    var number_of_installments=$("#number_of_installments").val();
    var first_installment=$("#first_installment").val();
    var second_installment=$("#second_installment").val();

    var third_installment=$("#third_installment").val();
    var fourth_installment=$("#fourth_installment").val();
    var fifth_installment=$("#fifth_installment").val();
    var sixth_installment=$("#sixth_installment").val();
    var seventh_installment=$("#seventh_installment").val();
    var eighth_installment=$("#eighth_installment").val();
    var ninth_installment=$("#ninth_installment").val();
    var tenth_installment=$("#tenth_installment").val();
    var eleventh_installment=$("#eleventh_installment").val();
    var twelfth_installment=$("#twelfth_installment").val();


    var sum_insured_dropdown=$("#sum_insured_dropdown").val();



    if(commission_date==""){
        p1=0;
        $('#commission_date_msg').show();
        var message=document.getElementById('commission_date_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#commission_date').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p1=1;
        $('#commission_date_msg').hide();
        $('#commission_date').attr('style','border-bottom: 1px solid #ccc');

    }



    if(sum_insured==""){

        $('#sum_insured_msg').show();
        var message=document.getElementById('sum_insured_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#sum_insured').attr('style','border-bottom:1px solid #f00');
    }
    else{

        $('#sum_insured_msg').hide();
        $('#sum_insured').attr('style','border-bottom: 1px solid #ccc');

    }



    if(mode_of_payment==""){
        p3=0;
        $('#mode_of_payment_msg').show();
        var message=document.getElementById('mode_of_payment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#mode_of_payment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p3=1;
        $('#mode_of_payment_msg').hide();
        $('#mode_of_payment').attr('style','border-bottom: 1px solid #ccc');

    }



    if(actual_ex_vat==""){
        p4=0;
        $('#actual_ex_vat_msg').show();
        var message=document.getElementById('actual_ex_vat_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#actual_ex_vat').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p4=1;
        $('#actual_ex_vat_msg').hide();
        $('#actual_ex_vat').attr('style','border-bottom: 1px solid #ccc');

    }


    if(cover_note==""){
        p5=0;
        $('#cover_note_msg').show();
        var message=document.getElementById('cover_note_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#cover_note').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p5=1;
        $('#cover_note_msg').hide();
        $('#cover_note').attr('style','border-bottom: 1px solid #ccc');
    }


    if(sticker_no==""){
        p6=0;
        $('#sticker_no_msg').show();
        var message=document.getElementById('sticker_no_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#sticker_no').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p6=1;
        $('#sticker_no_msg').hide();
        $('#sticker_no').attr('style','border-bottom: 1px solid #ccc');

    }



    if(receipt_no==""){
        p7=0;
        $('#receipt_no_msg').show();
        var message=document.getElementById('receipt_no_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#receipt_no').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p7=1;
        $('#receipt_no_msg').hide();
        $('#receipt_no').attr('style','border-bottom: 1px solid #ccc');

    }


    if(value==""){
        p8=0;
        $('#value_msg').show();
        var message=document.getElementById('value_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#value').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p8=1;
        $('#value_msg').hide();
        $('#value').attr('style','border-bottom: 1px solid #ccc');

    }


    if(currency==""){
        p9=0;
        $('#currency_msg').show();
        var message=document.getElementById('currency_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#currency').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p9=1;
        $('#currency_msg').hide();
        $('#currency').attr('style','border-bottom: 1px solid #ccc');

    }



    if(premium==""){
        p10=0;
        $('#premium_msg').show();
        var message=document.getElementById('premium_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#premium').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p10=1;
        $('#premium_msg').hide();
        $('#premium').attr('style','border-bottom: 1px solid #ccc');

    }




    if(number_of_installments==""){
        p11=0;
        $('#number_of_installments_msg').show();
        var message=document.getElementById('number_of_installments_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#number_of_installments').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p11=1;
        $('#number_of_installments_msg').hide();
        $('#number_of_installments').attr('style','border-bottom: 1px solid #ccc');

    }


    if(first_installment==""){
        p12=0;
        $('#first_installment_msg').show();
        var message=document.getElementById('first_installment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#first_installment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p12=1;
        $('#first_installment_msg').hide();
        $('#first_installment').attr('style','border-bottom: 1px solid #ccc');

    }


    if(second_installment==""){
        p13=0;
        $('#second_installment_msg').show();
        var message=document.getElementById('second_installment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#second_installment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p13=1;
        $('#second_installment_msg').hide();
        $('#second_installment').attr('style','border-bottom: 1px solid #ccc');

    }


    if(third_installment==""){
        p14=0;
        $('#third_installment_msg').show();
        var message=document.getElementById('third_installment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#third_installment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p14=1;
        $('#third_installment_msg').hide();
        $('#third_installment').attr('style','border-bottom: 1px solid #ccc');

    }


    if(fourth_installment==""){
        p15=0;
        $('#fourth_installment_msg').show();
        var message=document.getElementById('fourth_installment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#fourth_installment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p15=1;
        $('#fourth_installment_msg').hide();
        $('#fourth_installment').attr('style','border-bottom: 1px solid #ccc');

    }


    if(fifth_installment==""){
        p16=0;
        $('#fifth_installment_msg').show();
        var message=document.getElementById('fifth_installment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#fifth_installment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p16=1;
        $('#fifth_installment_msg').hide();
        $('#fifth_installment').attr('style','border-bottom: 1px solid #ccc');

    }



    if(sixth_installment==""){
        p17=0;
        $('#sixth_installment_msg').show();
        var message=document.getElementById('sixth_installment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#sixth_installment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p17=1;
        $('#sixth_installment_msg').hide();
        $('#sixth_installment').attr('style','border-bottom: 1px solid #ccc');

    }



    if(seventh_installment==""){
        p18=0;
        $('#seventh_installment_msg').show();
        var message=document.getElementById('seventh_installment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#seventh_installment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p18=1;
        $('#seventh_installment_msg').hide();
        $('#seventh_installment').attr('style','border-bottom: 1px solid #ccc');

    }



    if(eighth_installment==""){
        p19=0;
        $('#eighth_installment_msg').show();
        var message=document.getElementById('eighth_installment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#eighth_installment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p19=1;
        $('#eighth_installment_msg').hide();
        $('#eighth_installment').attr('style','border-bottom: 1px solid #ccc');

    }


    if(ninth_installment==""){
        p20=0;
        $('#ninth_installment_msg').show();
        var message=document.getElementById('ninth_installment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#ninth_installment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p20=1;
        $('#ninth_installment_msg').hide();
        $('#ninth_installment').attr('style','border-bottom: 1px solid #ccc');

    }



    if(tenth_installment==""){
        p21=0;
        $('#tenth_installment_msg').show();
        var message=document.getElementById('tenth_installment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#tenth_installment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p21=1;
        $('#tenth_installment_msg').hide();
        $('#tenth_installment').attr('style','border-bottom: 1px solid #ccc');

    }


    if(eleventh_installment==""){
        p22=0;
        $('#eleventh_installment_msg').show();
        var message=document.getElementById('eleventh_installment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#eleventh_installment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p22=1;
        $('#eleventh_installment_msg').hide();
        $('#eleventh_installment').attr('style','border-bottom: 1px solid #ccc');

    }



    if(twelfth_installment==""){
        p23=0;
        $('#twelfth_installment_msg').show();
        var message=document.getElementById('twelfth_installment_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#twelfth_installment').attr('style','border-bottom:1px solid #f00');
    }
    else{
        p23=1;
        $('#twelfth_installment_msg').hide();
        $('#twelfth_installment').attr('style','border-bottom: 1px solid #ccc');

    }




    if(sum_insured_dropdown==""){

        $('#sum_insured_dropdown_msg').show();
        var message=document.getElementById('sum_insured_dropdown_msg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#sum_insured_dropdown').attr('style','border-bottom:1px solid #f00');
    }
    else{

        $('#sum_insured_dropdown_msg').hide();
        $('#sum_insured_dropdown').attr('style','border-bottom: 1px solid #ccc');

    }



    if(sum_insured_dropdown=='' && $('#sum_insured_dropdownDiv:visible').length !=0) {
        p2=0;

    }else if(sum_insured=='' && $('#sum_insuredDiv:visible').length !=0){
        p2=0;
    }

    else{

        p2=1;
    }




    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"];
    const dateObj = new Date(commission_date);
    const month = dateObj.getMonth()+1;
    const day = String(dateObj.getDate()).padStart(2, '0');
    const year = dateObj.getFullYear();
    const output = day  + '/'+ month  + '/' + year;


    function thousands_separators(num)
    {
        var num_parts = num.toString().split(".");
        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return num_parts.join(".");
    }



    // document.getElementById("client").innerHTML ='';
    $("#insurance_class_confirm").html(insurance_class);
    $("#insurance_class_confirm").css('font-weight', 'bold');

    $("#insurance_company_confirm").html(insurance_company);
    $("#insurance_company_confirm").css('font-weight', 'bold');



    if(insurance_class=='MOTOR'){
        $("#insurance_type_confirm").html(insurance_type);
        $("#vehicle_registration_no_row_confirm").show();
        // $("#vehicle_use_row_confirm").show();
        $("#sticker_no_row_confirm").show();
        $("#cover_note_row_confirm").show();
        $("#value_row_confirm").hide();

    }else{
        $("#insurance_type_confirm").html(insurance_type_na);
        $("#vehicle_registration_no_row_confirm").hide();
        // $("#vehicle_use_row_confirm").hide();
        $("#sticker_no_row_confirm").hide();
        $("#cover_note_row_confirm").hide();
        $("#value_row_confirm").show();
    }


    if(mode_of_payment=='By installment'){
        $('#mode_of_payment_row_confirm').show();
        $('#number_of_installments_row_confirm').show();


        if(number_of_installments=='2') {
            $('#first_installment_row_confirm').show();
            $('#second_installment_row_confirm').show();
            $('#third_installment_row_confirm').hide();
            $('#fourth_installment_row_confirm').hide();
            $('#fifth_installment_row_confirm').hide();
            $('#sixth_installment_row_confirm').hide();
            $('#seventh_installment_row_confirm').hide();
            $('#eighth_installment_row_confirm').hide();
            $('#ninth_installment_row_confirm').hide();
            $('#tenth_installment_row_confirm').hide();
            $('#eleventh_installment_row_confirm').hide();
            $('#twelfth_installment_row_confirm').hide();
        }
        else if(number_of_installments=='3'){
            $('#first_installment_row_confirm').show();
            $('#second_installment_row_confirm').show();
            $('#third_installment_row_confirm').show();
            $('#fourth_installment_row_confirm').hide();
            $('#fifth_installment_row_confirm').hide();
            $('#sixth_installment_row_confirm').hide();
            $('#seventh_installment_row_confirm').hide();
            $('#eighth_installment_row_confirm').hide();
            $('#ninth_installment_row_confirm').hide();
            $('#tenth_installment_row_confirm').hide();
            $('#eleventh_installment_row_confirm').hide();
            $('#twelfth_installment_row_confirm').hide();

        }else if(number_of_installments=='4'){

            $('#first_installment_row_confirm').show();
            $('#second_installment_row_confirm').show();
            $('#third_installment_row_confirm').show();
            $('#fourth_installment_row_confirm').show();
            $('#fifth_installment_row_confirm').hide();
            $('#sixth_installment_row_confirm').hide();
            $('#seventh_installment_row_confirm').hide();
            $('#eighth_installment_row_confirm').hide();
            $('#ninth_installment_row_confirm').hide();
            $('#tenth_installment_row_confirm').hide();
            $('#eleventh_installment_row_confirm').hide();
            $('#twelfth_installment_row_confirm').hide();

        }else if(number_of_installments=='5'){

            $('#first_installment_row_confirm').show();
            $('#second_installment_row_confirm').show();
            $('#third_installment_row_confirm').show();
            $('#fourth_installment_row_confirm').show();
            $('#fifth_installment_row_confirm').show();
            $('#sixth_installment_row_confirm').hide();
            $('#seventh_installment_row_confirm').hide();
            $('#eighth_installment_row_confirm').hide();
            $('#ninth_installment_row_confirm').hide();
            $('#tenth_installment_row_confirm').hide();
            $('#eleventh_installment_row_confirm').hide();
            $('#twelfth_installment_row_confirm').hide();

        }else if(number_of_installments=='6'){

            $('#first_installment_row_confirm').show();
            $('#second_installment_row_confirm').show();
            $('#third_installment_row_confirm').show();
            $('#fourth_installment_row_confirm').show();
            $('#fifth_installment_row_confirm').show();
            $('#sixth_installment_row_confirm').show();

            $('#seventh_installment_row_confirm').hide();
            $('#eighth_installment_row_confirm').hide();
            $('#ninth_installment_row_confirm').hide();
            $('#tenth_installment_row_confirm').hide();
            $('#eleventh_installment_row_confirm').hide();
            $('#twelfth_installment_row_confirm').hide();

        }
        else if(number_of_installments=='7'){

            $('#first_installment_row_confirm').show();
            $('#second_installment_row_confirm').show();
            $('#third_installment_row_confirm').show();
            $('#fourth_installment_row_confirm').show();
            $('#fifth_installment_row_confirm').show();
            $('#sixth_installment_row_confirm').show();
            $('#seventh_installment_row_confirm').show();

            $('#eighth_installment_row_confirm').hide();
            $('#ninth_installment_row_confirm').hide();
            $('#tenth_installment_row_confirm').hide();
            $('#eleventh_installment_row_confirm').hide();
            $('#twelfth_installment_row_confirm').hide();

        }

        else if(number_of_installments=='8'){

            $('#first_installment_row_confirm').show();
            $('#second_installment_row_confirm').show();
            $('#third_installment_row_confirm').show();
            $('#fourth_installment_row_confirm').show();
            $('#fifth_installment_row_confirm').show();
            $('#sixth_installment_row_confirm').show();
            $('#seventh_installment_row_confirm').show();
            $('#eighth_installment_row_confirm').show();

            $('#ninth_installment_row_confirm').hide();
            $('#tenth_installment_row_confirm').hide();
            $('#eleventh_installment_row_confirm').hide();
            $('#twelfth_installment_row_confirm').hide();

        }


        else if(number_of_installments=='9'){

            $('#first_installment_row_confirm').show();
            $('#second_installment_row_confirm').show();
            $('#third_installment_row_confirm').show();
            $('#fourth_installment_row_confirm').show();
            $('#fifth_installment_row_confirm').show();
            $('#sixth_installment_row_confirm').show();
            $('#seventh_installment_row_confirm').show();
            $('#eighth_installment_row_confirm').show();
            $('#ninth_installment_row_confirm').show();

            $('#tenth_installment_row_confirm').hide();
            $('#eleventh_installment_row_confirm').hide();
            $('#twelfth_installment_row_confirm').hide();

        }
        else if(number_of_installments=='10'){

            $('#first_installment_row_confirm').show();
            $('#second_installment_row_confirm').show();
            $('#third_installment_row_confirm').show();
            $('#fourth_installment_row_confirm').show();
            $('#fifth_installment_row_confirm').show();
            $('#sixth_installment_row_confirm').show();
            $('#seventh_installment_row_confirm').show();
            $('#eighth_installment_row_confirm').show();
            $('#ninth_installment_row_confirm').show();
            $('#tenth_installment_row_confirm').show();

            $('#eleventh_installment_row_confirm').hide();
            $('#twelfth_installment_row_confirm').hide();

        }

        else if(number_of_installments=='11'){

            $('#first_installment_row_confirm').show();
            $('#second_installment_row_confirm').show();
            $('#third_installment_row_confirm').show();
            $('#fourth_installment_row_confirm').show();
            $('#fifth_installment_row_confirm').show();
            $('#sixth_installment_row_confirm').show();
            $('#seventh_installment_row_confirm').show();
            $('#eighth_installment_row_confirm').show();
            $('#ninth_installment_row_confirm').show();
            $('#tenth_installment_row_confirm').show();
            $('#eleventh_installment_row_confirm').show();
            $('#twelfth_installment_row_confirm').hide();

        }


        else if(number_of_installments=='12'){

            $('#first_installment_row_confirm').show();
            $('#second_installment_row_confirm').show();
            $('#third_installment_row_confirm').show();
            $('#fourth_installment_row_confirm').show();
            $('#fifth_installment_row_confirm').show();
            $('#sixth_installment_row_confirm').show();
            $('#seventh_installment_row_confirm').show();
            $('#eighth_installment_row_confirm').show();
            $('#ninth_installment_row_confirm').show();
            $('#tenth_installment_row_confirm').show();
            $('#eleventh_installment_row_confirm').show();
            $('#twelfth_installment_row_confirm').show();

        }else{



        }



    }else{

        $('#mode_of_payment_row_confirm').hide();
        $('#number_of_installments_row_confirm').hide();
        $('#first_installment_row_confirm').hide();
        $('#second_installment_row_confirm').hide();
        $('#third_installment_row_confirm').hide();
        $('#fourth_installment_row_confirm').hide();
        $('#fifth_installment_row_confirm').hide();
        $('#sixth_installment_row_confirm').hide();
        $('#seventh_installment_row_confirm').hide();
        $('#eighth_installment_row_confirm').hide();
        $('#ninth_installment_row_confirm').hide();
        $('#tenth_installment_row_confirm').hide();
        $('#eleventh_installment_row_confirm').hide();
        $('#twelfth_installment_row_confirm').hide();
    }



    $("#insurance_type_confirm").css('font-weight', 'bold');

    $("#client_name_confirm").html(client_name);
    $("#client_name_confirm").css('font-weight', 'bold');

    $("#phone_number_confirm").html(phone_number);
    $("#phone_number_confirm").css('font-weight', 'bold');

    $("#email_confirm").html(email);
    $("#email_confirm").css('font-weight', 'bold');


    $("#vehicle_registration_no_confirm").html(vehicle_registration_no);
    $("#vehicle_registration_no_confirm").css('font-weight', 'bold');


    // $("#vehicle_use_confirm").html(vehicle_use);
    // $("#vehicle_use_confirm").css('font-weight', 'bold');


    $("#commission_date_confirm").html(output);
    $("#commission_date_confirm").css('font-weight', 'bold');

    $("#sum_insured_confirm").html(thousands_separators(sum_insured) +" "+currency);
    $("#sum_insured_confirm").css('font-weight', 'bold');


    $("#premium_confirm").html(thousands_separators(premium)+" "+currency);
    $("#premium_confirm").css('font-weight', 'bold');


    $("#actual_ex_vat_confirm").html(thousands_separators(actual_ex_vat)+" "+currency);
    $("#actual_ex_vat_confirm").css('font-weight', 'bold');


    if(insurance_class=='MOTOR'){

        $("#cover_note_confirm").html(cover_note);
        $("#cover_note_confirm").css('font-weight', 'bold');


        $("#sticker_no_confirm").html(sticker_no);
        $("#sticker_no_confirm").css('font-weight', 'bold');
    }else{
        $("#value_confirm").html(thousands_separators(value)+" "+currency);
        $("#value_confirm").css('font-weight', 'bold');


    }

    if(insurance_type=='COMPREHENSIVE') {

        $("#mode_of_payment_confirm").html(mode_of_payment);
        $("#mode_of_payment_confirm").css('font-weight', 'bold');


        $("#number_of_installments_confirm").html(number_of_installments);
        $("#number_of_installments_confirm").css('font-weight', 'bold');


        if (number_of_installments == '2') {
            $("#first_installment_confirm").html(thousands_separators(first_installment) + " " + currency);
            $("#first_installment_confirm").css('font-weight', 'bold');

            $("#second_installment_confirm").html(thousands_separators(second_installment) + " " + currency);
            $("#second_installment_confirm").css('font-weight', 'bold');

            $("#third_installment_confirm").html(thousands_separators(third_installment) + " " + currency);
            $("#third_installment_confirm").css('font-weight', 'bold');

        } else if (number_of_installments == '3') {
            $("#first_installment_confirm").html(thousands_separators(first_installment) + " " + currency);
            $("#first_installment_confirm").css('font-weight', 'bold');

            $("#second_installment_confirm").html(thousands_separators(second_installment) + " " + currency);
            $("#second_installment_confirm").css('font-weight', 'bold');

            $("#third_installment_confirm").html(thousands_separators(third_installment) + " " + currency);
            $("#third_installment_confirm").css('font-weight', 'bold');

        } else if (number_of_installments == '4') {


            $("#first_installment_confirm").html(thousands_separators(first_installment) + " " + currency);
            $("#first_installment_confirm").css('font-weight', 'bold');

            $("#second_installment_confirm").html(thousands_separators(second_installment) + " " + currency);
            $("#second_installment_confirm").css('font-weight', 'bold');

            $("#third_installment_confirm").html(thousands_separators(third_installment) + " " + currency);
            $("#third_installment_confirm").css('font-weight', 'bold');

            $("#fourth_installment_confirm").html(thousands_separators(fourth_installment) + " " + currency);
            $("#fourth_installment_confirm").css('font-weight', 'bold');

        } else if (number_of_installments == '5') {


            $("#first_installment_confirm").html(thousands_separators(first_installment) + " " + currency);
            $("#first_installment_confirm").css('font-weight', 'bold');

            $("#second_installment_confirm").html(thousands_separators(second_installment) + " " + currency);
            $("#second_installment_confirm").css('font-weight', 'bold');

            $("#third_installment_confirm").html(thousands_separators(third_installment) + " " + currency);
            $("#third_installment_confirm").css('font-weight', 'bold');

            $("#fourth_installment_confirm").html(thousands_separators(fourth_installment) + " " + currency);
            $("#fourth_installment_confirm").css('font-weight', 'bold');


            $("#fifth_installment_confirm").html(thousands_separators(fifth_installment) + " " + currency);
            $("#fifth_installment_confirm").css('font-weight', 'bold');

        } else if (number_of_installments == '6') {


            $("#first_installment_confirm").html(thousands_separators(first_installment) + " " + currency);
            $("#first_installment_confirm").css('font-weight', 'bold');

            $("#second_installment_confirm").html(thousands_separators(second_installment) + " " + currency);
            $("#second_installment_confirm").css('font-weight', 'bold');

            $("#third_installment_confirm").html(thousands_separators(third_installment) + " " + currency);
            $("#third_installment_confirm").css('font-weight', 'bold');

            $("#fourth_installment_confirm").html(thousands_separators(fourth_installment) + " " + currency);
            $("#fourth_installment_confirm").css('font-weight', 'bold');


            $("#fifth_installment_confirm").html(thousands_separators(fifth_installment) + " " + currency);
            $("#fifth_installment_confirm").css('font-weight', 'bold');


            $("#sixth_installment_confirm").html(thousands_separators(sixth_installment) + " " + currency);
            $("#sixth_installment_confirm").css('font-weight', 'bold');
        } else if (number_of_installments == '7') {


            $("#first_installment_confirm").html(thousands_separators(first_installment) + " " + currency);
            $("#first_installment_confirm").css('font-weight', 'bold');

            $("#second_installment_confirm").html(thousands_separators(second_installment) + " " + currency);
            $("#second_installment_confirm").css('font-weight', 'bold');

            $("#third_installment_confirm").html(thousands_separators(third_installment) + " " + currency);
            $("#third_installment_confirm").css('font-weight', 'bold');

            $("#fourth_installment_confirm").html(thousands_separators(fourth_installment) + " " + currency);
            $("#fourth_installment_confirm").css('font-weight', 'bold');


            $("#fifth_installment_confirm").html(thousands_separators(fifth_installment) + " " + currency);
            $("#fifth_installment_confirm").css('font-weight', 'bold');


            $("#sixth_installment_confirm").html(thousands_separators(sixth_installment) + " " + currency);
            $("#sixth_installment_confirm").css('font-weight', 'bold');

            $("#seventh_installment_confirm").html(thousands_separators(seventh_installment) + " " + currency);
            $("#seventh_installment_confirm").css('font-weight', 'bold');
        } else if (number_of_installments == '8') {


            $("#first_installment_confirm").html(thousands_separators(first_installment) + " " + currency);
            $("#first_installment_confirm").css('font-weight', 'bold');

            $("#second_installment_confirm").html(thousands_separators(second_installment) + " " + currency);
            $("#second_installment_confirm").css('font-weight', 'bold');

            $("#third_installment_confirm").html(thousands_separators(third_installment) + " " + currency);
            $("#third_installment_confirm").css('font-weight', 'bold');

            $("#fourth_installment_confirm").html(thousands_separators(fourth_installment) + " " + currency);
            $("#fourth_installment_confirm").css('font-weight', 'bold');


            $("#fifth_installment_confirm").html(thousands_separators(fifth_installment) + " " + currency);
            $("#fifth_installment_confirm").css('font-weight', 'bold');


            $("#sixth_installment_confirm").html(thousands_separators(sixth_installment) + " " + currency);
            $("#sixth_installment_confirm").css('font-weight', 'bold');

            $("#seventh_installment_confirm").html(thousands_separators(seventh_installment) + " " + currency);
            $("#seventh_installment_confirm").css('font-weight', 'bold');


            $("#eighth_installment_confirm").html(thousands_separators(eighth_installment) + " " + currency);
            $("#eighth_installment_confirm").css('font-weight', 'bold');
        } else if (number_of_installments == '9') {


            $("#first_installment_confirm").html(thousands_separators(first_installment) + " " + currency);
            $("#first_installment_confirm").css('font-weight', 'bold');

            $("#second_installment_confirm").html(thousands_separators(second_installment) + " " + currency);
            $("#second_installment_confirm").css('font-weight', 'bold');

            $("#third_installment_confirm").html(thousands_separators(third_installment) + " " + currency);
            $("#third_installment_confirm").css('font-weight', 'bold');

            $("#fourth_installment_confirm").html(thousands_separators(fourth_installment) + " " + currency);
            $("#fourth_installment_confirm").css('font-weight', 'bold');


            $("#fifth_installment_confirm").html(thousands_separators(fifth_installment) + " " + currency);
            $("#fifth_installment_confirm").css('font-weight', 'bold');


            $("#sixth_installment_confirm").html(thousands_separators(sixth_installment) + " " + currency);
            $("#sixth_installment_confirm").css('font-weight', 'bold');

            $("#seventh_installment_confirm").html(thousands_separators(seventh_installment) + " " + currency);
            $("#seventh_installment_confirm").css('font-weight', 'bold');


            $("#eighth_installment_confirm").html(thousands_separators(eighth_installment) + " " + currency);
            $("#eighth_installment_confirm").css('font-weight', 'bold');

            $("#ninth_installment_confirm").html(thousands_separators(ninth_installment) + " " + currency);
            $("#ninth_installment_confirm").css('font-weight', 'bold');
        } else if (number_of_installments == '10') {


            $("#first_installment_confirm").html(thousands_separators(first_installment) + " " + currency);
            $("#first_installment_confirm").css('font-weight', 'bold');

            $("#second_installment_confirm").html(thousands_separators(second_installment) + " " + currency);
            $("#second_installment_confirm").css('font-weight', 'bold');

            $("#third_installment_confirm").html(thousands_separators(third_installment) + " " + currency);
            $("#third_installment_confirm").css('font-weight', 'bold');

            $("#fourth_installment_confirm").html(thousands_separators(fourth_installment) + " " + currency);
            $("#fourth_installment_confirm").css('font-weight', 'bold');


            $("#fifth_installment_confirm").html(thousands_separators(fifth_installment) + " " + currency);
            $("#fifth_installment_confirm").css('font-weight', 'bold');


            $("#sixth_installment_confirm").html(thousands_separators(sixth_installment) + " " + currency);
            $("#sixth_installment_confirm").css('font-weight', 'bold');

            $("#seventh_installment_confirm").html(thousands_separators(seventh_installment) + " " + currency);
            $("#seventh_installment_confirm").css('font-weight', 'bold');


            $("#eighth_installment_confirm").html(thousands_separators(eighth_installment) + " " + currency);
            $("#eighth_installment_confirm").css('font-weight', 'bold');

            $("#ninth_installment_confirm").html(thousands_separators(ninth_installment) + " " + currency);
            $("#ninth_installment_confirm").css('font-weight', 'bold');

            $("#tenth_installment_confirm").html(thousands_separators(tenth_installment) + " " + currency);
            $("#tenth_installment_confirm").css('font-weight', 'bold');
        } else if (number_of_installments == '11') {


            $("#first_installment_confirm").html(thousands_separators(first_installment) + " " + currency);
            $("#first_installment_confirm").css('font-weight', 'bold');

            $("#second_installment_confirm").html(thousands_separators(second_installment) + " " + currency);
            $("#second_installment_confirm").css('font-weight', 'bold');

            $("#third_installment_confirm").html(thousands_separators(third_installment) + " " + currency);
            $("#third_installment_confirm").css('font-weight', 'bold');

            $("#fourth_installment_confirm").html(thousands_separators(fourth_installment) + " " + currency);
            $("#fourth_installment_confirm").css('font-weight', 'bold');


            $("#fifth_installment_confirm").html(thousands_separators(fifth_installment) + " " + currency);
            $("#fifth_installment_confirm").css('font-weight', 'bold');


            $("#sixth_installment_confirm").html(thousands_separators(sixth_installment) + " " + currency);
            $("#sixth_installment_confirm").css('font-weight', 'bold');

            $("#seventh_installment_confirm").html(thousands_separators(seventh_installment) + " " + currency);
            $("#seventh_installment_confirm").css('font-weight', 'bold');


            $("#eighth_installment_confirm").html(thousands_separators(eighth_installment) + " " + currency);
            $("#eighth_installment_confirm").css('font-weight', 'bold');

            $("#ninth_installment_confirm").html(thousands_separators(ninth_installment) + " " + currency);
            $("#ninth_installment_confirm").css('font-weight', 'bold');

            $("#tenth_installment_confirm").html(thousands_separators(tenth_installment) + " " + currency);
            $("#tenth_installment_confirm").css('font-weight', 'bold');

            $("#eleventh_installment_confirm").html(thousands_separators(eleventh_installment) + " " + currency);
            $("#eleventh_installment_confirm").css('font-weight', 'bold');
        } else if (number_of_installments == '12') {


            $("#first_installment_confirm").html(thousands_separators(first_installment) + " " + currency);
            $("#first_installment_confirm").css('font-weight', 'bold');

            $("#second_installment_confirm").html(thousands_separators(second_installment) + " " + currency);
            $("#second_installment_confirm").css('font-weight', 'bold');

            $("#third_installment_confirm").html(thousands_separators(third_installment) + " " + currency);
            $("#third_installment_confirm").css('font-weight', 'bold');

            $("#fourth_installment_confirm").html(thousands_separators(fourth_installment) + " " + currency);
            $("#fourth_installment_confirm").css('font-weight', 'bold');


            $("#fifth_installment_confirm").html(thousands_separators(fifth_installment) + " " + currency);
            $("#fifth_installment_confirm").css('font-weight', 'bold');


            $("#sixth_installment_confirm").html(thousands_separators(sixth_installment) + " " + currency);
            $("#sixth_installment_confirm").css('font-weight', 'bold');

            $("#seventh_installment_confirm").html(thousands_separators(seventh_installment) + " " + currency);
            $("#seventh_installment_confirm").css('font-weight', 'bold');


            $("#eighth_installment_confirm").html(thousands_separators(eighth_installment) + " " + currency);
            $("#eighth_installment_confirm").css('font-weight', 'bold');

            $("#ninth_installment_confirm").html(thousands_separators(ninth_installment) + " " + currency);
            $("#ninth_installment_confirm").css('font-weight', 'bold');

            $("#tenth_installment_confirm").html(thousands_separators(tenth_installment) + " " + currency);
            $("#tenth_installment_confirm").css('font-weight', 'bold');

            $("#eleventh_installment_confirm").html(thousands_separators(eleventh_installment) + " " + currency);
            $("#eleventh_installment_confirm").css('font-weight', 'bold');

            $("#twelfth_installment_confirm").html(thousands_separators(twelfth_installment) + " " + currency);
            $("#twelfth_installment_confirm").css('font-weight', 'bold');
        } else {


        }

    }else{


    }

    $("#commission_percentage_confirm").html(commission_percentage+"%");
    $("#commission_percentage_confirm").css('font-weight', 'bold');


    $("#commission_confirm").html(thousands_separators(commission)+" "+currency);
    $("#commission_confirm").css('font-weight', 'bold');





    $("#receipt_no_confirm").html(receipt_no);
    $("#receipt_no_confirm").css('font-weight', 'bold');

//to cut to the chase
    gonext();



 if(insurance_class=='MOTOR'){

     if(insurance_type=='COMPREHENSIVE'){

         //check for different mode of payments

         if(mode_of_payment=="By installment"){

//check if number of installments field is not empty
             if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' & p11=='1') {

               //Then check for each number of installments specified
                 if(number_of_installments=='2'){


                     if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' & p11=='1' & p12=='1' & p13=='1') {

                         //check amounts if valid
                         if (sum_insured>=20 && actual_ex_vat>=20 && first_installment>=20 && second_installment>=20){
                             document.getElementById("validate_money_msg").innerHTML ='';
                             gonext();
                         }else{
                             document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                             document.getElementById("validate_money_msg").style.color='Red';

                         }

                     }else{



                     }


                 }else if(number_of_installments=='3'){

                     if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' & p11=='1' & p12=='1' & p13=='1' & p14=='1') {

                         //check amounts if valid
                         if (sum_insured>=20 && actual_ex_vat>=20 && first_installment>=20 && second_installment>=20 && third_installment>=20){
                             document.getElementById("validate_money_msg").innerHTML ='';
                             gonext();
                         }else{
                             document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                             document.getElementById("validate_money_msg").style.color='Red';

                         }

                     }else{



                     }

                 }else if(number_of_installments=='4'){

                     if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' & p11=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1') {

                         //check amounts if valid
                         if (sum_insured>=20 && actual_ex_vat>=20 && first_installment>=20 && second_installment>=20 && third_installment>=20 && fourth_installment>=20){
                             document.getElementById("validate_money_msg").innerHTML ='';
                             gonext();
                         }else{
                             document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                             document.getElementById("validate_money_msg").style.color='Red';

                         }

                     }else{



                     }

                 }else if(number_of_installments=='5'){

                     if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' & p11=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1' & p16=='1') {

                         //check amounts if valid
                         if (sum_insured>=20 && actual_ex_vat>=20 && first_installment>=20 && second_installment>=20 && third_installment>=20 && fourth_installment>=20 && fifth_installment>=20){
                             document.getElementById("validate_money_msg").innerHTML ='';
                             gonext();
                         }else{
                             document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                             document.getElementById("validate_money_msg").style.color='Red';

                         }

                     }else{



                     }

                 }else if(number_of_installments=='6'){

                     if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' & p11=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1' & p16=='1' & p17=='1') {

                         //check amounts if valid
                         if (sum_insured>=20 && actual_ex_vat>=20 && first_installment>=20 && second_installment>=20 && third_installment>=20 && fourth_installment>=20 && fifth_installment>=20 && sixth_installment>=20){
                             document.getElementById("validate_money_msg").innerHTML ='';
                             gonext();
                         }else{
                             document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                             document.getElementById("validate_money_msg").style.color='Red';

                         }

                     }else{



                     }

                 }else if(number_of_installments=='7'){


                     if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' & p11=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1' & p16=='1' & p17=='1' & p18=='1') {

                         //check amounts if valid
                         if (sum_insured>=20 && actual_ex_vat>=20 && first_installment>=20 && second_installment>=20 && third_installment>=20 && fourth_installment>=20 && fifth_installment>=20 && sixth_installment>=20 && seventh_installment>=20){
                             document.getElementById("validate_money_msg").innerHTML ='';
                             gonext();
                         }else{
                             document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                             document.getElementById("validate_money_msg").style.color='Red';

                         }

                     }else{



                     }

                 }else if(number_of_installments=='8'){


                     if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' & p11=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1' & p16=='1' & p17=='1' & p18=='1' & p19=='1') {

                         //check amounts if valid
                         if (sum_insured>=20 && actual_ex_vat>=20 && first_installment>=20 && second_installment>=20 && third_installment>=20 && fourth_installment>=20 && fifth_installment>=20 && sixth_installment>=20 && seventh_installment>=20 && eighth_installment>=20){
                             document.getElementById("validate_money_msg").innerHTML ='';
                             gonext();
                         }else{
                             document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                             document.getElementById("validate_money_msg").style.color='Red';

                         }

                     }else{



                     }


                 }else if (number_of_installments=='9'){

                     if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' & p11=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1' & p16=='1' & p17=='1' & p18=='1' & p19=='1' & p20=='1') {

                         //check amounts if valid
                         if (sum_insured>=20 && actual_ex_vat>=20 && first_installment>=20 && second_installment>=20 && third_installment>=20 && fourth_installment>=20 && fifth_installment>=20 && sixth_installment>=20 && seventh_installment>=20 && eighth_installment>=20 && ninth_installment>=20){
                             document.getElementById("validate_money_msg").innerHTML ='';
                             gonext();
                         }else{
                             document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                             document.getElementById("validate_money_msg").style.color='Red';

                         }

                     }else{



                     }

                 }else if (number_of_installments=='10'){

                     if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' & p11=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1' & p16=='1' & p17=='1' & p18=='1' & p19=='1' & p20=='1' & p21=='1') {

                         //check amounts if valid
                         if (sum_insured>=20 && actual_ex_vat>=20 && first_installment>=20 && second_installment>=20 && third_installment>=20 && fourth_installment>=20 && fifth_installment>=20 && sixth_installment>=20 && seventh_installment>=20 && eighth_installment>=20 && ninth_installment>=20 && tenth_installment>=20){
                             document.getElementById("validate_money_msg").innerHTML ='';
                             gonext();
                         }else{
                             document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                             document.getElementById("validate_money_msg").style.color='Red';

                         }

                     }else{



                     }


                 }else if (number_of_installments=='11'){

                     if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' & p11=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1' & p16=='1' & p17=='1' & p18=='1' & p19=='1' & p20=='1' & p21=='1' & p22=='1') {

                         //check amounts if valid
                         if (sum_insured>=20 && actual_ex_vat>=20 && first_installment>=20 && second_installment>=20 && third_installment>=20 && fourth_installment>=20 && fifth_installment>=20 && sixth_installment>=20 && seventh_installment>=20 && eighth_installment>=20 && ninth_installment>=20 && tenth_installment>=20 && eleventh_installment>=20){
                             document.getElementById("validate_money_msg").innerHTML ='';
                             gonext();
                         }else{
                             document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                             document.getElementById("validate_money_msg").style.color='Red';

                         }

                     }else{



                     }

                 } else if (number_of_installments=='12'){


                     if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' & p11=='1' & p12=='1' & p13=='1' & p14=='1' & p15=='1' & p16=='1' & p17=='1' & p18=='1' & p19=='1' & p20=='1' & p21=='1' & p22=='1' & p23=='1') {

                         //check amounts if valid
                         if (sum_insured>=20 && actual_ex_vat>=20 && first_installment>=20 && second_installment>=20 && third_installment>=20 && fourth_installment>=20 && fifth_installment>=20 && sixth_installment>=20 && seventh_installment>=20 && eighth_installment>=20 && ninth_installment>=20 && tenth_installment>=20 && eleventh_installment>=20 && twelfth_installment>=20){
                             document.getElementById("validate_money_msg").innerHTML ='';
                             gonext();
                         }else{
                             document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                             document.getElementById("validate_money_msg").style.color='Red';

                         }

                     }else{



                     }


                 } else{



                 }







             }else{



             }






         }else if(mode_of_payment=="Full payment"){

             if(p1=='1' & p2=='1' & p3=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1' ) {

                 //check amounts if valid
                 if (sum_insured>=20 && actual_ex_vat>=20 ){
                     document.getElementById("validate_money_msg").innerHTML ='';
                     gonext();
                 }else{
                     document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                     document.getElementById("validate_money_msg").style.color='Red';

                 }

             }else{



             }

         }else{




         }










     }

     else{

         if(p1=='1' & p2=='1'  & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p9=='1'  & p10=='1') {

             if (sum_insured>=20 && actual_ex_vat>=20 ){
                 document.getElementById("validate_money_msg").innerHTML ='';
                 gonext();
             }else{
                 document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
                 document.getElementById("validate_money_msg").style.color='Red';

             }

         }else{



         }

     }





    }else{

     if(p1=='1' & p2=='1' & p4=='1'  & p5=='1' & p6=='1'  & p7=='1' & p8=='1' & p9=='1'  & p10=='1') {

         if (sum_insured>=20 && actual_ex_vat>=20 && value>=20 ){
             document.getElementById("validate_money_msg").innerHTML ='';
             gonext();
         }else{
             document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';
             document.getElementById("validate_money_msg").style.color='Red';

         }

     }else{



     }


 }



  });

function gonext(){
    console.log(3);

//Add Class Active
$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

//show the next fieldset
next_fs.show();
//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
next_fs.css({'opacity': opacity});
},
duration: 600
});
}

// $(".next").click(function(){

// current_fs = $(this).parent();
// next_fs = $(this).parent().next();

// //Add Class Active
// $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

// //show the next fieldset
// next_fs.show();
// //hide the current fieldset with style
// current_fs.animate({opacity: 0}, {
// step: function(now) {
// // for making fielset appear animation
// opacity = 1 - now;

// current_fs.css({
// 'display': 'none',
// 'position': 'relative'
// });
// next_fs.css({'opacity': opacity});
// },
// duration: 600
// });
// });

$(".previous").click(function(){

    if(temp==1) {
        previous_fs = $(this).parent().prev().prev();
    }else{
        previous_fs = $(this).parent().prev();
    }


current_fs = $(this).parent();


//Remove class active
$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

//show the previous fieldset
previous_fs.show();

//hide the current fieldset with style
current_fs.animate({opacity: 0}, {
step: function(now) {
// for making fielset appear animation
opacity = 1 - now;

current_fs.css({
'display': 'none',
'position': 'relative'
});
previous_fs.css({'opacity': opacity});
},
duration: 600
});
});

$(".submit").click(function(){
	console.log(2);
return true;
})

});
</script>


    <script>

      $('#mode_of_payment').on('change',function(e){
        e.preventDefault();
        var mode_of_payment = $(this).val();
        var premium=$('#premium').val();


        if(mode_of_payment == 'By installment')
        {

            $('#number_of_installmentsDiv').show();
            $('#clause').show();

            function thousands_separators(num)
            {
                var num_parts = num.toString().split(".");
                num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return num_parts.join(".");
            }

            // var first_installment= Math.round(((0.60*premium) + Number.EPSILON) * 100) / 100;
            // var second_installment=Math.round(((0.40*premium) + Number.EPSILON) * 100) / 100;
            //
            //
            // $('#first_installment').val(first_installment);
            // $('#second_installment').val(second_installment);

        }
        else if(mode_of_payment=='Full payment'){
            $('#clause').hide();
            $('#number_of_installmentsDiv').hide();
            $('#first_installmentDiv').hide();
            $('#second_installmentDiv').hide();
            $('#third_installmentDiv').hide();
            $('#fourth_installmentDiv').hide();
            $('#fifth_installmentDiv').hide();
            $('#sixth_installmentDiv').hide();
            $('#seventh_installmentDiv').hide();
            $('#eighth_installmentDiv').hide();
            $('#ninth_installmentDiv').hide();
            $('#tenth_installmentDiv').hide();
            $('#eleventh_installmentDiv').hide();
            $('#twelfth_installmentDiv').hide();

        }

        else{
            $('#clause').hide();
            $('#number_of_installmentsDiv').hide();
            $('#first_installmentDiv').hide();
            $('#second_installmentDiv').hide();
            $('#third_installmentDiv').hide();
            $('#fourth_installmentDiv').hide();
            $('#fifth_installmentDiv').hide();
            $('#sixth_installmentDiv').hide();
            $('#seventh_installmentDiv').hide();
            $('#eighth_installmentDiv').hide();
            $('#ninth_installmentDiv').hide();
            $('#tenth_installmentDiv').hide();
            $('#eleventh_installmentDiv').hide();
            $('#twelfth_installmentDiv').hide();
        }
      });





      $('#number_of_installments').on('input',function(e){
          e.preventDefault();

          var number_of_installments=$(this).val();

          if(number_of_installments=='2'){



              $('#first_installmentDiv').show();
              $('#second_installmentDiv').show();
              $('#first_installmentDiv').addClass('col-6');
              $('#second_installmentDiv').addClass('col-6');



              $('#third_installmentDiv').hide();
              $('#fourth_installmentDiv').hide();
              $('#fifth_installmentDiv').hide();
              $('#sixth_installmentDiv').hide();
              $('#seventh_installmentDiv').hide();
              $('#eighth_installmentDiv').hide();
              $('#ninth_installmentDiv').hide();
              $('#tenth_installmentDiv').hide();
              $('#eleventh_installmentDiv').hide();
              $('#twelfth_installmentDiv').hide();


          }else if(number_of_installments=='3'){

              $('#first_installmentDiv').show();
              $('#second_installmentDiv').show();
              $('#third_installmentDiv').show();

              $('#first_installmentDiv').addClass('col-6');
              $('#second_installmentDiv').addClass('col-6');
              $('#third_installmentDiv').addClass('col-12');

              $('#fourth_installmentDiv').hide();
              $('#fifth_installmentDiv').hide();
              $('#sixth_installmentDiv').hide();
              $('#seventh_installmentDiv').hide();
              $('#eighth_installmentDiv').hide();
              $('#ninth_installmentDiv').hide();
              $('#tenth_installmentDiv').hide();
              $('#eleventh_installmentDiv').hide();
              $('#twelfth_installmentDiv').hide();

          }else if(number_of_installments=='4'){

              $('#first_installmentDiv').show();
              $('#second_installmentDiv').show();
              $('#third_installmentDiv').show();
              $('#fourth_installmentDiv').show();

              $('#first_installmentDiv').addClass('col-6');
              $('#second_installmentDiv').addClass('col-6');
              $('#third_installmentDiv').removeClass('col-12');
              $('#third_installmentDiv').addClass('col-6');
              $('#fourth_installmentDiv').addClass('col-6');


              $('#fifth_installmentDiv').hide();
              $('#sixth_installmentDiv').hide();
              $('#seventh_installmentDiv').hide();
              $('#eighth_installmentDiv').hide();
              $('#ninth_installmentDiv').hide();
              $('#tenth_installmentDiv').hide();
              $('#eleventh_installmentDiv').hide();
              $('#twelfth_installmentDiv').hide();

          }else if(number_of_installments=='5'){

              $('#first_installmentDiv').show();
              $('#second_installmentDiv').show();
              $('#third_installmentDiv').show();
              $('#fourth_installmentDiv').show();
              $('#fifth_installmentDiv').show();

              $('#first_installmentDiv').addClass('col-6');
              $('#second_installmentDiv').addClass('col-6');
              $('#third_installmentDiv').addClass('col-6');
              $('#fourth_installmentDiv').addClass('col-6');
              $('#fifth_installmentDiv').addClass('col-12');


              $('#sixth_installmentDiv').hide();
              $('#seventh_installmentDiv').hide();
              $('#eighth_installmentDiv').hide();
              $('#ninth_installmentDiv').hide();
              $('#tenth_installmentDiv').hide();
              $('#eleventh_installmentDiv').hide();
              $('#twelfth_installmentDiv').hide();

          }else if(number_of_installments=='6'){
              $('#first_installmentDiv').show();
              $('#second_installmentDiv').show();

              $('#third_installmentDiv').show();
              $('#fourth_installmentDiv').show();
              $('#fifth_installmentDiv').show();
              $('#sixth_installmentDiv').show();

              $('#first_installmentDiv').addClass('col-6');
              $('#second_installmentDiv').addClass('col-6');
              $('#third_installmentDiv').addClass('col-6');
              $('#fourth_installmentDiv').addClass('col-6');
              $('#fifth_installmentDiv').removeClass('col-12');
              $('#fifth_installmentDiv').addClass('col-6');
              $('#sixth_installmentDiv').addClass('col-6');

              $('#seventh_installmentDiv').hide();
              $('#eighth_installmentDiv').hide();
              $('#ninth_installmentDiv').hide();
              $('#tenth_installmentDiv').hide();
              $('#eleventh_installmentDiv').hide();
              $('#twelfth_installmentDiv').hide();


          }else if(number_of_installments=='7'){

              $('#first_installmentDiv').show();
              $('#second_installmentDiv').show();

              $('#third_installmentDiv').show();
              $('#fourth_installmentDiv').show();
              $('#fifth_installmentDiv').show();
              $('#sixth_installmentDiv').show();
              $('#seventh_installmentDiv').show();


              $('#first_installmentDiv').addClass('col-6');
              $('#second_installmentDiv').addClass('col-6');
              $('#third_installmentDiv').addClass('col-6');
              $('#fourth_installmentDiv').addClass('col-6');
              $('#fifth_installmentDiv').addClass('col-6');
              $('#sixth_installmentDiv').addClass('col-6');
              $('#seventh_installmentDiv').addClass('col-12');

              $('#eighth_installmentDiv').hide();
              $('#ninth_installmentDiv').hide();
              $('#tenth_installmentDiv').hide();
              $('#eleventh_installmentDiv').hide();
              $('#twelfth_installmentDiv').hide();


          }else if(number_of_installments=='8'){

              $('#first_installmentDiv').show();
              $('#second_installmentDiv').show();

              $('#third_installmentDiv').show();
              $('#fourth_installmentDiv').show();
              $('#fifth_installmentDiv').show();
              $('#sixth_installmentDiv').show();
              $('#seventh_installmentDiv').show();
              $('#eighth_installmentDiv').show();


              $('#first_installmentDiv').addClass('col-6');
              $('#second_installmentDiv').addClass('col-6');
              $('#third_installmentDiv').addClass('col-6');
              $('#fourth_installmentDiv').addClass('col-6');
              $('#fifth_installmentDiv').addClass('col-6');
              $('#sixth_installmentDiv').addClass('col-6');
              $('#seventh_installmentDiv').removeClass('col-12');
              $('#seventh_installmentDiv').addClass('col-6');
              $('#eighth_installmentDiv').addClass('col-6');


              $('#ninth_installmentDiv').hide();
              $('#tenth_installmentDiv').hide();
              $('#eleventh_installmentDiv').hide();
              $('#twelfth_installmentDiv').hide();



          }else if (number_of_installments=='9'){

              $('#first_installmentDiv').show();
              $('#second_installmentDiv').show();

              $('#third_installmentDiv').show();
              $('#fourth_installmentDiv').show();
              $('#fifth_installmentDiv').show();
              $('#sixth_installmentDiv').show();
              $('#seventh_installmentDiv').show();
              $('#eighth_installmentDiv').show();
              $('#ninth_installmentDiv').show();



              $('#first_installmentDiv').addClass('col-6');
              $('#second_installmentDiv').addClass('col-6');
              $('#third_installmentDiv').addClass('col-6');
              $('#fourth_installmentDiv').addClass('col-6');
              $('#fifth_installmentDiv').addClass('col-6');
              $('#sixth_installmentDiv').addClass('col-6');
              $('#seventh_installmentDiv').addClass('col-6');
              $('#eighth_installmentDiv').addClass('col-6');
              $('#ninth_installmentDiv').addClass('col-12');


              $('#tenth_installmentDiv').hide();
              $('#eleventh_installmentDiv').hide();
              $('#twelfth_installmentDiv').hide();

          }else if (number_of_installments=='10'){

              $('#first_installmentDiv').show();
              $('#second_installmentDiv').show();
              $('#third_installmentDiv').show();
              $('#fourth_installmentDiv').show();
              $('#fifth_installmentDiv').show();
              $('#sixth_installmentDiv').show();
              $('#seventh_installmentDiv').show();
              $('#eighth_installmentDiv').show();
              $('#ninth_installmentDiv').show();
              $('#tenth_installmentDiv').show();

              $('#first_installmentDiv').addClass('col-6');
              $('#second_installmentDiv').addClass('col-6');
              $('#third_installmentDiv').addClass('col-6');
              $('#fourth_installmentDiv').addClass('col-6');
              $('#fifth_installmentDiv').addClass('col-6');
              $('#sixth_installmentDiv').addClass('col-6');
              $('#seventh_installmentDiv').addClass('col-6');
              $('#eighth_installmentDiv').addClass('col-6');
              $('#ninth_installmentDiv').removeClass('col-12');
              $('#ninth_installmentDiv').addClass('col-6');
              $('#tenth_installmentDiv').addClass('col-6');
              $('#eleventh_installmentDiv').hide();
              $('#twelfth_installmentDiv').hide();


          }else if (number_of_installments=='11'){

              $('#first_installmentDiv').show();
              $('#second_installmentDiv').show();
              $('#third_installmentDiv').show();
              $('#fourth_installmentDiv').show();
              $('#fifth_installmentDiv').show();
              $('#sixth_installmentDiv').show();
              $('#seventh_installmentDiv').show();
              $('#eighth_installmentDiv').show();
              $('#ninth_installmentDiv').show();
              $('#tenth_installmentDiv').show();
              $('#eleventh_installmentDiv').show();

              $('#first_installmentDiv').addClass('col-6');
              $('#second_installmentDiv').addClass('col-6');
              $('#third_installmentDiv').addClass('col-6');
              $('#fourth_installmentDiv').addClass('col-6');
              $('#fifth_installmentDiv').addClass('col-6');
              $('#sixth_installmentDiv').addClass('col-6');
              $('#seventh_installmentDiv').addClass('col-6');
              $('#eighth_installmentDiv').addClass('col-6');
              $('#ninth_installmentDiv').removeClass('col-12');
              $('#ninth_installmentDiv').addClass('col-6');
              $('#tenth_installmentDiv').addClass('col-6');
              $('#eleventh_installmentDiv').addClass('col-12');
              $('#twelfth_installmentDiv').hide();

          } else if (number_of_installments=='12'){

              $('#first_installmentDiv').show();
              $('#second_installmentDiv').show();
              $('#third_installmentDiv').show();
              $('#fourth_installmentDiv').show();
              $('#fifth_installmentDiv').show();
              $('#sixth_installmentDiv').show();
              $('#seventh_installmentDiv').show();
              $('#eighth_installmentDiv').show();
              $('#ninth_installmentDiv').show();
              $('#tenth_installmentDiv').show();
              $('#eleventh_installmentDiv').show();
              $('#twelfth_installmentDiv').show();

              $('#first_installmentDiv').addClass('col-6');
              $('#second_installmentDiv').addClass('col-6');
              $('#third_installmentDiv').addClass('col-6');
              $('#fourth_installmentDiv').addClass('col-6');
              $('#fifth_installmentDiv').addClass('col-6');
              $('#sixth_installmentDiv').addClass('col-6');
              $('#seventh_installmentDiv').addClass('col-6');
              $('#eighth_installmentDiv').addClass('col-6');
              $('#ninth_installmentDiv').removeClass('col-12');
              $('#ninth_installmentDiv').addClass('col-6');
              $('#tenth_installmentDiv').addClass('col-6');
              $('#eleventh_installmentDiv').removeClass('col-12');
              $('#eleventh_installmentDiv').addClass('col-6');
              $('#twelfth_installmentDiv').addClass('col-6');



          } else{

              $('#first_installmentDiv').hide();
              $('#second_installmentDiv').hide();
              $('#third_installmentDiv').hide();
              $('#fourth_installmentDiv').hide();
              $('#fifth_installmentDiv').hide();
              $('#sixth_installmentDiv').hide();
              $('#seventh_installmentDiv').hide();
              $('#eighth_installmentDiv').hide();
              $('#ninth_installmentDiv').hide();
              $('#tenth_installmentDiv').hide();
              $('#eleventh_installmentDiv').hide();
              $('#twelfth_installmentDiv').hide();


          }


      });










    </script>





    <script>


        $('#sum_insured').on('input',function(e){
            e.preventDefault();

            var sum_insured=$(this).val();
            var vehicle_class=$('#vehicle_class').val();
            var insurance_class=$('#insurance_class').val();
            var insurance_type=$('#insurance_type').val();
            var claim_status=$('#claim_status').val();
            var tpp=$('#tpp').val();
            var carry_passenger=$('#carry_passenger').val();
            var number_of_seats= $('#number_of_seats').val();
            var number_of_tonnes= $('#number_of_tonnes').val();
            var type_of_risk= $('#type_of_risk').val();
            var group_of_risk= $('#group_of_risk').val();
            var state= $('#state').val();
            var risk_non_manufacturing= $('#risk_non_manufacturing').val();
            var risk_storage= $('#risk_storage').val();
            var risk_manufacturing= $('#risk_manufacturing').val();
            var risk_makuti= $('#risk_makuti').val();
            var insurance_type_money= $('#insurance_type_money').val();
            var insurance_type_liability= $('#insurance_type_liability').val();
            var commodity= $('#commodity').val();
            var marine_containerized= $('#marine_containerized').val();


            //PRIVATE CARS STARTS

            if(vehicle_class=='Private Cars') {


                if(insurance_type=='COMPREHENSIVE') {


                    if(claim_status=='Claims free'){

                        var percentage = 3.5;


                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if (claim_status=='With claim record'){

                        var percentage = 4;


                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else{


                    }





                }else if(insurance_type=='TPFT'){


                    var percentage = 2;


                    var actual_ex_vat = Math.round((((percentage / 100 * sum_insured) + +tpp) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(insurance_type=='TPO'){

                    var actual_ex_vat = 100000;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else{


                }
            }

            //PRIVATE CARS ENDS


            //M/cycle/3 Wheelers STARTS
            else if(vehicle_class=='M/cycle/3 Wheelers'){

             if(insurance_type=='COMPREHENSIVE(TWO WHEELERS)'){



                 if(claim_status=='Claims free'){


                     if(carry_passenger=='Yes'){

                         var percentage = 5;
                         var actual_ex_vat = Math.round((((percentage / 100 * sum_insured) + 15000) + Number.EPSILON) * 100) / 100;

                         $('#actual_ex_vat').val(actual_ex_vat);

                         var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                         $('#premium').val(premium);


                     }else if(carry_passenger=='No'){


                         var percentage = 5;
                         var actual_ex_vat = Math.round((((percentage / 100 * sum_insured)) + Number.EPSILON) * 100) / 100;

                         $('#actual_ex_vat').val(actual_ex_vat);

                         var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                         $('#premium').val(premium);



                     }else{



                     }





                 }else if (claim_status=='With claim record'){


                     if(carry_passenger=='Yes'){

                         var percentage = 6;
                         var actual_ex_vat = Math.round((((percentage / 100 * sum_insured) + 15000) + Number.EPSILON) * 100) / 100;

                         $('#actual_ex_vat').val(actual_ex_vat);

                         var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                         $('#premium').val(premium);


                     }else if(carry_passenger=='No'){


                         var percentage = 5;
                         var actual_ex_vat = Math.round((((percentage / 100 * sum_insured)) + Number.EPSILON) * 100) / 100;

                         $('#actual_ex_vat').val(actual_ex_vat);

                         var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                         $('#premium').val(premium);



                     }else{



                     }

                 }else{


                 }



             }else if(insurance_type=='COMPREHENSIVE(THREE WHEELERS)'){



                 if(claim_status=='Claims free'){


                     if(carry_passenger=='Yes'){

                         var percentage = 6;
                         var actual_ex_vat = Math.round((((percentage / 100 * sum_insured) + 45000) + Number.EPSILON) * 100) / 100;

                         $('#actual_ex_vat').val(actual_ex_vat);

                         var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                         $('#premium').val(premium);


                     }else if(carry_passenger=='No'){


                         var percentage = 6;
                         var actual_ex_vat = Math.round((((percentage / 100 * sum_insured)) + Number.EPSILON) * 100) / 100;

                         $('#actual_ex_vat').val(actual_ex_vat);

                         var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                         $('#premium').val(premium);



                     }else{



                     }





                 }else if (claim_status=='With claim record'){


                     if(carry_passenger=='Yes'){

                         var percentage = 7;
                         var actual_ex_vat = Math.round((((percentage / 100 * sum_insured) + 45000) + Number.EPSILON) * 100) / 100;

                         $('#actual_ex_vat').val(actual_ex_vat);

                         var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                         $('#premium').val(premium);


                     }else if(carry_passenger=='No'){


                         var percentage = 7;
                         var actual_ex_vat = Math.round((((percentage / 100 * sum_insured)) + Number.EPSILON) * 100) / 100;

                         $('#actual_ex_vat').val(actual_ex_vat);

                         var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                         $('#premium').val(premium);



                     }else{



                     }

                 }else{


                 }


             }else if(insurance_type=='TPFT(TWO WHEELERS)'){

                 var percentage = 3.5;

                 var actual_ex_vat = Math.round((((percentage / 100 * sum_insured) + +tpp) + Number.EPSILON) * 100) / 100;

                 $('#actual_ex_vat').val(actual_ex_vat);

                 var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                 $('#premium').val(premium);
             }else if(insurance_type=='TPFT(THREE WHEELERS)'){

                 var percentage = 3.5;

                 var actual_ex_vat = Math.round((((percentage / 100 * sum_insured) + +tpp) + Number.EPSILON) * 100) / 100;

                 $('#actual_ex_vat').val(actual_ex_vat);

                 var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                 $('#premium').val(premium);

             }else if(insurance_type=='TPO(TWO WHEELERS)'){


                 if(carry_passenger=='Yes'){

                     var additional=15000;
                     var actual_ex_vat = 50000 + +additional;

                     $('#actual_ex_vat').val(actual_ex_vat);

                     var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                     $('#premium').val(premium);


                 }else if(carry_passenger=='No'){


                     var additional=0;
                     var actual_ex_vat = 50000 + +additional;

                     $('#actual_ex_vat').val(actual_ex_vat);

                     var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                     $('#premium').val(premium);

                 }else{


                 }





             }else if(insurance_type=='TPO(THREE WHEELERS)'){



                 if(carry_passenger=='Yes'){

                     var additional=45000;
                     var actual_ex_vat = 75000 + +additional;

                     $('#actual_ex_vat').val(actual_ex_vat);

                     var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                     $('#premium').val(premium);


                 }else if(carry_passenger=='No'){


                     var additional=0;
                     var actual_ex_vat = 75000 + +additional;

                     $('#actual_ex_vat').val(actual_ex_vat);

                     var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                     $('#premium').val(premium);

                 }else{


                 }


             }
            }
            //M/cycle/3 Wheelers ENDS


            //Commercial Vehicles STARTS
        else if(vehicle_class=='Commercial Vehicles'){

if (insurance_type=='COMPREHENSIVE(Trailers manufactured locally/bought from the dealer and less than 10 years old)'){


    if(claim_status=='Claims free'){

        var percentage = 4;


        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

        $('#actual_ex_vat').val(actual_ex_vat);

        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

        $('#premium').val(premium);

    }else if (claim_status=='With claim record'){

        var percentage = 4.75;


        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

        $('#actual_ex_vat').val(actual_ex_vat);

        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

        $('#premium').val(premium);

    }else{


    }


}else if (insurance_type=='COMPREHENSIVE(Conversion trailers or trailers over 10)'){



    if(claim_status=='Claims free'){

        var percentage = 5.25;


        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

        $('#actual_ex_vat').val(actual_ex_vat);

        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

        $('#premium').val(premium);

    }else if (claim_status=='With claim record'){

        var percentage = 5.75;


        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

        $('#actual_ex_vat').val(actual_ex_vat);

        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

        $('#premium').val(premium);

    }else{


    }


}else if (insurance_type=='THIRD PARTY ONLY(Trailers)'){

    var actual_ex_vat = 100000;

    $('#actual_ex_vat').val(actual_ex_vat);

    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

    $('#premium').val(premium);

}else if (insurance_type=='COMPREHENSIVE(Steel tankers below 10 years)'){

    var percentage = 6;


    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

    $('#actual_ex_vat').val(actual_ex_vat);

    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

    $('#premium').val(premium);

}else if (insurance_type=='COMPREHENSIVE(Aluminium tankers below)'){

    var percentage = 7;

    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

    $('#actual_ex_vat').val(actual_ex_vat);

    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

    $('#premium').val(premium);

}else if (insurance_type=='COMPREHENSIVE(Tankers over 10 years old)'){

    var percentage = 8;

    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

    $('#actual_ex_vat').val(actual_ex_vat);

    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

    $('#premium').val(premium);

}else if(insurance_type=='TPFT(Tankers)'){

    var percentage = 4;

    var actual_ex_vat = Math.round((((percentage / 100 * sum_insured) + +tpp) + Number.EPSILON) * 100) / 100;

    $('#actual_ex_vat').val(actual_ex_vat);

    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

    $('#premium').val(premium);

}else if (insurance_type=='TPO(Tankers)'){

    var actual_ex_vat = 750000;

    $('#actual_ex_vat').val(actual_ex_vat);

    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

    $('#premium').val(premium);

}else if(insurance_type=='COMPREHENSIVE(Own goods)'){


    if(claim_status=='Claims free'){

        var percentage = 4.25;


        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

        $('#actual_ex_vat').val(actual_ex_vat);

        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

        $('#premium').val(premium);

    }else if (claim_status=='With claim record'){

        var percentage = 4.75;


        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

        $('#actual_ex_vat').val(actual_ex_vat);

        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

        $('#premium').val(premium);

    }else{


    }

}else if(insurance_type=='TPFT(Own goods)'){

    var percentage = 2.5;

    var actual_ex_vat = Math.round((((percentage / 100 * sum_insured) + +tpp) + Number.EPSILON) * 100) / 100;

    $('#actual_ex_vat').val(actual_ex_vat);

    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

    $('#premium').val(premium);

}else if(insurance_type=='General Cartage'){

    if(claim_status=='Claims free'){

        var percentage = 5;


        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

        $('#actual_ex_vat').val(actual_ex_vat);

        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

        $('#premium').val(premium);

    }else if (claim_status=='With claim record'){

        var percentage = 5.75;


        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

        $('#actual_ex_vat').val(actual_ex_vat);

        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

        $('#premium').val(premium);

    }else{


    }


}else if(insurance_type=='TPFT(General Cartage)'){

    var percentage = 3;

    var actual_ex_vat = Math.round((((percentage / 100 * sum_insured) + +tpp) + Number.EPSILON) * 100) / 100;

    $('#actual_ex_vat').val(actual_ex_vat);

    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

    $('#premium').val(premium);

}else if(insurance_type=='TPO'){


    if(number_of_tonnes=='Up to 2 tonnes'){

        var actual_ex_vat = 150000;

        $('#actual_ex_vat').val(actual_ex_vat);

        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

        $('#premium').val(premium);

    }else if(number_of_tonnes=='Above 2 to 5 tonnes'){

        var actual_ex_vat = 200000;

        $('#actual_ex_vat').val(actual_ex_vat);

        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

        $('#premium').val(premium);

    }else if(number_of_tonnes=='In excess of 5 tonnes but less than 10 tonnes'){

        var actual_ex_vat = 250000;

        $('#actual_ex_vat').val(actual_ex_vat);

        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

        $('#premium').val(premium);

    }else if(number_of_tonnes=='In excess of 10 tonnes'){

        var actual_ex_vat = 300000;

        $('#actual_ex_vat').val(actual_ex_vat);

        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

        $('#premium').val(premium);

    }else{



    }


}else{



}

            }


            //Commercial Vehicles ENDS

            //Passenger carrying STARTS

            else if(vehicle_class=='Passenger Carrying'){

                if(insurance_type=='COMPREHENSIVE(Public Taxis, private hire and tour operators)'){

                    if(claim_status=='Claims free'){

                        var percentage = 5.5;

                        var additional=15000;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + +additional) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if (claim_status=='With claim record'){

                        var percentage = 6;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else{


                    }

                }else if (insurance_type=='COMPREHENSIVE(Buses-Daladala within city)'){


                    var percentage = 8;
                    var amount_per_seat=15000;

                    var actual_ex_vat = Math.round((((percentage / 100 * sum_insured)+(+number_of_seats * +amount_per_seat )) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);



                }else if(insurance_type=='COMPREHENSIVE(Buses- Up country)'){

                    var percentage = 8;
                    var amount_per_seat=30000;

                    var actual_ex_vat = Math.round((((percentage / 100 * sum_insured)+(+number_of_seats * +amount_per_seat )) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                } else if(insurance_type=='COMPREHENSIVE(Buses- Private)'){

                    var percentage = 5;
                    var amount_per_seat=10000;

                    var actual_ex_vat = Math.round((((percentage / 100 * sum_insured)+(+number_of_seats * +amount_per_seat )) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                } else if(insurance_type=='COMPREHENSIVE(Buses- School)'){

                    var percentage = 5;
                    var amount_per_seat=7500;

                    var actual_ex_vat = Math.round((((percentage / 100 * sum_insured)+(+number_of_seats * +amount_per_seat )) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(insurance_type=='THIRD PARTY(Public Taxis, private hire and tour operators)'){


                    var amount_per_seat=15000;

                    var actual_ex_vat = Math.round((( +number_of_seats * +amount_per_seat ) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                } else if (insurance_type=='THIRD PARTY(Buses-Daladala within city)'){

                    var amount_per_seat=15000;

                    var actual_ex_vat = Math.round((( +number_of_seats * +amount_per_seat ) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(insurance_type=='THIRD PARTY(Buses- Up country)'){

                    var amount_per_seat=30000;

                    var actual_ex_vat = Math.round((( +number_of_seats * +amount_per_seat ) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(insurance_type=='THIRD PARTY(Buses- Private)'){

                    var amount_per_seat=10000;

                    var actual_ex_vat = Math.round((( +number_of_seats * +amount_per_seat ) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(insurance_type=='THIRD PARTY(Buses- School)'){

                    var amount_per_seat=7500;

                    var actual_ex_vat = Math.round((( +number_of_seats * +amount_per_seat ) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else{


                }

            }

            //Passenger carrying ENDS

            //Special type vehicles STARTS

            else if(vehicle_class=='Special Type Vehicles'){

                if(insurance_type=='COMPREHENSIVE'){

                    var percentage = 2;

                    var actual_ex_vat = Math.round((((percentage / 100 * sum_insured)) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(insurance_type=='THIRD PARTY'){

                    var actual_ex_vat = 100000;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else{


                }

            }

            //Special type vehicles ENDS


            //END FOR ALL

            else{



            }


            //Fire starts

            //Class 1 construction risk starts


            if (type_of_risk=='Class 1 construction risks'){

                //Non-manufacturing starts

                if(group_of_risk=='Non-manufacturing risks'){

                    if(risk_non_manufacturing=='Residences, Libraries, Museums, Schools and College and other educational institutions, places of worship, office'){

                        var percentage = 0.15;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_non_manufacturing=='Hospitals and Clinics, Auditoriums, club and mess houses'){

                        var percentage = 0.175;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_non_manufacturing=='Cafes, Restaurants, Kiosks and Shops selling Non-hazardous goods. Dry cleaners and laundries*, Confectioners*'){


                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_non_manufacturing=='Hotels, Inns, Resorts, Shopping Malls with multiple occupancy'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_non_manufacturing=='Shops dealing with hazardous goods as per list given, Petrol/Diesel stations, Motor vehicle showrooms(including Sales and service but excluding Garages)'){

                        var percentage = 0.25;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else{



                    }
                }

                //Non-manufacturing ends

                //Storage starts
                else if(group_of_risk=='Storage risks'){

            //In open starts
                    if(state=='In open') {

                        if (risk_storage == 'Non-hazardous goods') {

                            var percentage = 0.275;

                            var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                            $('#actual_ex_vat').val(actual_ex_vat);

                            var premium = Math.round((((18 / 100 * actual_ex_vat) + +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                            $('#premium').val(premium);

                        } else if (risk_storage == 'Transporters, Cargo movers, Warehouses in the Airport or Sea port') {

                            var percentage = 0.325;

                            var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                            $('#actual_ex_vat').val(actual_ex_vat);

                            var premium = Math.round((((18 / 100 * actual_ex_vat) + +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                            $('#premium').val(premium);

                        } else if (risk_storage == 'Hazardous goods as per list(ANNEXURE B)') {

                            var percentage = 0.35;

                            var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                            $('#actual_ex_vat').val(actual_ex_vat);

                            var premium = Math.round((((18 / 100 * actual_ex_vat) + +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                            $('#premium').val(premium);

                        } else {


                        }

                    }
                    //In open ends

                      //In house starts
                    else if(state=='Housed in a building'){

                        if (risk_storage == 'Non-hazardous goods') {

                            var percentage = 0.35;

                            var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                            $('#actual_ex_vat').val(actual_ex_vat);

                            var premium = Math.round((((18 / 100 * actual_ex_vat) + +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                            $('#premium').val(premium);

                        } else if (risk_storage == 'Transporters, Cargo movers, Warehouses in the Airport or Sea port') {

                            var percentage = 0.35;

                            var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                            $('#actual_ex_vat').val(actual_ex_vat);

                            var premium = Math.round((((18 / 100 * actual_ex_vat) + +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                            $('#premium').val(premium);

                        } else if (risk_storage == 'Hazardous goods as per list(ANNEXURE B)') {

                            var percentage = 0.35;

                            var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                            $('#actual_ex_vat').val(actual_ex_vat);

                            var premium = Math.round((((18 / 100 * actual_ex_vat) + +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                            $('#premium').val(premium);

                        } else {


                        }

                    }
                    //In house ends
                    else{



                    }

                }

                //Storage ends

                //Manufacturing starts
                else if(group_of_risk=='Manufacturing/industrial risks'){

                if(risk_manufacturing=='Aerated Water Factories'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Aircraft Hangers'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Airport Terminal Buildings(including all facilities like Cafes, shops etc.) excluding Cargo complex'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Aluminium, Zinc, Copper Factories'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Atta and Cereal Grinding(excluding Pulse Mills)'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Bakeries'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Basket Weavers and Cane Furniture Makers'){

                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Battery Manufacturing'){

                    var percentage = 0.25;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Biscuit Factories'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Bituminized Paper and or Hessian Cloth Manufacturing including Tar Felt Manufacturing'){

                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Book Binders, Envelope and Paper Bag Manufacturing'){


                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Breweries'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Brickworks(including refractories and fire bricks)'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);



                }else if(risk_manufacturing=='Bridges-Concrete/Steel'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Bridges-Wooden'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Building In Course of Construction'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Candle Works'){


                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Canning Factories'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Cardboard Box Manufacturing'){

                    var percentage = 0.25;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Carpenters, Wood wool Manufacturing. Furniture Manufacturing and other wood worker shops(excluding saw-mill)'){

                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Cashew nut Factories'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if (risk_manufacturing=='Cattle feed Mill'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Cement/asbestos/concrete products Manufacturing'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Cement Factories'){


                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Chemical Manufacturing'){

                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Cigar and Cigarette Manufacturing'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Video and Sound Recording rooms'){


                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Cinema Theatres'){


                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Cloth Processing units situated outside the compound of Textile mills'){


                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Coal/Coke/Charcoal ball & briquettes Manufacturing'){


                    var percentage = 0.35;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Coal processing plants'){



                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Coffee Curing, Roasting/Grinding'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Coir Factories'){


                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Collieries- underground Machinery and pit head gear'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Condensed Milk Factories, Milk pasteurizing Plants and Dairies'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Confectionery Manufacturing'){


                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Contractors Plant and Machinery- At one location only'){

                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Contractors Plant and Machinery- Anywhere in Tanzania(at specified locations)'){

                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Standalone Utilities'){

                    var percentage = 0.175;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Cotton seed cleaning/Delinting factory'){


                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Dehydration factories'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Detergent and soap Manufacturing'){


                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Distilleries'){

                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Electric Generation Stations- Hydro Power stations'){


                    var percentage = 0.25;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Electric Generation Stations- Other than Hydro'){


                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Electric Lamp/T.V. Picture Tube Manufacturing'){


                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Electronic goods manufacturing/assembly'){


                    var percentage = 0.25;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Electronic software parks'){


                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Engineering Workshop- Structural Steel fabricators, Sheet Metal fabricators, Hot/cold Rolling, Pipe Extruding, Stamping, Pressing,Forging Mills, Metal smelting, Foundries, Galvanizing works, Metal extraction, Ore processing(Other than Aluminium, Copper,Zinc)'){


                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Engineering Workshop(other than above), Clock/Watch manufacturing, motor vehicle garages'){


                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Exhibitions, fetes, shamianas of canvas or other cloth'){


                    var percentage = 0.35;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Fish, Sea food and meat processing'){


                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Flour Mills'){


                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Foamed plastics manufacturing and or converting plants'){


                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Foam rubber manufacturing'){


                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Fruit and vegetable processing including pulp making, drying/dehydration factories'){


                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Garment makers, hats and the like makers'){


                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Vegetable or Animal oil manufacturing including clarified butter'){


                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if (risk_manufacturing=='Glass wool Manufacturing'){


                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Glass Manufacturing'){


                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);



                }else if(risk_manufacturing=='Granite factories'){


                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Grain/seeds disintegrating/crushing/Decorticating factories/pulse mills'){


                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Grease/wax manufacturing'){


                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Green Houses'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Gum/glue/gelatin manufacturing'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Hosiery, lace, embroidery/thread factories'){

                    var percentage = 0.25;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if (risk_manufacturing=='Ice candy and Ice cream Manufacturing'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Ice factories'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Industrial gas manufacturing'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Jaggery(coarse brown sugar) manufacturing'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Leather cloth factories'){
                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Leather goods manufacturing(incl. boot/shoe)'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Lime Kiln'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='LPG(liquified petroleum gas) bottling plants'){

                    var percentage = 0.35;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Manure blending works'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Match factories'){

                    var percentage = 0.35;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Mattress and pillow making'){

                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Meat, fish or sea food processing'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if (risk_manufacturing=='Metal/tin printers'){

                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Mosaic factories'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Mushroom growing premises(excluding crops)'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Oil extraction'){

                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Oil distillation plants(essential)'){

                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Oil Mills refining(veg/animal)'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Oil and leather cloth factories'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Paint factories(water based)'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if (risk_manufacturing=='Paint(others) & varnish factories'){

                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Paper and cardboard mills(including lamination)'){

                    var percentage = 0.25;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Particle board manufacturing'){


                    var percentage = 0.25;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Pencil manufacturing'){

                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Plastic goods manufacturing(excluding foam plastics)'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Polyester film manufacturing/BOPP film manufacturing'){


                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Port premises including jetties and equipment thereon and other port facilities'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Poultry Farms(excluding birds therein)'){


                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Presses for coir fibres/waste/grass/fodder/boosa/Jute'){

                    var percentage = 0.35;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Presses for coir yarn/cotton/senna leaves'){

                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Presses for tobacco carpets and rugs'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Presses for hides and skins'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Printing Press'){

                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Pulverizing plants(metals and non-hazardous goods)'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Pulverizing plants(Others)'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);



                }else if (risk_manufacturing=='Rice mills'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Rice polishing units'){


                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Rope works(plastic), assembling of plastic goods such as toys and the like'){

                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Rope works(others)'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Rubber factories'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Rubber goods manufacturing'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Salt crushing factories and refineries'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if (risk_manufacturing=='Sanitary napkins/diapers/nappies manufacturers'){


                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if (risk_manufacturing=='Saw Mills(including timber merchants premises where sawing is done)'){

                    var percentage = 0.35;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Sea Food/meat processing'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Sponge iron plants'){

                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Spray Painting, Powder coating'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Stables(excluding animals)'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Starch factories'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Stones quarries'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Sugar candy manufacturing'){


                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Sugar factories'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Surgical cotton manufacturing'){

                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Tanneries'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Tapioca factories'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Tarpaulin and canvas proofing factories'){


                    var percentage = 0.325;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Tea blending/packing factories'){

                    var percentage = 0.25;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Tea factories'){

                    var percentage = 0.275;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Telephone exchanges'){


                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Textiles mills- spinning mills'){

                    var percentage = 0.25;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Textiles mills- composite mills'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Tile and pottery works'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Tobacco grinding/crushing Manufacturing'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Tobacco curing/re-drying factories'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Tyre retreading and resoling factories'){

                    var percentage = 0.30;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Weigh bridges'){

                    var percentage = 0.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Weaving mills(no blow room or carding activity)'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Wood seasoning/treatment/impregnation'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_manufacturing=='Woolen mills'){

                    var percentage = 0.225;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_manufacturing=='Cotton Gin and Press Houses'){


                    var percentage = 0.50;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else{




                }




                }else{



                }
                //Manufacturing ends


            }

            //Class 1 construction risk ends

            //Makuti/Thatched risks starts

            else if(type_of_risk=='Makuti/Thatched risks'){

                if(risk_makuti=='Structures completely or substantially of makuti/such material serving functionally as roof or walls'){


                    var percentage = 0.75;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(risk_makuti=='Structures with walls of burnt brick, stone or concrete blocks and roof of RCC slab with makuti/such material without functional value but only as a decorative structure'){


                    var percentage = 0.50;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else if(risk_makuti=='Identifiable functional units of a large complex with full or partial makuti or such material provided the total covered floor area of such units does not exceed 10% of the total built up floor area of the complex'){

                    var percentage = 0.40;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{



                }


            }

            //Makuti/Thatched risks ends


            //Other starts

           else if (type_of_risk=='Other'){

                //Non-manufacturing starts

                if(group_of_risk=='Non-manufacturing risks'){

                    if(risk_non_manufacturing=='Residences, Libraries, Museums, Schools and College and other educational institutions, places of worship, office'){

                        var percentage = 0.15;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_non_manufacturing=='Hospitals and Clinics, Auditoriums, club and mess houses'){

                        var percentage = 0.175;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_non_manufacturing=='Cafes, Restaurants, Kiosks and Shops selling Non-hazardous goods. Dry cleaners and laundries*, Confectioners*'){


                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_non_manufacturing=='Hotels, Inns, Resorts, Shopping Malls with multiple occupancy'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_non_manufacturing=='Shops dealing with hazardous goods as per list given, Petrol/Diesel stations, Motor vehicle showrooms(including Sales and service but excluding Garages)'){

                        var percentage = 0.25;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else{



                    }
                }

                //Non-manufacturing ends

                //Storage starts
                else if(group_of_risk=='Storage risks'){

                    //In open starts
                    if(state=='In open') {

                        if (risk_storage == 'Non-hazardous goods') {

                            var percentage = 0.275;

                            var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                            $('#actual_ex_vat').val(actual_ex_vat);

                            var premium = Math.round((((18 / 100 * actual_ex_vat) + +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                            $('#premium').val(premium);

                        } else if (risk_storage == 'Transporters, Cargo movers, Warehouses in the Airport or Sea port') {

                            var percentage = 0.325;

                            var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                            $('#actual_ex_vat').val(actual_ex_vat);

                            var premium = Math.round((((18 / 100 * actual_ex_vat) + +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                            $('#premium').val(premium);

                        } else if (risk_storage == 'Hazardous goods as per list(ANNEXURE B)') {

                            var percentage = 0.35;

                            var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                            $('#actual_ex_vat').val(actual_ex_vat);

                            var premium = Math.round((((18 / 100 * actual_ex_vat) + +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                            $('#premium').val(premium);

                        } else {


                        }

                    }
                    //In open ends

                    //In house starts
                    else if(state=='Housed in a building'){

                        if (risk_storage == 'Non-hazardous goods') {

                            var percentage = 0.35;

                            var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                            $('#actual_ex_vat').val(actual_ex_vat);

                            var premium = Math.round((((18 / 100 * actual_ex_vat) + +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                            $('#premium').val(premium);

                        } else if (risk_storage == 'Transporters, Cargo movers, Warehouses in the Airport or Sea port') {

                            var percentage = 0.35;

                            var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                            $('#actual_ex_vat').val(actual_ex_vat);

                            var premium = Math.round((((18 / 100 * actual_ex_vat) + +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                            $('#premium').val(premium);

                        } else if (risk_storage == 'Hazardous goods as per list(ANNEXURE B)') {

                            var percentage = 0.35;

                            var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                            $('#actual_ex_vat').val(actual_ex_vat);

                            var premium = Math.round((((18 / 100 * actual_ex_vat) + +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                            $('#premium').val(premium);

                        } else {


                        }

                    }
                    //In house ends
                    else{



                    }

                }

                //Storage ends

                //Manufacturing starts
                else if(group_of_risk=='Manufacturing/industrial risks'){

                    if(risk_manufacturing=='Aerated Water Factories'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Aircraft Hangers'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Airport Terminal Buildings(including all facilities like Cafes, shops etc.) excluding Cargo complex'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Aluminium, Zinc, Copper Factories'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Atta and Cereal Grinding(excluding Pulse Mills)'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Bakeries'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Basket Weavers and Cane Furniture Makers'){

                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Battery Manufacturing'){

                        var percentage = 0.25;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Biscuit Factories'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Bituminized Paper and or Hessian Cloth Manufacturing including Tar Felt Manufacturing'){

                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Book Binders, Envelope and Paper Bag Manufacturing'){


                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Breweries'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Brickworks(including refractories and fire bricks)'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);



                    }else if(risk_manufacturing=='Bridges-Concrete/Steel'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Bridges-Wooden'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Building In Course of Construction'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Candle Works'){


                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Canning Factories'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Cardboard Box Manufacturing'){

                        var percentage = 0.25;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Carpenters, Wood wool Manufacturing. Furniture Manufacturing and other wood worker shops(excluding saw-mill)'){

                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Cashew nut Factories'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if (risk_manufacturing=='Cattle feed Mill'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Cement/asbestos/concrete products Manufacturing'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Cement Factories'){


                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Chemical Manufacturing'){

                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Cigar and Cigarette Manufacturing'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Video and Sound Recording rooms'){


                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Cinema Theatres'){


                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Cloth Processing units situated outside the compound of Textile mills'){


                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Coal/Coke/Charcoal ball & briquettes Manufacturing'){


                        var percentage = 0.35;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Coal processing plants'){



                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Coffee Curing, Roasting/Grinding'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Coir Factories'){


                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Collieries- underground Machinery and pit head gear'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Condensed Milk Factories, Milk pasteurizing Plants and Dairies'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Confectionery Manufacturing'){


                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Contractors Plant and Machinery- At one location only'){

                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Contractors Plant and Machinery- Anywhere in Tanzania(at specified locations)'){

                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Standalone Utilities'){

                        var percentage = 0.175;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Cotton seed cleaning/Delinting factory'){


                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Dehydration factories'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Detergent and soap Manufacturing'){


                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Distilleries'){

                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Electric Generation Stations- Hydro Power stations'){


                        var percentage = 0.25;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Electric Generation Stations- Other than Hydro'){


                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Electric Lamp/T.V. Picture Tube Manufacturing'){


                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Electronic goods manufacturing/assembly'){


                        var percentage = 0.25;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Electronic software parks'){


                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Engineering Workshop- Structural Steel fabricators, Sheet Metal fabricators, Hot/cold Rolling, Pipe Extruding, Stamping, Pressing,Forging Mills, Metal smelting, Foundries, Galvanizing works, Metal extraction, Ore processing(Other than Aluminium, Copper,Zinc)'){


                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Engineering Workshop(other than above), Clock/Watch manufacturing, motor vehicle garages'){


                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Exhibitions, fetes, shamianas of canvas or other cloth'){


                        var percentage = 0.35;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Fish, Sea food and meat processing'){


                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Flour Mills'){


                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Foamed plastics manufacturing and or converting plants'){


                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Foam rubber manufacturing'){


                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Fruit and vegetable processing including pulp making, drying/dehydration factories'){


                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Garment makers, hats and the like makers'){


                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Vegetable or Animal oil manufacturing including clarified butter'){


                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if (risk_manufacturing=='Glass wool Manufacturing'){


                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Glass Manufacturing'){


                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);



                    }else if(risk_manufacturing=='Granite factories'){


                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Grain/seeds disintegrating/crushing/Decorticating factories/pulse mills'){


                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Grease/wax manufacturing'){


                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Green Houses'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Gum/glue/gelatin manufacturing'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Hosiery, lace, embroidery/thread factories'){

                        var percentage = 0.25;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if (risk_manufacturing=='Ice candy and Ice cream Manufacturing'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Ice factories'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Industrial gas manufacturing'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Jaggery(coarse brown sugar) manufacturing'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Leather cloth factories'){
                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Leather goods manufacturing(incl. boot/shoe)'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Lime Kiln'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='LPG(liquified petroleum gas) bottling plants'){

                        var percentage = 0.35;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Manure blending works'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Match factories'){

                        var percentage = 0.35;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Mattress and pillow making'){

                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Meat, fish or sea food processing'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if (risk_manufacturing=='Metal/tin printers'){

                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Mosaic factories'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Mushroom growing premises(excluding crops)'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Oil extraction'){

                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Oil distillation plants(essential)'){

                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Oil Mills refining(veg/animal)'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Oil and leather cloth factories'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Paint factories(water based)'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if (risk_manufacturing=='Paint(others) & varnish factories'){

                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Paper and cardboard mills(including lamination)'){

                        var percentage = 0.25;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Particle board manufacturing'){


                        var percentage = 0.25;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Pencil manufacturing'){

                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Plastic goods manufacturing(excluding foam plastics)'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Polyester film manufacturing/BOPP film manufacturing'){


                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Port premises including jetties and equipment thereon and other port facilities'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Poultry Farms(excluding birds therein)'){


                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Presses for coir fibres/waste/grass/fodder/boosa/Jute'){

                        var percentage = 0.35;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Presses for coir yarn/cotton/senna leaves'){

                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Presses for tobacco carpets and rugs'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Presses for hides and skins'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Printing Press'){

                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Pulverizing plants(metals and non-hazardous goods)'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Pulverizing plants(Others)'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);



                    }else if (risk_manufacturing=='Rice mills'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Rice polishing units'){


                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Rope works(plastic), assembling of plastic goods such as toys and the like'){

                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Rope works(others)'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Rubber factories'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Rubber goods manufacturing'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Salt crushing factories and refineries'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if (risk_manufacturing=='Sanitary napkins/diapers/nappies manufacturers'){


                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if (risk_manufacturing=='Saw Mills(including timber merchants premises where sawing is done)'){

                        var percentage = 0.35;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Sea Food/meat processing'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Sponge iron plants'){

                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Spray Painting, Powder coating'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Stables(excluding animals)'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Starch factories'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Stones quarries'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Sugar candy manufacturing'){


                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Sugar factories'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Surgical cotton manufacturing'){

                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Tanneries'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Tapioca factories'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Tarpaulin and canvas proofing factories'){


                        var percentage = 0.325;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Tea blending/packing factories'){

                        var percentage = 0.25;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Tea factories'){

                        var percentage = 0.275;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Telephone exchanges'){


                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Textiles mills- spinning mills'){

                        var percentage = 0.25;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Textiles mills- composite mills'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Tile and pottery works'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Tobacco grinding/crushing Manufacturing'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Tobacco curing/re-drying factories'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Tyre retreading and resoling factories'){

                        var percentage = 0.30;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Weigh bridges'){

                        var percentage = 0.20;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Weaving mills(no blow room or carding activity)'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Wood seasoning/treatment/impregnation'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else if(risk_manufacturing=='Woolen mills'){

                        var percentage = 0.225;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                    }else if(risk_manufacturing=='Cotton Gin and Press Houses'){


                        var percentage = 0.50;

                        var actual_ex_vat = Math.round(((percentage / 100 * sum_insured + (25/100* (percentage / 100 * sum_insured))  ) + Number.EPSILON) * 100) / 100;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);

                    }else{




                    }




                }else{



                }
                //Manufacturing ends


            }

            //Other ends


            else{

                     }



            //Fire ends


            //Money starts

            if(insurance_type_money=='Estimated annual cash carryings'){

                var percentage = 0.03;

                var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                $('#actual_ex_vat').val(actual_ex_vat);

                var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                $('#premium').val(premium);


            }else if(insurance_type_money=='Cash in transit limit'){

                var percentage = 1;

                var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                $('#actual_ex_vat').val(actual_ex_vat);

                var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                $('#premium').val(premium);


            }else if(insurance_type_money=='Money in custody of collectors'){


                var percentage = 1.25;

                var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                $('#actual_ex_vat').val(actual_ex_vat);

                var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                $('#premium').val(premium);

            }else if(insurance_type_money=='Money in safe during working hours'){

                var percentage = 0.63;

                var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                $('#actual_ex_vat').val(actual_ex_vat);

                var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                $('#premium').val(premium);

            }else if(insurance_type_money=='Money in safe outside working hours'){

                var percentage = 0.85;

                var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                $('#actual_ex_vat').val(actual_ex_vat);

                var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                $('#premium').val(premium);


            }else if(insurance_type_money=='Money in residence of director or partner'){

                var percentage = 1.25;

                var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                $('#actual_ex_vat').val(actual_ex_vat);

                var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                $('#premium').val(premium);


            }else if(insurance_type_money=='Value of safe'){

                var percentage = 0.54;

                var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                $('#actual_ex_vat').val(actual_ex_vat);

                var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                $('#premium').val(premium);


            }else{



            }

            //Money ends


            //Liability starts

            if(insurance_type_liability=='Public Liability'){

                var percentage = 0.15;

                var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                $('#actual_ex_vat').val(actual_ex_vat);

                var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                $('#premium').val(premium);

            }else if(insurance_type_liability=='Products Liability'){

                var percentage = 0.04;

                var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                $('#actual_ex_vat').val(actual_ex_vat);

                var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                $('#premium').val(premium);


            }else{




            }


            //Liability ends



            //Marine starts

            if(commodity=='Produce Raw Agricultural products including sisal cotton coffee tea cocoa rice in bags/bales/chests'){

                if(marine_containerized=='Containerized'){

                    var percentage = 0.25;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 0.40;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }



            }else if(commodity=='Grains in bags- maize, beans,peas excluding rain water, damage,infestation, contamination other than by  sea water'){


                if(marine_containerized=='Containerized'){

                    var percentage = 0.35;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 0.50;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else if(commodity=='Non fragile merchandise/manufact e.g machinery, iron products, not susceptible to pilferage Rust, oxidation and discolorization'){


                if(marine_containerized=='Containerized'){

                    var percentage = 0.35;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 0.50;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else if(commodity=='If susceptible to pilferage/water demage e.g spare parts,batteries,tyres,cigarettes, paper'){



                if(marine_containerized=='Containerized'){

                    var percentage = 0.50;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 0.80;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else if(commodity=='Semi-fragile general merchandise/manufactured goods e.g electrical appliances like refrigerators, radios etc. and domestic appliances like Thermos flasks, washing machine'){



                if(marine_containerized=='Containerized'){

                    var percentage = 0.85;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 1.50;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else if(commodity=='Fragile General Merchandise/manufactured goods e.g glass, glassware, glass louvers/sheets, chinaware, wines'){



                if(marine_containerized=='Containerized'){

                    var percentage = 1.20;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 2;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else if(commodity=='emical/products Tins'){


                if(marine_containerized=='Containerized'){

                    var percentage = 0.50;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 0.70;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else if(commodity=='Chemicals/Cement/fertilizer in bags excluding spillage, rain water damage, infestation other than by sea water'){


                if(marine_containerized=='Containerized'){

                    var percentage = 0.60;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 1;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else if(commodity=='Pharmaceuticals'){

                if(marine_containerized=='Containerized'){

                    var percentage = 0.70;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 1.2;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }

            }else if(commodity=='Foodstuffs and cans'){

                if(marine_containerized=='Containerized'){

                    var percentage = 0.40;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 0.6;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else if(commodity=='In Bags/cartons'){

                if(marine_containerized=='Containerized'){

                    var percentage = 0.50;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 0.7;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else if(commodity=='Bulk Cargo(petroleum products & edible oils)'){


                if(marine_containerized=='Containerized'){

                    var percentage = 0.25;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    // var percentage = 0.7;
                    //
                    // var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;
                    //
                    // $('#actual_ex_vat').val(actual_ex_vat);
                    //
                    // var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;
                    //
                    // $('#premium').val(premium);


                }else{




                }

            }else if(commodity=='Bulk cargo (grain & others)'){

                if(marine_containerized=='Containerized'){

                    var percentage = 0.25;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    // var percentage = 0.7;
                    //
                    // var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;
                    //
                    // $('#actual_ex_vat').val(actual_ex_vat);
                    //
                    // var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;
                    //
                    // $('#premium').val(premium);


                }else{




                }

            }else if(commodity=='Matches, fireworks, explosives, gunpowder, flammables, acids'){

                if(marine_containerized=='Containerized'){

                    var percentage = 1;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 1.5;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else if(commodity=='Copper and other precious metals'){

                if(marine_containerized=='Containerized'){

                    var percentage = 1;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 1.5;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else if(commodity=='Household goods and personal effects- professionally packed'){

                if(marine_containerized=='Containerized'){

                    var percentage = 1;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 1.5;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else if(commodity=='Household goods and personal effects- if otherwise'){

                if(marine_containerized=='Containerized'){

                    var percentage = 1.5;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);

                }else if(marine_containerized=='Non-containerized'){


                    var percentage = 2;

                    var actual_ex_vat = Math.round(((percentage / 100 * sum_insured) + Number.EPSILON) * 100) / 100;

                    $('#actual_ex_vat').val(actual_ex_vat);

                    var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                    $('#premium').val(premium);


                }else{




                }


            }else{



            }


            //Marine ends





            //Filling also commission field

            if(insurance_class=='FIRE'){

                var premium=$('#premium').val();

                var commission_percentage=25;

                var commission= Math.round(((commission_percentage/100*premium) + Number.EPSILON) * 100) / 100;

                $('#commission_percentage').val(commission_percentage);

                $('#commission').val(commission);

            }else if(insurance_class=='MOTOR'){

                var premium=$('#premium').val();

                var commission_percentage=12.5;

                var commission= Math.round(((commission_percentage/100*premium) + Number.EPSILON) * 100) / 100;

                $('#commission_percentage').val(commission_percentage);
                $('#commission').val(commission);


            }else if(insurance_class=='MONEY'){

                var premium=$('#premium').val();

                var commission_percentage=15;

                var commission= Math.round(((commission_percentage/100*premium) + Number.EPSILON) * 100) / 100;

                $('#commission_percentage').val(commission_percentage);
                $('#commission').val(commission);


            }else if(insurance_class=='LIABILITY'){

                var premium=$('#premium').val();

                var commission_percentage=15;

                var commission= Math.round(((commission_percentage/100*premium) + Number.EPSILON) * 100) / 100;

                $('#commission_percentage').val(commission_percentage);
                $('#commission').val(commission);


            }else if(insurance_class=='MARINE'){

                var premium=$('#premium').val();

                var commission_percentage=15;

                var commission= Math.round(((commission_percentage/100*premium) + Number.EPSILON) * 100) / 100;

                $('#commission_percentage').val(commission_percentage);
                $('#commission').val(commission);

            }




            else{




            }




        });



        $('#sum_insured_dropdown').on('input',function(e) {
            e.preventDefault();

            var id=$(this).val();

            $.ajax({
                url:"{{ route('get_actual_value') }}",
                method:"get",
                data:{id:id},
                success:function(data){
                    if(data=='0'){



                    }
                    else{







                        var actual_ex_vat = data;

                        $('#actual_ex_vat').val(actual_ex_vat);

                        var premium = Math.round((((18 / 100 * actual_ex_vat)+ +actual_ex_vat) + Number.EPSILON) * 100) / 100;

                        $('#premium').val(premium);


                        //for Commission


                        var commission_percentage=15;

                        var commission= Math.round(((commission_percentage/100*premium) + Number.EPSILON) * 100) / 100;

                        $('#commission_percentage').val(commission_percentage);
                        $('#commission').val(commission);


                    }
                }
            });




        });



        // $('#premium').on('input',function(e){
        //     e.preventDefault();
        //
        //
        //     //Filling also commission field
        //
        //     var premium=$('#premium').val();
        //
        //     var commission_percentage=$('#commission_percentage').val();
        //
        //     var commission= Math.round(((commission_percentage/100*premium) + Number.EPSILON) * 100) / 100;
        //
        //     $('#commission').val(commission);
        //
        //
        // });



    </script>




{{--    <script>--}}

{{--        $('.money_validate').on('input',function(e){--}}
{{--            e.preventDefault();--}}

{{--            var money_entered=$(this).val();--}}


{{--            if (money_entered<20) {--}}

{{--                document.getElementById("validate_money_msg").innerHTML ='Amount entered cannot be less than 20';--}}
{{--                document.getElementById("validate_money_msg").style.color='Red';--}}
{{--                document.getElementById("next2").disabled = true;--}}
{{--                document.getElementById("next2").style.backgroundColor='#dee2e6';--}}
{{--            }else{--}}
{{--                document.getElementById("next2").style.backgroundColor='#87ceeb';--}}

{{--                document.getElementById("next2").disabled = false;--}}
{{--                document.getElementById("validate_money_msg").innerHTML ='';--}}
{{--            }--}}


{{--            document.getElementById("validate_money_msg").style.color='Red';--}}



{{--        });--}}

{{--    </script>--}}





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



    <script type="text/javascript">
        $(document).ready(function() {


            $('#full_name').keyup(function(e){
                e.preventDefault();
                var query = $(this).val();



                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url:"{{ route('client_name_suggestions') }}",
                        method:"GET",
                        data:{query:query,_token:_token},
                        success:function(data){
                            if(data=='0'){
                                // $('#space_id_contract').attr('style','border:1px solid #f00');

                            }
                            else{

                                // $('#space_id_contract').attr('style','border:1px solid #ced4da');
                                $('#nameListClientName').fadeIn();
                                $('#nameListClientName').html(data);
                            }
                        }
                    });
                }
                else if(query==''){

                    // $('#space_id_contract').attr('style','border:1px solid #ced4da');
                    $('#nameListClientName').fadeOut();
                }
            });

            $(document).on('click', '#listClientName', function(){

                $('#full_name').val($(this).text());

                $('#nameListClientName').fadeOut();

            });

            $(document).on('blur', '#full_name', function(){



                $('#nameListClientName').fadeOut();

            });



            //For vehicle registration number
            $('#vehicle_registration_no').keyup(function(e){
                e.preventDefault();
                var query = $('#full_name').val();



                if(query != '')
                {
                    var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url:"{{ route('vehicle_registration_no_suggestions') }}",
                        method:"GET",
                        data:{query:query,_token:_token},
                        success:function(data){
                            if(data=='0'){
                                // $('#space_id_contract').attr('style','border:1px solid #f00');

                            }
                            else{

                                // $('#space_id_contract').attr('style','border:1px solid #ced4da');
                                $('#nameListVehicleRegistrationNumber').fadeIn();
                                $('#nameListVehicleRegistrationNumber').html(data);
                            }
                        }
                    });
                }
                else if(query==''){

                    // $('#space_id_contract').attr('style','border:1px solid #ced4da');
                    $('#nameListVehicleRegistrationNumber').fadeOut();
                }
            });

            $(document).on('click', '#listVehicleRegistrationNumber', function(){

                $('#vehicle_registration_no').val($(this).text());

                $('#nameListVehicleRegistrationNumber').fadeOut();

            });

            $(document).on('blur', '#vehicle_registration_no', function(){


                $('#nameListVehicleRegistrationNumber').fadeOut();

            });







            $('#insurance_class').click(function(){
                var query3=$(this).val();
                if(query3!=''){

                    $('#insurance_companyDiv').show();

                }
                else{
                    $('#insurance_companyDiv').hide();
                    $('#TypeDiv').hide();

                    var ele4 = document.getElementById("insurance_type");
                    ele4.required = false;
                    $('#TypeDivNA').hide();
                    document.getElementById("insurance_type_na").disabled = true;
                    $('#priceDiv').hide();
                    $('#commissionDiv').hide();
                    $('#insurance_currencyDiv').hide();

                }

                if($('#TypeDivNA:visible').length!=0) {
                    var query=$('#insurance_class').val();
                    if(query=='MOTOR'){
                        $('#TypeDiv').show();
                        $('#TypeDivNA').hide();
                        document.getElementById("insurance_type_na").disabled = true;
                    }else{
                        $('#TypeDiv').hide();
                        var ele5 = document.getElementById("insurance_type");
                        ele5.required = false;
                        $('#TypeDivNA').show();
                        document.getElementById("insurance_type_na").disabled = false;

                    }
                }else if($('#TypeDiv:visible').length!=0){
                    //starts
                    var query=$('#insurance_class').val();
                    if(query=='MOTOR'){
                        $('#TypeDiv').show();
                        $('#TypeDivNA').hide();
                        document.getElementById("insurance_type_na").disabled = true;
                    }else{
                        $('#TypeDiv').hide();
                        var ele6 = document.getElementById("insurance_type");
                        ele6.required = false;
                        $('#TypeDivNA').show();
                        document.getElementById("insurance_type_na").disabled = false;

                    }
                    //ends
                }else{


                }

            });

            // $('#insurance_company').click(function(){
            //     var query3=$(this).val();
            //     if(query3!=''){
            //         var insurance_class=document.getElementById("insurance_class").value;
            //         if(insurance_class=='MOTOR'){
            //             $('#TypeDiv').show();
            //         }else{
            //             $('#TypeDivNA').show();
            //             document.getElementById("insurance_type_na").disabled = false;
            //         }
            //
            //         $('#priceDiv').show();
            //         $('#commissionDiv').show();
            //         $('#insurance_currencyDiv').show();
            //         $('#billing').show();
            //     }
            //     else{
            //         $('#TypeDiv').hide();
            //         var ele7 = document.getElementById("insurance_type");
            //         ele7.required = false;
            //         $('#priceDiv').hide();
            //         $('#commissionDiv').hide();
            //         $('#insurance_currencyDiv').hide();
            //         $('#TypeDivNA').hide();
            //         $('#billing').hide();
            //         document.getElementById("insurance_type_na").disabled = true;
            //     }
            // });

        });


    </script>


{{--<script>--}}
{{--    $( document ).ready(function() {--}}


{{--        $('#space_id_contract').keyup(function(e){--}}
{{--            e.preventDefault();--}}
{{--            var query = $(this).val();--}}



{{--            if(query != '')--}}
{{--            {--}}
{{--                var _token = $('input[name="_token"]').val();--}}

{{--                var major_industry=document.getElementById("major_industry").value;--}}
{{--                var space_location=document.getElementById("space_location").value;--}}



{{--                $.ajax({--}}
{{--                    url:"{{ route('autocomplete.space_id') }}",--}}
{{--                    method:"GET",--}}
{{--                    data:{query:query,major_industry:major_industry,space_location:space_location, _token:_token},--}}
{{--                    success:function(data){--}}
{{--                        if(data=='0'){--}}
{{--                            $('#space_id_contract').attr('style','border:1px solid #f00');--}}

{{--                        }--}}
{{--                        else{--}}

{{--                            $('#space_id_contract').attr('style','border:1px solid #ced4da');--}}
{{--                            $('#nameListSpaceId').fadeIn();--}}
{{--                            $('#nameListSpaceId').html(data);--}}
{{--                        }--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}
{{--            else if(query==''){--}}

{{--                $('#space_id_contract').attr('style','border:1px solid #ced4da');--}}
{{--            }--}}
{{--        });--}}

{{--        $(document).on('click', '#listSpacePerTypeLocation', function(){--}}


{{--            $('#space_id_contract').attr('style','border:1px solid #ced4da');--}}

{{--            $('#space_id_contract').val($(this).text());--}}



{{--            $('#nameListSpaceId').fadeOut();--}}

{{--            //space already selected, fill size automatically--}}
{{--            var selected_space_id=$(this).text();--}}

{{--            $.ajax({--}}
{{--                url:"{{ route('autocomplete.space_size') }}",--}}
{{--                method:"get",--}}
{{--                data:{selected_space_id:selected_space_id},--}}
{{--                success:function(data){--}}
{{--                    if(data=='0'){--}}
{{--                        $('#space_size').attr('style','border:1px solid #f00');--}}


{{--                    }--}}
{{--                    else{--}}




{{--                        $('#space_size').attr('style','border:1px solid #ced4da');--}}
{{--                        $('#space_size').val(data);--}}

{{--                    }--}}
{{--                }--}}
{{--            });--}}




{{--        });--}}








{{--    });--}}


{{--</script>--}}

    <script>

        function minCharacters(value){



            if(value.length<9){

                document.getElementById("next1").disabled = true;
                document.getElementById("error_tin").style.color = 'red';
                document.getElementById("error_tin").style.float = 'left';
                document.getElementById("error_tin").style.paddingTop = '1%';
                document.getElementById("error_tin").innerHTML ='TIN number cannot be less than 9 digits';

            }else{
                document.getElementById("error_tin").innerHTML ='';
                document.getElementById("next1").disabled = false;
            }

        }


    </script>



@endsection
