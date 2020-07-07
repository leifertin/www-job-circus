<?php
include("/home/liketheviking9/incld_php/redirectFunction.php");
include("/home/liketheviking9/incld_php/loginsql.php");
include("/home/liketheviking9/incld_php/cookie_chk.php");
setcookie('sID', null, -1, '/');
redirect(("index.php"),false);
?>