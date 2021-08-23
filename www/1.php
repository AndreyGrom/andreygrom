<?php
$url = "ljdslfsjdf_af";


function CheckAlias($URL) {
    $pattern_1 = "/^[a-z0-9_-]+$/i";
    if(preg_match($pattern_1, $URL)){
        return true;
    } else{
        return false;
    }
}

if (CheckAlias($url)) {
    echo "Ссылка настоящая";
} else {
    echo "Совсем не ссылка";
}
?>