<?php
/**
 * User: pculka
 * Date: 27.4.2014
 * Time: 19:14
 */
$srt2vttConf = array();
if (file_exists("srt2vtt.conf.php"))
    require_once("srt2vtt.conf.php");

try {
    // access the get, check for valid filename
    $fn  = filter_input(INPUT_GET, "i", FILTER_VALIDATE_REGEXP, array( "options" => array( "regexp" => '%^[^"<>|:*?/]+\.srt$%m') ) );
    $fn = 'Game of Thrones - S04E01.CZ.srt';
    if ($fn === false) {
        throw new Exception(_("Specified input is invalid"));
    }

    if (file_exists($fn)) {
        // read the file
        $subtitleLines   = file($fn);

        if (empty($subtitleLines)) throw new Exception(_("Subtitle file empty"));
        // prepare the result

        $result = "WEBVTT\n\n\n";
        define('SRT_STATE_SUBNUMBER', 0);
        define('SRT_STATE_TIME',      1);
        define('SRT_STATE_TEXT',      2);
        define('SRT_STATE_BLANK',     3);

        $subs    = array();
        $state   = SRT_STATE_SUBNUMBER;
        $subNum  = 0;
        $subText = '';
        $subTime = '';

        foreach($subtitleLines as $line) {
            switch($state) {
                case SRT_STATE_SUBNUMBER:
                    $subNum = trim($line);
                    $state  = SRT_STATE_TIME;
                    break;

                case SRT_STATE_TIME:
                    $subTime = trim($line);
                    $state   = SRT_STATE_TEXT;
                    break;

                case SRT_STATE_TEXT:
                    if (trim($line) == '') {
                        $sub = new stdClass;
                        $sub->number = $subNum;
                        list($sub->startTime, $sub->stopTime) = explode(' --> ', $subTime);
                        $sub->text   = $subText;
                        $subText     = '';
                        $state       = SRT_STATE_SUBNUMBER;
                        $subs[]      = $sub;
                    } else {
                        $subText .= trim($line)."\n";
                    }
                    break;
            }
        }

        foreach ($subs as $sub) {
            $result .= $sub->number."\n";
            $result .= str_replace(',', '.', $sub->startTime)." --> ".str_replace(',', '.', $sub->stopTime)."\n";
            $result .= $sub->text."\n\n";
        }


        header('Content-type: text/plain; charset=utf-8');
        echo $result;

    } else {
        throw new Exception(_("File not found"));
    }

} catch (Exception $e) {
    var_dump( $e->getMessage() );
    // append the message as a subtitle lasting 5 hours (to notify the user about the error within video)
    // #todo
} finally {
    // append information if configured
    // #todo



}
