<?php
$miraculous_core = '';
if(class_exists('Miraculouscore')):
   $miraculous_core = new Miraculouscore();
   $miraculous_core->miraculous_artists();
endif; 
?>   