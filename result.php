<?php


include('inc/functions.php');

$newRecords = array();

foreach ($_GET['entries'] as $type => $records) {
    foreach ($records as $record => $recordActions) {
        if (isset($recordActions['include'])) {

            if (isset($recordActions['resolve'])) {

                $resolved = dns_get_record($record, DNS_TXT);

                if(isset($resolved[0]['entries'])) {

                    foreach($resolved as $entry) {

                        $entry = $entry['txt'];

                        if(substr($entry, 0, 7) == "v=spf1 ") {

                            $strictness = substr($type, 0, 1);

                            if(!in_array($strictness, array('-', '?'))) $strictness = '';

                            foreach(getEntries($entry) as $newtype => $entries) {
                                foreach($entries as $entry) {
                                    $newRecords[$strictness.$newtype][] = $entry;
                                }
                            }
                        }

                    }
                }

            } else {
                $newRecords[$type][] = $record;
            }

        }
    }
}

$parts = array();

foreach($newRecords as $type=>$records) {
    foreach($records as $entry) {
        $parts[] = $type.":".$entry;
    }
}

$spf = "v=spf1 ";

if(isset($_GET['base'])) foreach($_GET['base'] as $type=>$val) {
    $spf .= " ".$type." ";
}

$spf .= implode(" ", $parts)." ".$_GET['strictness']."all";

echo $spf;