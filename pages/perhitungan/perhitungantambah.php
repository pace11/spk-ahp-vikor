<?php 

  $tmp_arr_kriteria = array();
  $tmp_arr = array();
  $arr_kriteria = array_kriteria("kriteria");
  $arr_dosen = array_kriteria("dosen");
  $arr_k_two_d = array_kriteria_twod($arr_kriteria);
  $arr_k_two_d_unik = array_kriteria_banding_unik($arr_k_two_d);

  foreach($arr_kriteria as $key => $val) {
    foreach($arr_dosen as $key_p => $val_p) {
      foreach($arr_dosen as $key_c => $val_c) {
        if ($key_p == $key_c) {
          $tmp_arr[$key_p][$key_c] = 1;
        } else {
          $tmp_arr[$key_p][$key_c] = 0;
        }
      }
    }
    $tmp_arr_kriteria[$val] = $tmp_arr;
  }

  // echo "<pre>";
  // print_r($arr_dosen);
  // echo "</pre>";

?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="card-title"><i class="mdi mdi-account menu-icon"></i> Tambah Data Perhitungan Kriteria</h4>
                    <?php 

                      if (isset($_POST['submit'])) {

                        $arr_tmp = array();
                        $arr_tmp_dosen = array();
                        $tmp = array();

                        $arr_kriteria_dosen = array_kriteria_twod($arr_dosen);
                        $arr_k_two_dosen_unik = array_kriteria_banding_unik($arr_kriteria_dosen);

                        $delete = mysqli_query($conn, "DELETE FROM banding_kriteria");
                        $delete2 = mysqli_query($conn, "DELETE FROM banding_dosen");

                        if ($delete && $delete2) {
                          $total = count($arr_k_two_d_unik);
                          $count = 0;

                          for($a=0; $a<count($arr_k_two_d_unik); $a++) {
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

                          foreach($arr_kriteria as $key => $val) {
                            foreach($arr_k_two_dosen_unik as $key_d => $val_d) {
                              $arr_tmp_dosen[$val][$key_d] = [
                                "id" => $val_d,
                                "kriteria_1" => explode_array($val_d)[0],
                                "kriteria_2" => explode_array($val_d)[1],
                                "kriteria_utama" => $_POST['alternatif-'.$val.'-'.$val_d],
                                "nilai_perbandingan" => (int) $_POST['nilai_banding-'.$val.'-'.$val_d]
                              ];
                            }
                          }

                          $isi_data = json_encode($arr_tmp_dosen);

                          mysqli_query($conn, "INSERT INTO banding_dosen SET
                            data  = '$isi_data'") or die (mysqli_error($conn));

                          if ($count == $total) {
                            echo '<div class="mt-3 mb-3 badge-success p-2 text-center rounded-1">Data berhasil tersimpan</div>';
                            echo "<meta http-equiv='refresh' content='1;
                            url=?page=perhitungan'>";
                          }
                        
                        }
                      }
                    
                    ?>
                    <form class="forms-sample" action="?page=perhitungantambah" method="post" enctype="multipart/form-data">
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
                        <?php for ($a=0; $a<count($arr_k_two_d_unik); $a++) { ?>
                          <tr>
                              <td>
                                <div class="form-group">
                                  <label class="form-check-label" style="display:flex;">
                                    <input type="radio" class="form-check-input" id="optionsRadios1" name="<?= "radio-".$a ?>" value="<?= explode_array($arr_k_two_d_unik[$a])[0] ?>">
                                    <p style="margin-left: 5px;">
                                      <?php
                                        $val = explode_array($arr_k_two_d_unik[$a])[0];
                                        echo object_kriteria()->$val;
                                      ?>
                                    </p>
                                  </label>
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <label class="form-check-label" style="display:flex;">
                                    <input type="radio" class="form-check-input" id="optionsRadios1" name="<?= "radio-".$a ?>" value="<?= explode_array($arr_k_two_d_unik[$a])[1] ?>">
                                    <p style="margin-left: 5px;">
                                      <?php
                                        $val = explode_array($arr_k_two_d_unik[$a])[1];
                                        echo object_kriteria()->$val;
                                      ?>
                                    </p>
                                  </label>
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="form-control" placeholder="Nilai perbandingan" name="<?= "nilai-".$a ?>">
                                  <input type="text" class="form-control" value="<?= $arr_k_two_d_unik[$a] ?>" name="<?= "text-".$a ?>" hidden>
                                </div>
                              </td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                      <br />
                      <?php for ($b=0; $b<count($arr_kriteria); $b++) {
                      $arr_kriteria_dosen = array_kriteria_twod($arr_dosen);
                      $arr_k_two_dosen_unik = array_kriteria_banding_unik($arr_kriteria_dosen);  
                      ?>
                      <h4 class="card-title"><?= $b+1 ?>. Perbandingan Alternatif <i class="mdi mdi-arrow-right-circle"></i> <?php $val = $arr_kriteria[$b]; echo object_kriteria()->$val;  ?></h4>
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
                        <?php for ($a=0; $a<count($arr_k_two_dosen_unik); $a++) { ?>
                          <tr>
                              <td>
                                <div class="form-group">
                                  <label class="form-check-label" style="display:flex;">
                                    <input type="radio" class="form-check-input" id="optionsRadios1" name="<?= "alternatif-".$arr_kriteria[$b]."-".$arr_k_two_dosen_unik[$a] ?>" value="<?= explode_array($arr_k_two_dosen_unik[$a])[0] ?>">
                                    <p style="margin-left: 5px;">
                                      <?php
                                        $val = explode_array($arr_k_two_dosen_unik[$a])[0];
                                        echo $val;
                                      ?>
                                    </p>
                                  </label>
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <label class="form-check-label" style="display:flex;">
                                    <input type="radio" class="form-check-input" id="optionsRadios1" name="<?= "alternatif-".$arr_kriteria[$b]."-".$arr_k_two_dosen_unik[$a] ?>" value="<?= explode_array($arr_k_two_dosen_unik[$a])[1] ?>">
                                    <p style="margin-left: 5px;">
                                      <?php
                                        $val = explode_array($arr_k_two_dosen_unik[$a])[1];
                                        echo $val;
                                      ?>
                                    </p>
                                  </label>
                                </div>
                              </td>
                              <td>
                                <div class="form-group">
                                  <input type="text" class="form-control" placeholder="Nilai perbandingan" name="<?= "nilai_banding-".$arr_kriteria[$b]."-".$arr_k_two_dosen_unik[$a] ?>">
                                </div>
                              </td>
                          </tr>
                        <?php } ?>
                        </tbody>
                      </table>
                      <br />
                      <?php } ?>
                      <input type="submit" name="submit" class="btn btn-primary me-2" value="simpan">
                      <a href="?page=perhitungan" class="btn btn-light">Kembali</a>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>