<?php

namespace App\Console\Commands;


use App\Models\Schools;
use App\Models\payment;
use App\Models\settings;
use Carbon\Carbon;
use App\Models\Payment_renewal;
use App\Models\child;
use Illuminate\Support\Facades\Log;

use Illuminate\Console\Command;

class DonorPaymentRenewal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DonorPaymentRenewal:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $this->info('Payment Renewal Running !');

        $renewalPayments = Payment_renewal::where('end_date', Carbon::today())->get();

        if ($renewalPayments->isEmpty()) {
            $this->info('No renewal payments found for today.');
            return;
        }


        foreach ($renewalPayments as $list) {
            $payments = payment::where('id', $list->payment_id)->get();


            foreach ($payments as $pay) {

                $newPayment = new payment();
                $newPayment->paid_by = $pay->paid_by;
                $newPayment->child_id = $pay->child_id;
                $newPayment->amount_paid = $pay->amount_paid;
                $newPayment->card_number = $pay->card_number;
                $newPayment->exp_month = $pay->exp_month;
                $newPayment->exp_year = $pay->exp_year;
                $newPayment->cvc = $pay->cvc;
                $newPayment->cardholder_name = $pay->cardholder_name;
                $newPayment->save();

            }



            $list->end_date = Carbon::now()->addMonths(1);
            $list->save();

        }



        $this->info('Payment Renewal Completed!');
    }

}
