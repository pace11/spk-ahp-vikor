<?php 

if (isset($_GET['page'])) $page=$_GET['page'];
    else $page="beranda";

    if ($page == "beranda")                     include("pages/beranda.php");
    elseif ($page == "logout")                  include("pages/logout.php");

    // dosen page
    elseif ($page == "dosen")                   include("pages/dosen/dosen.php");
    elseif ($page == "dosentambah")             include("pages/dosen/dosentambah.php");
    elseif ($page == "dosenedit")               include("pages/dosen/dosenedit.php");
    elseif ($page == "dosenhapus")              include("pages/dosen/dosenhapus.php");


?>