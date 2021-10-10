<?php
function latestVersion()
{
    return "1.0.0";
}

if (latestVersion() == $_GET['v']){
    echo "latest";
} else{
    echo latestVersion();
}