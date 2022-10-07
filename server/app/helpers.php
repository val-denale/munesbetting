<?php

if (!function_exists('formatBoolean')) {
    function formatBoolean($boolean): String
    {
        return $boolean ? "Oui" : "Non";
    }
}
