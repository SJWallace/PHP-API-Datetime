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
//        echo date_format($date, 'Y/m/d H:i:s');
        return $date;
    }
}

function time_between_dates($start_date, $end_date) {
    $start_date = date_string_processor($start_date);
    $end_date = date_string_processor($end_date);
    $time_interval = date_diff($end_date, $start_date);
    return $time_interval->format('%R%a');
}

$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$timezone = $_GET['timezone'];

echo time_between_dates($start_date, $end_date);