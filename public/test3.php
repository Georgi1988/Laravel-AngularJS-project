<?php

$numbers = range(0,9999);
shuffle($numbers);
foreach ($numbers as $number) {
   echo str_pad($number, 4, '0', STR_PAD_LEFT),'<br />';
}

?>