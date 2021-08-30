<?php

function assets($filePath = '')
{
    $host = $_SERVER['HTTP_HOST'];
    $filePath = (strpos($host, ':8000') ? '' : 'public/') . str_replace('public', '', $filePath);

    $filePath = str_replace(['//', '///'], '/', $filePath);
    return asset($filePath);
}
