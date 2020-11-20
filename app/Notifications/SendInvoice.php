<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use PDF;

class SendInvoice extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    protected $name;
    protected $invoice_number;
    protected $project_id;
    protected $debtor_account_code;
    protected $debtor_name;
    protected $debtor_address;
    protected $amount_to_be_paid;
    protected $currency;
    protected $gepg_control_no;
    protected $tin;
    protected $max_no_of_days_to_pay;
    protected $status;
    protected $vrn;
    protected $amount_in_words;
    protected $inc_code;
    protected $invoice_date;
    protected $financial_year;
    protected $period;
    protected $description;
    protected $prepared_by;
    protected $approved_by;
    protected $programming_start_date;
    protected $programming_end_date;


    public function __construct($name,$invoice_number,$project_id,$debtor_account_code,$debtor_name,$debtor_address,$amount_to_be_paid,$currency,$gepg_control_no,$tin,$max_no_of_days_to_pay,$status,$vrn,$amount_in_words,$inc_code,$invoice_date,$financial_year,$period,$description,$prepared_by,$approved_by,$programming_start_date,$programming_end_date)
    {
        $this->name = $name;
        $this->invoice_number = $invoice_number;
        $this->project_id = $project_id;
        $this->debtor_account_code = $debtor_account_code;
        $this->debtor_name = $debtor_name;
        $this->debtor_address = $debtor_address;
        $this->amount_to_be_paid = $amount_to_be_paid;
        $this->currency = $currency;
        $this->gepg_control_no = $gepg_control_no;
        $this->tin = $tin;
        $this->max_no_of_days_to_pay = $max_no_of_days_to_pay;
        $this->status = $status;
        $this->vrn = $vrn;
        $this->amount_in_words = $amount_in_words;
        $this->inc_code = $inc_code;
        $this->invoice_date = $invoice_date;
        $this->financial_year = $financial_year;
        $this->period = $period;
        $this->description = $description;
        $this->prepared_by = $prepared_by;
        $this->approved_by = $approved_by;
        $this->programming_start_date = $programming_start_date;
        $this->programming_end_date = $programming_end_date;


    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $today=date('d/m/Y');

        $data = [
            'invoice_number'   => $this->invoice_number,
            'project_id' => $this->project_id,
            'debtor_account_code'  => $this->debtor_account_code,
            'debtor_name'   => $this->debtor_name,
            'debtor_address' => $this->debtor_address,
            'amount_to_be_paid'  => $this->amount_to_be_paid,
            'currency'   => $this->currency,
            'gepg_control_no' => $this->gepg_control_no,
            'tin'  => $this->tin,
            'vrn'   => $this->vrn,
            'invoice_date' =>date("d/m/Y",strtotime($this->invoice_date)) ,
            'period'  => $this->period,
            'financial_year'   => $this->financial_year,
            'max_no_of_days_to_pay' => $this->max_no_of_days_to_pay,
            'status'  => $this->status,
            'inc_code'   => $this->inc_code,
            'amount_in_words' => $this->amount_in_words,
            'description' => $this->description,
            'prepared_by' => $this->prepared_by,
            'approved_by' => $this->approved_by,
            'today' => $today
        ];

        $pdf = PDF::loadView('invoice_pdf',$data);

        return (new MailMessage)
            ->greeting('Dear ' . ($this->name) . ',')
            ->subject('INVOICE')
            ->line(' Please find the attached invoice for the period between '.$this->programming_start_date.' and '.$this->programming_end_date.'.')
            ->attachData($pdf->output(), "invoice.pdf");



    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}









