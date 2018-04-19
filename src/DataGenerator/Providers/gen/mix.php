<?php

function mix($bases, $prefixes, $suffixes, $value) {

    $items = [];
    foreach ($bases as $base) {
        $items[$base] = $value;

        foreach ($prefixes as $prefix) {
            $items[$prefix . ' ' . $base] = $value;

            foreach ($suffixes as $suffix) {
                $items[$prefix . ' ' . $base . ' ' . $suffix] = $value;
            }
        }

        foreach ($suffixes as $suffix) {
            $items[$base . ' ' . $suffix] = $value;
        }

    }

    ksort($items);

    return $items;
}