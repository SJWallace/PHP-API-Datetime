<?php
function date_string_processor($date, $timezone='Europe/London')
{
    try {
        $date = date_create($date, timezone_open($timezone));
        if ($date == False) {
            throw new Exception('Format date string as YYYY-MM-DD. Timezone 
            as defined at https://www.w3schools.com/php/php_ref_timezones.asp');
        }
    } catch (Exception $e) {
        echo 'Message: ' .$e->getMessage();
    } finally {
        echo date_format($date, 'Y/m/d');
    }
}

date_string_processor("20b");