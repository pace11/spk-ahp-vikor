<?php 
    $g = mysqli_query($conn, "SELECT * FROM kriteria WHERE id='$_GET[id]'");
    $data = mysqli_fetch_array($g);
?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="card-title"><i class="mdi mdi-account menu-icon"></i> Ubah Data Kriteria</h4>
                    <?php 

                      if (isset($_POST['submit'])) {
                        $id     = $_POST['id'];
                        $nama   = $_POST['nama_kriteria'];
                        $bobot  = $_POST['bobot'];

                        $insert = mysqli_query($conn, "UPDATE kriteria SET
                                nama_kriteria = '$nama',
                                bobot = '$bobot'
                                WHERE id  = '$id'") or die (mysqli_error($conn));

                        if ($insert) {
                          echo '<div class="mt-3 mb-3 badge-success p-2 text-center rounded-1">Data berhasil tersimpan</div>';
                          echo "<meta http-equiv='refresh' content='1;
                          url=?page=kriteria'>";
                        }
                      }
                    
                    ?>
                    <form class="forms-sample" action="?page=kriteriaedit&id=<?= $_GET['id'] ?>" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="kodedosen">ID Kriteria</label>
                        <input type="text" class="form-control" placeholder="ID Kriteria" name="id" required value="<?= $data['id'] ?>" readonly>
                      </div>
                      <div class="form-group">
                        <label for="namadosen">Nama Kriteria</label>
                        <input type="text" class="form-control" placeholder="Nama Kriteria" name="nama_kriteria" value="<?= $data['nama_kriteria'] ?>" required>
                      </div>
                      <div class="form-group">
                        <label for="namadosen">Bobot</label>
                        <input type="text" class="form-control" placeholder="Bobot" name="bobot" value="<?= $data['bobot'] ?>" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary me-2" value="simpan">
                      <a href="?page=kriteria" class="btn btn-light">Kembali</a>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>