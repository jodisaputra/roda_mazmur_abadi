<?php

if (!function_exists('sweet_alert_success')) {
    /**
     * Display success alert
     */
    function sweet_alert_success($title = 'Success!', $message = '')
    {
        session()->flash('sweet_alert', [
            'type' => 'success',
            'title' => $title,
            'message' => $message
        ]);
    }
}

if (!function_exists('sweet_alert_error')) {
    /**
     * Display error alert
     */
    function sweet_alert_error($title = 'Error!', $message = '')
    {
        session()->flash('sweet_alert', [
            'type' => 'error',
            'title' => $title,
            'message' => $message
        ]);
    }
}

if (!function_exists('sweet_alert_warning')) {
    /**
     * Display warning alert
     */
    function sweet_alert_warning($title = 'Warning!', $message = '')
    {
        session()->flash('sweet_alert', [
            'type' => 'warning',
            'title' => $title,
            'message' => $message
        ]);
    }
}

if (!function_exists('sweet_alert_info')) {
    /**
     * Display info alert
     */
    function sweet_alert_info($title = 'Info!', $message = '')
    {
        session()->flash('sweet_alert', [
            'type' => 'info',
            'title' => $title,
            'message' => $message
        ]);
    }
}
