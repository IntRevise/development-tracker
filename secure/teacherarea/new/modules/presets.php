<?php
if ($_SERVER['HTTP_HOST'] == "axtonprice.cf") {
    $domain = "http://axtonprice.cf/lab/int-revise";
} elseif ($_SERVER['HTTP_HOST'] == "localhost") {
    $domain = "http://localhost/lab/int-revise";
} elseif ($_SERVER['HTTP_HOST'] == "intrevise.surge-networks.co.uk") {
    $domain = "https://intrevise.surge-networks.co.uk";
} elseif ($_SERVER['HTTP_HOST'] == "intrevise.axtonprice.com") {
    $domain = "https://intrevise.axtonprice.com";
}