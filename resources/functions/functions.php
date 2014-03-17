<?php
function simpleSanitise($var){
	return preg_replace('/[^-a-zA-Z0-9_ ]/', '', $var);
}

?>