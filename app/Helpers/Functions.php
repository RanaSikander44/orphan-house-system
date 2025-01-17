<?php

use App\Models\Schools;
use App\Models\payment;
use App\Models\settings;
use Carbon\Carbon;
use App\Models\Payment_renewal;
use App\Models\child;
use Illuminate\Support\Facades\Log;




if (!function_exists('getGreeting')) {
    function getGreeting()
    {
        // Set the default timezone to Asia/Karachi
        date_default_timezone_set('Asia/Karachi');

        $currentHour = date('H');

        if ($currentHour >= 0 && $currentHour < 12) {
            $greeting = 'Good Morning';
        } elseif ($currentHour >= 12 && $currentHour < 18) {
            $greeting = 'Good Afternoon';
        } else {
            $greeting = 'Good Evening';
        }

        return $greeting;
    }
}


if (!function_exists('DonationPaymnetRenewal')) {
    function DonationPaymnetRenewal()
    {
        
    }
}



