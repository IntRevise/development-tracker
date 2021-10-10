<?php
if ($_SERVER['HTTP_HOST'] == "axtonprice.cf") {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'global';
    $DATABASE_PASS = 'global';
    $DATABASE_NAME = 'int_revise';
}
elseif ($_SERVER['HTTP_HOST'] == "localhost") {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'global';
    $DATABASE_PASS = 'global';
    $DATABASE_NAME = 'int_revise';
}
elseif ($_SERVER['HTTP_HOST'] == "intrevise.surge-networks.co.uk") {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'surgenet_intrevise';
    $DATABASE_PASS = 'Z7r@0vv4';
    $DATABASE_NAME = 'surgenet_intrevise';
} elseif ($_SERVER['HTTP_HOST'] == "intrevise.axtonprice.com") {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'surgenet_axtonintrevise';
    $DATABASE_PASS = '1xfB&17h';
    $DATABASE_NAME = 'axton_intrevise';
}
?>