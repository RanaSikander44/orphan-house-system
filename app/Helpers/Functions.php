<?php
if (!function_exists('getGreeting')) {
    function getGreeting()
    {
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