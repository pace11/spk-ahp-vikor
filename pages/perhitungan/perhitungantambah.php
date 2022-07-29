<?php 

  $tmp_arr_kriteria = array();
  $tmp_arr = array();
  $arr_kriteria = array_kriteria("kriteria");
  $arr_dosen = array_alternatif();
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
                        $delete3 = mysqli_query($conn, "DELETE FROM hasil_ranking");

                        if ($delete && $delete2 && $delete3) {
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

                            $arr_kriteria = array_kriteria("kriteria");
                            $arr_dosen = array_alternatif();
                            $arr_k_two_d = array_kriteria_twod($arr_kriteria);
                            $arr_k_two_d_unik = array_kriteria_banding_unik($arr_k_two_d);
                            $arr_k_satu = array_kriteria_satu($arr_kriteria, $arr_k_two_d_unik);
                            $arr_k_dua = array_kriteria_dua($arr_k_satu);

                            $hit_vektor = hitung_vektor($arr_k_dua);
                            $hit_bobot = hitung_bobot($hit_vektor, count($arr_kriteria));

                            $arr_k_satu_sum = $arr_k_satu[count($arr_k_satu) - 1];
                            $eigen_val = eigen_value($arr_k_satu_sum, $hit_bobot);

                            $ci = round(($eigen_val[count($eigen_val)-1]-$hit_vektor[count($hit_vektor)-1])/($hit_vektor[count($hit_vektor)-1]-$hit_bobot[count($hit_bobot)-1]), 2);
                            $ri = object_ri()[count($arr_kriteria)];
                            $cr = round($ci/$ri, 2);

                            // // dosen kriteria
                            $arr_kriteria_dosen = array_kriteria_twod($arr_dosen);
                            $arr_k_two_dosen_unik = array_kriteria_banding_unik($arr_kriteria_dosen);
                            $query = mysqli_query($conn, "SELECT * FROM banding_dosen");
                            $isi = mysqli_fetch_array($query);

                            $obj = json_decode($isi['data']);
                            $arr_k_dosen_satu = array();
                            $arr_k_dosen_dua = array();
                            $hit_vektor_dosen = array();
                            $hit_bobot_dosen = array();
                            $hit_final_dosen = array();
                            $hit_bobot_kriteria = array_slice($hit_bobot, 0, count($hit_bobot)-1);

                            $w = array();
                            foreach ($hit_bobot_kriteria as $key => $val) {
                              $w[] = $val/hitung_kriteria_column($hit_bobot_kriteria);
                            }
                            $result_w = hitung_kriteria_column($w);

                            foreach($arr_kriteria as $key => $val) {
                              $arr_k_dosen_satu[$val] = array_kriteria_dosen_satu($arr_dosen, $arr_k_two_dosen_unik, $val);
                            }

                            foreach($arr_kriteria as $key => $val) {
                              $arr_k_dosen_dua[$val] = array_kriteria_dua($arr_k_dosen_satu[$val]);
                              $hit_vektor_dosen[] = hitung_vektor(array_kriteria_dua($arr_k_dosen_satu[$val]));
                              $arr = hitung_bobot($hit_vektor_dosen[$key], count($arr_dosen));
                              $hit_bobot_dosen[] = array_slice($arr, 0, count($arr)-1);
                            }

                            $hit_bobot_dosen_fin = array();
                            foreach($hit_bobot_dosen as $key => $val) {
                              foreach($val as $key_c => $val_c) {
                                $hit_bobot_dosen_fin[$key_c][$key] = $val_c;
                              }
                            }

                            foreach($hit_bobot_dosen_fin as $key => $val) {
                              foreach($val as $key_c => $val_c) {
                                $a = $val_c*$hit_bobot_kriteria[$key_c];
                                $hit_final_dosen[$key][$key_c] = $a;
                                $tmp_val = ((max($hit_bobot_dosen[$key_c]) - $val_c) / (max($hit_bobot_dosen[$key_c]) - min($hit_bobot_dosen[$key_c])));
                                $value_s[$key][$key_c] = $tmp_val;
                                $value_r[$key][$key_c] = $tmp_val*$w[$key_c];
                              }
                            }

                            $ranking = array();
                            foreach ($hit_final_dosen as $k => $subArray) {
                              foreach ($subArray as $id => $value) {
                                $ranking[$k] += $value;
                              }
                            }
                            $result_ranking = ranking_dosen($ranking);
                            $hitung_value_r = hitung_array_kriteria_column_unmerged($value_r);
                            $max_value_r = hitung_array_max($value_r);

                            foreach($arr_dosen as $key => $val) {
                              $vikor_ranking[] = ((($hitung_value_r[$key]-min($hitung_value_r)) / (max($hitung_value_r)-min($hitung_value_r)) * 0.5) + (($max_value_r[$key]-min($max_value_r)) / (max($max_value_r)-min($max_value_r)) * 0.5));
                            }
                            $result_vikor_ranking = ranking_vikor($vikor_ranking);

                            foreach($arr_dosen as $key => $val) {
                              mysqli_query($conn, "INSERT INTO hasil_ranking SET
                                dosen_id  = '$val',
                                nilai_s  = '$max_value_r[$key]',
                                nilai_r  = '$hitung_value_r[$key]',
                                result = '$vikor_ranking[$key]',
                                ranking = '$result_vikor_ranking[$key]'") or die (mysqli_error($conn));
                            }

                            $html = file_get_contents(url_file()."/cetak.php");
                            $dompdf->loadHtml($html);
                            $dompdf->setPaper('A4', 'portrait');
                            $dompdf->render();
                            $output = $dompdf->output();
                            file_put_contents('file/cetak.pdf', $output);

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