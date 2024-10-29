<?php 

// namespace App\Helpers;

use Carbon\Carbon;



    if(!function_exists('formatDate'))
    {
        function formatDate($date)
        {
            if(!$date)
            {
                return '-';
            }
            return Carbon::parse($date)->format('d/m/Y H:i A');
        }
    }

    if(!function_exists('dateDifference'))
    {
        function dateDifference($first, $second)
        {
            if(!$second)
            {
                return '-';
            }
            return Carbon::parse($first)->diffInMinutes($second);
        }
    }
