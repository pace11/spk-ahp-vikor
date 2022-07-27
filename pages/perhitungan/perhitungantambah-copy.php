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
  // print_r($tmp_arr_kriteria);
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

                          foreach($tmp_arr_kriteria as $key => $val) {
                            $tmp_isi = array();
                            foreach($arr_dosen as $key_p => $val_p) {
                              foreach($arr_dosen as $key_c => $val_c) {
                                $val = $_POST[$key.'-'.$key_p.'-'.$key_c];
                                $arr_tmp[$key_p][$key_c] = $val;
                              }
                            }
                            $sum = hitung_array_kriteria_column($arr_tmp);
                            $arr_tmp_dosen[$key] = $sum;
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
                      <br />
                      <?php 
                      
                      foreach($tmp_arr_kriteria as $key => $val) {
                        echo "<h4 class='card-title'><strong>Nilai perbandingan Dosen untuk kriteria (".$key.") ".object_kriteria()->$key."</strong></h4>";
                        echo "<table class='table table-bordered'>";
                        echo "<tbody>";
                          foreach($val as $key1 => $val1) {
                            echo "<tr>";
                              foreach($val1 as $key2 => $val2) {
                                if ($val2 == 1) {
                                  echo "<td><div class='form-group'><input type='text' class='form-control' name='$key-$key1-$key2' value='$val2' placeholder='$val2' readonly></div></td>";
                                } else {
                                  echo "<td><div class='form-group'><input type='text' class='form-control' name='$key-$key1-$key2' value='$val2' placeholder='$val2'></div></td>";
                                }
                              }
                            echo "</tr>";
                          }
                        echo "</tbody>";
                        echo "</table>";
                        echo "<br />";
                      }
                      
                      ?>
                      <br />
                      <input type="submit" name="submit" class="btn btn-primary me-2" value="simpan">
                      <a href="?page=perhitungan" class="btn btn-light">Kembali</a>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>