<?php
/**
 *  Simple html input & output page, no templating, javascript or CSS included
 *  
 *  @author Derek Boerger
 *  @since September 2018
 *  
 *  @todo use a template, use javascript/jquery to handle, make it pretty, send it to a handler rather than back to itself
 * 
 */
include_once("concordance_test.php");

$input_sentence = (isset($_POST['input_sentence']) && strlen($_POST['input_sentence']) > 0) ?  $_POST['input_sentence'] : NULL;

echo "<form method='post'>\n".
    "<textarea cols='100' rows='10' name='input_sentence'>$input_sentence</textarea>\n".
    "<br />\n".
    "<input type='submit' value='Analyze'>\n".
    "<input type='reset'>\n".
    "</form>\n";


if (!is_null($input_sentence))
{
    $concordance = new concordance($input_sentence);
    
    echo $concordance->output;
}
    