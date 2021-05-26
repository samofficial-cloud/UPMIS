<?php

namespace App\Exports;

use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\ResearchContractsFormat;
class researchContractsExport implements FromQuery, WithHeadings{




    public function query()
    {

        return ResearchContractsFormat::select('client_category','client_type','campus_individual','college_individual','department_individual','first_name','last_name','gender','professional','address','email','phone_number','tin','nationality','purpose','passport_no','issue_date','issue_place','id_type','id_number','host_name','campus_host','college_host','department_host','host_address','host_email','host_phone','room_no','arrival_date','arrival_time','departure_date','payment_mode','amount_usd','amount_tzs','total_usd','total_tzs','receipt_no','receipt_date','total_days','invoice_debtor','invoice_currency');


    }



    public function headings(): array
    {
        return [
            'Client Category',
            'Client Type',
            'Campus(Client)',
            'College(Client)',
            'Department(Client)',
            'First Name(Client)',
            'Last Name(Client)',
            'Gender(Client)',
            'Professional(Client)',
            'Address(Client)',
            'Email(Client)',
            'Phone Number(Client)',
            'TIN(Client)',
            'Nationality(Client)',
            'Purpose of Visit',
            'Passport Number(Client)',
            'Issue Date',
            'Issue Place',
            'Type of Identification Card',
            'Identification Card Number',
            'Full name(Host)',
            'Campus(Host)',
            'College(Host)',
            'Department(Host)',
            'Address(Host)',
            'Email(Host)',
            'Phone Number(Host)',
            'Room No',
            'Date of Arrival',
            'Time of Arrival',
            'Date of Departure',
            'Mode of Payment',
            'Room Rate(USD)',
            'Room Rate(TZS)',
            'Total (USD)',
            'Total (TZS)',
            'Receipt No',
            'Receipt Date',
            'Total No. of days',
            'Invoice Debtor',
            'Invoice Currency'
        ];
    }






}
