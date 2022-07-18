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

    // kriteria page
    elseif ($page == "kriteria")                include("pages/kriteria/kriteria.php");
    elseif ($page == "kriteriatambah")          include("pages/kriteria/kriteriatambah.php");
    elseif ($page == "kriteriaedit")            include("pages/kriteria/kriteriaedit.php");
    elseif ($page == "kriteriahapus")           include("pages/kriteria/kriteriahapus.php");

    // perbandingan kriteria page
    elseif ($page == "bandingkriteria")         include("pages/bandingkriteria/bandingkriteria.php");
    elseif ($page == "bandingkriteriatambah")   include("pages/bandingkriteria/bandingkriteriatambah.php");
    elseif ($page == "bandingkriteriaedit")     include("pages/bandingkriteria/bandingkriteriaedit.php");
    elseif ($page == "bandingkriteriahapus")    include("pages/bandingkriteria/bandingkriteriahapus.php");

    // alternatif page
    elseif ($page == "alternatif")              include("pages/alternatif/alternatif.php");
    elseif ($page == "alternatiftambah")        include("pages/alternatif/alternatiftambah.php");
    elseif ($page == "alternatifedit")          include("pages/alternatif/alternatifedit.php");
    elseif ($page == "alternatifhapus")         include("pages/alternatif/alternatifhapus.php");

?>