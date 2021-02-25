<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\space_contract;
use App\carContract;
use App\Notifications\ContractEnd;
use App\Notifications\InsuranceEnd;
use App\Notifications\InsuranceEnd2;
use Notification;
use App\insurance_contract;

class NotifyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ContractEnd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to user whose contracts are about to expire';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $space_contracts = space_contract::select('space_contracts.full_name','email','start_date', 'end_date', 'contract_id')
                                    ->join('clients','clients.full_name','=','space_contracts.full_name')
                                    ->whereRaw('DATEDIFF(end_date,CURDATE()) = 30')
                                    ->where('contract_category','Unsolicited')
                                    ->get();
        $salutation = "Real Estate Department UDSM.";

        foreach ($space_contracts as $contract) {
            # code...

            Notification::route('mail', $contract->email)->notify(new ContractEnd($contract->full_name, $contract->start_date, $contract->end_date, $contract->contract_id, $salutation));
        }

        $insurance_contracts = insurance_contract::select('full_name','vehicle_registration_no','insurance_class','commission_date','end_date','email')
                            ->whereRaw('DATEDIFF(end_date,CURDATE()) = 30')
                            ->get();
        $saluatation2 = 'University of Dar es Salaam Insurance Agency.';

        foreach ($insurance_contracts as $contract) {
            # code...
            if($contract->insurance_class=='MOTOR'){
                Notification::route('mail', $contract->email)->notify(new InsuranceEnd($contract->full_name, $contract->commission_date, $contract->end_date, $contract->vehicle_registration_no, $saluatation2));
            }
            else{
               Notification::route('mail', $contract->email)->notify(new InsuranceEnd2($contract->full_name, $contract->commission_date, $contract->end_date, $saluatation2));  
            }
            
        }

        
        
    }
}
