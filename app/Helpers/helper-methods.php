<?php

if (!function_exists('isApi')) {
    function isApi()
    {
        $requestSegments = collect(request()->segments());
        return $requestSegments->first() == 'api';
    }
}