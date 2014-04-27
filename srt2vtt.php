<?php
/**
 * User: pculka
 * Date: 27.4.2014
 * Time: 19:14
 */

try {
    // access the get, check for valid filename
    $fn = filter_input(INPUT_GET, "i", FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'%^[^"<>|:*?/]+\.srt$%m') ));

    if (file_exists($fn)) {
        // read the file
        $file = fopen($fn, 'r');

    } else {
        throw new Exception("Wrong filename specified");
    }

} catch (Exception $e) {
    var_dump( $e->getMessage() );

} finally {


}

?>
