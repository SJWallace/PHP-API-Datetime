<?php


function date_string_processor($date, $timezone='Europe/London')
{
    try {
        $date = date_create($date, timezone_open($timezone));
        if ($date == False) {
            print_r(date_get_last_errors());
            throw new Exception('Format date string as YYYY-MM-DD. Timezone 
            as defined at https://www.w3schools.com/php/php_ref_timezones.asp');
        }
    } catch (Exception $e) {
        echo 'Message: ' .$e->getMessage();
        exit();
    } finally {
        return $date;
    }
}

function days_between_dates($start_date, $end_date) {
    $start_date = date_string_processor($start_date);
    $end_date = date_string_processor($end_date);
    return date_diff($end_date, $start_date)->days;
}

function weeks_between_dates($start_date, $end_date) {
    $total_days= days_between_dates($start_date, $end_date);
    return floor($total_days / 7);
}

function weekdays_between_dates($start_date, $end_date) {
    $start_weekday = date_string_processor($start_date)->format('N');
    $total_weeks = weeks_between_dates($start_date, $end_date);
    $total_days = days_between_dates($start_date, $end_date);
    $remaining_weekdays = $total_days % 7;
    $weekday_mask = array(0,1,2,3,4); // make weekday mask, 5 & 6 represent saturday and sunday
    $day_counts = array_pad(array_fill(0,$remaining_weekdays,1),7,0);
    $day_counts = rotate_array($day_counts, $start_weekday-1);
    foreach ($day_counts as &$weekday) {
        $weekday = $weekday + $total_weeks;
    }
    $total_weekdays = 0;
    foreach ($weekday_mask as $weekday) {
        $total_weekdays += $day_counts[$weekday];
    }
    return $total_weekdays;
}

function rotate_array($array, $amount) {
    for ($i =0; $i < $amount; $i++) {
        array_push($array, array_shift($array));
    }
    return $array;
}

function create_weekday_array($number) {
    return array_pad(array_fill(0,$number,1),7,0);
}

$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$timezone = $_GET['timezone'];
$report_units = $_GET['report_units'];
$time_units = $_GET['time_units'];

echo days_between_dates($start_date, $end_date);
echo '</br>';
echo weeks_between_dates($start_date, $end_date);
echo '</br>';
echo weekdays_between_dates($start_date, $end_date);
echo '</br>';

