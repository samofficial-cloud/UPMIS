<?php

namespace App\Exports;

use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\SpaceContractsFormat;
use Maatwebsite\Excel\Concerns\WithHeadings;

class spaceContractsExport implements FromCollection{




    public function collection()
    {
//        $result=collect([]);
//
//        $data = [
//
//            'full_name'   => 'Andrew Moses',
//            'space_id_contract'   => 'Andrew Moses',
//            'academic_dependence'   => 'Yes',
//            'academic_season'   => '560000',
//            'vacation_season'   => '400000',
//            'amount'   => '0',
//            'start_date'   => '2019-05-12',
//            'duration'   => '2',
//            'duration_period'=> 'Years',
//            'end_date'   => '2022-03-12',
//            ''   => '',
//            'phone_number'   => $request->get('phone_number'),
//            'email'   => $request->get('email'),
//            'major_industry'   => $request->get('major_industry'),
//            'minor_industry'   => $request->get('minor_industry'),
//            'location'   => $request->get('space_location'),
//            'sub_location'   => $request->get('space_sub_location'),
//            'space_number'   => $request->get('space_id_contract'),
//            'space_size'   => $request->get('space_size'),
//            'has_water_bill'   => $request->get('has_water_bill'),
//            'has_electricity_bill'   => $request->get('has_electricity_bill'),
//
//
//            'rent_sqm'   => $request->get('rent_sqm'),
//            'payment_cycle'   => $request->get('payment_cycle'),
//            'escalation_rate'   => $request->get('escalation_rate'),
//            'currency'   => $request->get('currency'),
//
//
//        ];
//
//        return $result->push($data);


        return SpaceContractsFormat::all();


    }



//    public function headings(): array
//    {
//        return [
//            '#',
//            'Date',
//        ];
//    }






}
