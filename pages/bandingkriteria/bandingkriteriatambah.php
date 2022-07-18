<?php 

  $arr1 = array();
  $arr2 = array();
  $tmp2 = array();
  $tmp3 = array();
  $q = mysqli_query($conn, "SELECT id FROM kriteria");
  while($data=mysqli_fetch_array($q)) {
    $arr1[] = $data['id'];
    $arr2[] = $data['id'];
  };
  
  for ($a=0; $a<count($arr1); $a++) {
    for ($b=0; $b<count($arr2); $b++) {
      if ($arr1[$a] != $arr2[$b]) {
        $tmp2[] = $arr1[$a]."-".$arr2[$b];
      }
    }
  }

  for ($a=0; $a<count($tmp2); $a++) {
    if (empty($tmp3)) {
      $tmp3[] = $tmp2[$a];
    } else {
      if (!in_array(reverse_array($tmp2[$a]), $tmp3)) {
        $tmp3[] = $tmp2[$a];
      }
    }
  }

?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="card-title"><i class="mdi mdi-account menu-icon"></i> Tambah Data Perbandingan Kriteria</h4>
                    <?php 

                      if (isset($_POST['submit'])) {

                        $delete = mysqli_query($conn, "DELETE FROM banding_kriteria");

                        if ($delete) {
                          $total = count($tmp3);
                          $count = 0;

                          for($a=0; $a<count($tmp3); $a++) {
                            $id = (string) $_POST['text-'.$a];
                            $k1 = (string) explode_array($_POST['text-'.$a])[0];
                            $k2 = (string) explode_array($_POST['text-'.$a])[1];
                            $ku = (string) $_POST['radio-'.$a];
                            $np = $_POST['nilai-'.$a];

                            $insert = mysqli_query($conn, "INSERT INTO banding_kriteria SET
                              id  = '$id',
                              kriteria_1  = '$k1',
                              kriteria_2  = '$k2',
                              kriteria_utama = '$ku',
                              nilai_perbandingan = $np") or die (mysqli_error($conn));
                            
                            if ($insert) {
                              $count += 1;
                            }
                          }

                          if ($count == $total) {
                            echo '<div class="mt-3 mb-3 badge-success p-2 text-center rounded-1">Data berhasil tersimpan</div>';
                            echo "<meta http-equiv='refresh' content='1;
                            url=?page=bandingkriteria'>";
                          }
                        }

                      }
                    
                    ?>
                    <form class="forms-sample" action="?page=bandingkriteriatambah" method="post" enctype="multipart/form-data">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th colspan="2">
                              <h4><strong>Pilih yang lebih penting</strong></h4>
                            </th>
                            <th>
                              <h4><strong>Nilai perbandingan</strong></h4>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php for ($a=0; $a<count($tmp3); $a++) { ?>
                          <tr>
                              <td>
                                <div class="form-group">
                                  <label class="form-check-label" style="display:flex;">
                                    <input type="radio" class="form-check-input" id="optionsRadios1" name="<?= "radio-".$a ?>" value="<?= explode_array($tmp3[$a])[0] ?>" required>
                                    <p style="margin-left: 5px;">
                                      <?php
                                        $val = explode_array($tmp3[$a])[0];
                                        echo object_kriteria()->$val;
                                      ?>
                                    </p>
                                  </label>
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <label class="form-check-label" style="display:flex;">
                                    <input type="radio" class="form-check-input" id="optionsRadios1" name="<?= "radio-".$a ?>" value="<?= explode_array($tmp3[$a])[1] ?>" required>
                                    <p style="margin-left: 5px;">
                                      <?php
                                        $val = explode_array($tmp3[$a])[1];
                                        echo object_kriteria()->$val;
                                      ?>
                                    </p>
                                  </label>
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="form-control" placeholder="Nilai perbandingan" name="<?= "nilai-".$a ?>" required>
                                  <input type="text" class="form-control" value="<?= $tmp3[$a] ?>" name="<?= "text-".$a ?>" hidden>
                                </div>
                              </td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                      <br />
                      <input type="submit" name="submit" class="btn btn-primary me-2" value="simpan">
                      <a href="?page=bandingkriteria" class="btn btn-light">Kembali</a>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>