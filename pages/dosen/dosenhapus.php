<?php 
    $get_id = mysqli_query($conn, "SELECT id FROM dosen WHERE SUBSTRING(id,1,5)='DOSEN'") or die (mysqli_error($conn));
    $trim_id = mysqli_query($conn, "SELECT SUBSTRING(id,-4,4) as hasil FROM dosen WHERE SUBSTRING(id,1,5)='DOSEN' ORDER BY hasil DESC LIMIT 1") or die (mysqli_error($conn));
    $hit    = mysqli_num_rows($get_id);
    if ($hit == 0){
        $id_k   = "DOSEN0001";
    } else if ($hit > 0){
        $row    = mysqli_fetch_array($trim_id);
        $kode   = $row['hasil']+1;
        $id_k   = "DOSEN".str_pad($kode,4,"0",STR_PAD_LEFT); 
    }    
?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="card-title"><i class="mdi mdi-account menu-icon"></i> Dosen</h4>
                    <?php 

                      if (isset($_POST['submit'])) {
                        $id   = $_POST['id'];
                        $nama = $_POST['nama'];

                        $insert = mysqli_query($conn, "INSERT INTO dosen SET
                                id    = '$id',
                                nama  = '$nama'") or die (mysqli_error($conn));

                        if ($insert) {
                          echo '<div class="mt-3 mb-3 badge-success p-2 text-center rounded-1">Data berhasil tersimpan</div>';
                          echo "<meta http-equiv='refresh' content='2;
                          url=?page=dosen'>";
                        }
                      }
                    
                    ?>
                    <form class="forms-sample" action="?page=dosentambah" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="kodedosen">Kode Dosen</label>
                        <input type="text" class="form-control" placeholder="Kode Dosen" name="id" required value="<?= $id_k ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="namadosen">Nama Dosen</label>
                        <input type="text" class="form-control" placeholder="Nama Dosen" name="nama" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary me-2" value="simpan">
                      <a href="?page=dosen" class="btn btn-light">Kembali</a>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>