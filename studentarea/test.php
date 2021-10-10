<?php
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_functions.php";
session_start();

file_get_contents("https://intrevise.axtonprice.com/api/v1/custom/isAccountLinkedDiscord?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&id=" . getData("accounts", "id", "username", "priroa"))
?>