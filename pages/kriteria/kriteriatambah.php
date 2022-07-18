<?php 
    $get_id = mysqli_query($conn, "SELECT id FROM kriteria WHERE SUBSTRING(id,1,1)='C'") or die (mysqli_error($conn));
    $trim_id = mysqli_query($conn, "SELECT SUBSTRING(id,-2,2) as hasil FROM kriteria WHERE SUBSTRING(id,1,1)='C' ORDER BY hasil DESC LIMIT 1") or die (mysqli_error($conn));
    $hit    = mysqli_num_rows($get_id);
    if ($hit == 0){
        $id_k   = "C01";
    } else if ($hit > 0){
        $row    = mysqli_fetch_array($trim_id);
        $kode   = $row['hasil']+1;
        $id_k   = "C".str_pad($kode,2,"0",STR_PAD_LEFT); 
    }    
?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="card-title"><i class="mdi mdi-account menu-icon"></i> Tambah Data Kriteria</h4>
                    <?php 

                      if (isset($_POST['submit'])) {
                        $id     = $_POST['id'];
                        $nama   = $_POST['nama_kriteria'];
                        $bobot  = $_POST['bobot'];

                        $insert = mysqli_query($conn, "INSERT INTO kriteria SET
                                id  = '$id',
                                nama_kriteria = '$nama',
                                bobot = $bobot") or die (mysqli_error($conn));

                        if ($insert) {
                          echo '<div class="mt-3 mb-3 badge-success p-2 text-center rounded-1">Data berhasil tersimpan</div>';
                          echo "<meta http-equiv='refresh' content='1;
                          url=?page=kriteria'>";
                        }
                      }
                    
                    ?>
                    <form class="forms-sample" action="?page=kriteriatambah" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="kodedosen">ID Kriteria</label>
                        <input type="text" class="form-control" placeholder="ID Kriteria" name="id" required value="<?= $id_k ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="namadosen">Nama Kriteria</label>
                        <input type="text" class="form-control" placeholder="Nama Kriteria" name="nama_kriteria" required>
                      </div>
                      <div class="form-group">
                        <label for="namadosen">Bobot</label>
                        <input type="text" class="form-control" placeholder="Bobot" name="bobot" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary me-2" value="simpan">
                      <a href="?page=kriteria" class="btn btn-light">Kembali</a>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>