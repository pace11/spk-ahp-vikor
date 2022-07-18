<?php 
    $get_id = mysqli_query($conn, "SELECT id FROM alternatif WHERE SUBSTRING(id,1,10)='ALTERNATIF'") or die (mysqli_error($conn));
    $trim_id = mysqli_query($conn, "SELECT SUBSTRING(id,-2,2) as hasil FROM alternatif WHERE SUBSTRING(id,1,10)='ALTERNATIF' ORDER BY hasil DESC LIMIT 1") or die (mysqli_error($conn));
    $hit    = mysqli_num_rows($get_id);
    if ($hit == 0){
        $id_k   = "ALTERNATIF01";
    } else if ($hit > 0){
        $row    = mysqli_fetch_array($trim_id);
        $kode   = $row['hasil']+1;
        $id_k   = "ALTERNATIF".str_pad($kode,2,"0",STR_PAD_LEFT); 
    }    
?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="card-title"><i class="mdi mdi-account menu-icon"></i> Tambah Data Alternatif</h4>
                    <?php 

                      if (isset($_POST['submit'])) {
                        $id     = $_POST['id'];
                        $nama   = $_POST['nama_alternatif'];

                        $insert = mysqli_query($conn, "INSERT INTO alternatif SET
                                id  = '$id',
                                nama_alternatif = '$nama'") or die (mysqli_error($conn));

                        if ($insert) {
                          echo '<div class="mt-3 mb-3 badge-success p-2 text-center rounded-1">Data berhasil tersimpan</div>';
                          echo "<meta http-equiv='refresh' content='1;
                          url=?page=alternatif'>";
                        }
                      }
                    
                    ?>
                    <form class="forms-sample" action="?page=alternatiftambah" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="kodedosen">ID Alternatif</label>
                        <input type="text" class="form-control" placeholder="ID Kriteria" name="id" required value="<?= $id_k ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="namadosen">Nama Kriteria</label>
                        <input type="text" class="form-control" placeholder="Nama Alternatif" name="nama_alternatif" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary me-2" value="simpan">
                      <a href="?page=alternatif" class="btn btn-light">Kembali</a>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>