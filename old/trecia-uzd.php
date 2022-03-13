<?php

for($years = 2015; $years < 2022; $years++){
    for($months = 1; $months <= 12; $months++){
        $days = cal_days_in_month(CAL_GREGORIAN, $months, $years);
        for($day = 1; $day <= $days; $day++){
            echo $years.' '.$months.' '.$day;
            echo '<br>';
        }
    }
}