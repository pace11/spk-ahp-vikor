<?php
  phpinfo();
  $q = mysqli_query($conn, "SELECT id FROM banding_kriteria");
  $count_banding_kriteria = mysqli_num_rows($q);

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

?>

<?php if (count($result_vikor_ranking)) { ?>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="card-title"><i class="mdi mdi-star-circle menu-icon"></i> Hasil Ranking menggunakan Vikor</h4>
                    <a href="<?= url_preview_file() ?>" class="btn btn-primary" target="_blank">Cetak</a>
                    <div class="table-responsive pt-3">
                    <table class="table example-1 table-bordered">
                    <?php 
                        
                      echo "<thead>";
                      echo "<tr><th></th><th><strong>Nilai S</strong></th><th><strong>Nilai R</strong></th><th><strong>Result</strong></th><th><strong>Ranking</strong></th></tr>";
                      echo "</thead>";
                      echo "<tbody>";
                      foreach($arr_dosen as $key => $val) {
                        echo "<tr>";
                        echo "<td><strong>(".$arr_dosen[$key].") ".object_dosen()->$val."</strong></td>";
                        echo "<td class='table-info'>".$hitung_value_r[$key]."</td>";
                        echo "<td class='table-info'>".$max_value_r[$key]."</td>";
                        echo "<td class='table-info'>".$vikor_ranking[$key]."</td>";
                        echo "<td class='table-info'>".$result_vikor_ranking[$key]."</td>";
                        echo "</tr>";
                      }
                      echo "</tbody>";
            
                    ?>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>