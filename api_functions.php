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
    $total_days = date_diff($end_date, $start_date)->days;
    return $total_days;
}

function weeks_between_dates($start_date, $end_date) {
    $total_days= days_between_dates($start_date, $end_date);
    $total_weeks = floor($total_days / 7);
    return $total_weeks;
}

function weekdays_between_dates($start_date, $end_date) {
    $start_weekday = date_string_processor($start_date)->format('N');
    $total_weeks = weeks_between_dates($start_date, $end_date);
    $total_days = days_between_dates($start_date, $end_date);
    $remaining_weekdays = $total_days % 7;
    $weekday_mask = array(0,1,2,3,4); // make weekday mask, 5 & 6 represent saturday and sunday
    $extra_weekdays = array_pad(array_fill(0,$remaining_weekdays,1),7,0);
}

function rotate_array($array, $amount) {
    for ($i =0; $i < $amount; $i++) {
        array_push($array, array_shift($array));
    }
    return $array;
}

function create_weekday_array($number) {
    $array = array_pad(array_fill(0,$number,1),7,0);
    return $array;
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

$test_array = create_weekday_array(3);
print_r($test_array);
echo '</br>';
$test_array = rotate_array($test_array,1);
print_r($test_array);
