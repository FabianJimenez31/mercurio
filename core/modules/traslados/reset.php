<?php

global $user_array;
global $current_traslado;
global $application_config;

if(permitido($user_array['person_id'],$_GET['mod'])){
session_start();
unset($_SESSION['traslado']);
unset($current_traslado);
session_write_close ();

header('Location: ?mod=traslados&proc=generate_main');


}
