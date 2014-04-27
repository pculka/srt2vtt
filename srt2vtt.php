<?php
/**
 * User: pculka
 * Date: 27.4.2014
 * Time: 19:14
 */

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

}

?>
