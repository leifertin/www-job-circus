<?php
function generateRandomString($length) {
    $characters = '2346789ACDEFGHJKLMNPQRSTVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
echo generateRandomString(14);
?>