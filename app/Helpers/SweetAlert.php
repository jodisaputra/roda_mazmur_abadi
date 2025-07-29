<?php

if (!function_exists('sweet_alert_success')) {
    /**
     * Display success alert
     */
    function sweet_alert_success($title = 'Success!', $message = '')
    {
        alert()->success($title, $message);
    }
}

if (!function_exists('sweet_alert_error')) {
    /**
     * Display error alert
     */
    function sweet_alert_error($title = 'Error!', $message = '')
    {
        alert()->error($title, $message);
    }
}

if (!function_exists('sweet_alert_warning')) {
    /**
     * Display warning alert
     */
    function sweet_alert_warning($title = 'Warning!', $message = '')
    {
        alert()->warning($title, $message);
    }
}

if (!function_exists('sweet_alert_info')) {
    /**
     * Display info alert
     */
    function sweet_alert_info($title = 'Info!', $message = '')
    {
        alert()->info($title, $message);
    }
}
