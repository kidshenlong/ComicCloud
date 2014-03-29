<?php

/**
 *
 * @Class logger
 *
 * @Purpose: Logs text to a file
 *
 * @Author: Michael Patterson-Muir (Adapted from Kevin Waterson's 'logger' class)
 *
 * @example usage
 * $log = new logger('/log/file.txt', __FILE__, __LINE__);
 * $log->write('An error has occured');
 *
 */
class logger
{
    /*** Declare instance ***/
    public $location;


    public function __construct($loc)
    {
        $this->location = $loc;
    }

    public function write($message, $file=null, $line=null)
    {
        $message = "[".date("H:i:s")."]".' - '.$message;
        $message .= is_null($file) ? '' : " in $file";
        $message .= is_null($line) ? '' : " on line $line";
        $message .= "\n";
        if(file_exists($this->location)){
            return file_put_contents( $this->location, $message, FILE_APPEND );
        }else{
            return file_put_contents( $this->location, $message);
        }
    }



} /*** end of log class ***/

?>