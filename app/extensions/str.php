<?php

Str::macro('extract', function($prefix, $string, $suffix) {
    $prefixLength = Str::length($prefix);
    $length = Str::length($string) - (Str::length($suffix) + $prefixLength);
    return substr($string, $prefixLength, $length);
});

Str::macro('split', function($delimiter, $string, $limit = null) {
    return Illuminate\Support\Collection::make(explode($delimiter, $string));
});