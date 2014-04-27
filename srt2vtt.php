<?php
/**
 * User: pculka
 * Date: 27.4.2014
 * Time: 19:14
 */
if (file_exists("srt2vtt.conf.php"))
    require_once("srt2vtt.conf.php");

try {
    // access the get, check for valid filename
    $fn = filter_input(INPUT_GET, "i", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'%^[^"<>|:*?/]+\.srt$%m') ));
    if ($fn === false) {
        throw new Exception(_("Filename invalid"));
    }

    if (file_exists($fn)) {
        // read the file
        $file = fopen($fn, 'r');

    } else {
        throw new Exception(_("File not found"));
    }

} catch (Exception $e) {
    var_dump( $e->getMessage() );

} finally {
    // append information if configured



}
