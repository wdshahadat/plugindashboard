<?php

function assets($filePath = '')
{
    $filePath = 'public/' . str_replace('public', '', $filePath);
    $filePath = str_replace(['//', '///'], '/', $filePath);
    return asset($filePath);
}

function notification()
{
    return false;
}
