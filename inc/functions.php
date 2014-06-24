<?php

function getEntries ($record) {

    $parts = explode(" ", $record);

    $entries = array();

    foreach ($parts as $part) {

        $entry = explode(":", $part);

        if (count($entry) > 1) {

            $type = $entry[0];
            unset($entry[0]);

            $addr = implode(':', $entry);

            if (substr($type, 0, 1) == "+") {
                $type = ltrim($type, '+');;
            }

            $entries[strtolower($type)][] = strtolower($addr);
        }

    }

    return $entries;
}