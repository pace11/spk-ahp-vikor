<?php 

if (isset($_GET['page'])) $page=$_GET['page'];
    else $page="beranda";

    if ($page == "beranda")                     include("pages/beranda.php");
    elseif ($page == "logout")                  include("pages/logout.php");

?>