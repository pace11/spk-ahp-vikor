<?php 

  $arr1 = array();
  $arr2 = array();
  $tmp = array();
  $tmp2 = array();
  $tmp3 = array();
  $sum_arr = array();
  $sum_kriteria = array();
  $sum_arr_kriteria = array();
  $aku = array();
  $q = mysqli_query($conn, "SELECT id FROM kriteria");
  $q2 = mysqli_query($conn, "SELECT id FROM banding_kriteria");
  $count_rows = mysqli_num_rows($q2);
  while($data=mysqli_fetch_array($q)) {
    $arr1[] = $data['id'];
    $arr2[] = $data['id'];
  };

  // assign first
  foreach ($arr1 as $value) {
    $sum_arr[] = 0;
    $sum_arr_kriteria[] = 0;
  }

  foreach ($arr1 as $key_p => $val_p) {
    foreach ($arr2 as $key_c => $val_c) {
      if ($arr1[$key_p] != $arr2[$key_c]) {
        $tmp2[] = $arr1[$key_p]."-".$arr2[$key_c];
      }
    }
  }

  foreach ($tmp2 as $key => $val) {
    if (empty($tmp3)) {
      $tmp3[] = $tmp2[$key];
    } else {
      if (!in_array(reverse_array($tmp2[$key]), $tmp3)) {
        $tmp3[] = $tmp2[$key];
      }
    }
  }

  for ($a=0; $a<count($arr1); $a++) {
    for ($b=0; $b<count($arr2); $b++) {
      if ($arr1[$a] == $arr2[$b]) {
        $tmp[$a][$b] = 1;
      } else {
        if (in_array($arr1[$a]."-".$arr2[$b], $tmp3)) {
          $isi = get_banding_kriteria($arr1[$a]."-".$arr2[$b]);
          if ($isi["kriteria_utama"] == $arr1[$a]) {
            $tmp[$a][$b] = $isi["nilai_perbandingan"];
          } else {
            $tmp[$a][$b] = round(1/$isi["nilai_perbandingan"], 2);
          }
        }

        if (in_array(reverse_array($arr1[$a]."-".$arr2[$b]), $tmp3)) {
          $isi = get_banding_kriteria(reverse_array($arr1[$a]."-".$arr2[$b]));
          if ($isi["kriteria_utama"] == $arr1[$a]) {
            $tmp[$a][$b] = $isi["nilai_perbandingan"];
          } else {
            $tmp[$a][$b] = round(1/$isi["nilai_perbandingan"], 2);
          }
        }
      }
    }
  }

  foreach ($tmp as $k => $subArray) {
    foreach ($subArray as $id => $value) {
      $sum_arr[$id] += $value;
    }
  }

  foreach($tmp as $key => $val) {
    foreach($val as $key_c => $val_c) {
      $sum_kriteria[$key][$key_c] = round(($val_c/$sum_arr[$key_c]), 2);
      $sum_arr_kriteria[$key_c] += $sum_kriteria[$key][$key_c];
    }
  }

  // echo "<pre>";
  // print_r($sum_arr_kriteria);
  // echo "</pre>";

?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="card-title"><i class="mdi mdi-account menu-icon"></i> List Data Perbandingan Kriteria</h4>
                    <a href="?page=bandingkriteriatambah" class="btn btn-primary"><i class="mdi mdi-plus-circle"></i> Buat Perbandingan Kriteria Baru</a>
                    <div class="table-responsive pt-3">
                    <table class="example table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            No
                          </th>
                          <th>
                            Kriteria 1
                          </th>
                          <th>
                            Kriteria 2
                          </th>
                          <th>
                            Kriteria Utama
                          </th>
                          <th>
                            Nilai Perbandingan
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $no = 1;
                          $q = mysqli_query($conn, "SELECT id, kriteria_1, kriteria_2, kriteria_utama, nilai_perbandingan FROM banding_kriteria");
                          while($data=mysqli_fetch_array($q)){ ?>
                              <tr>
                                  <td><?= $no ?></td>
                                  <td><?= !empty($data['kriteria_1']) ? $data['kriteria_1'] : '-' ?></td>
                                  <td><?= !empty($data['kriteria_2']) ? $data['kriteria_2'] : '-' ?></td>
                                  <td><?= !empty($data['kriteria_utama']) ? $data['kriteria_utama'] : '-' ?></td>
                                  <td><?= !empty($data['nilai_perbandingan']) ? $data['nilai_perbandingan'] : '-' ?></td>
                              </tr>
                        <?php $no++; } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th></th>
                          <?php for($c=0; $c<count($arr1); $c++) { ?>
                            <th><strong><?= $arr1[$c] ?></strong></th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for($a=0; $a<count($tmp); $a++) { ?>
                          <tr>
                          <td><strong><?= $arr1[$a] ?></strong></td>
                          <?php for($b=0; $b<count($tmp); $b++) { ?>
                            <td><?= $tmp[$a][$b] ?></td>
                          <?php } ?>
                          </tr>
                        <?php } ?>
                        <tr>
                          <td><strong>TOTAL</strong></td>
                          <?php for($c=0; $c<count($sum_arr); $c++) { ?>
                            <th><strong><?= $sum_arr[$c] ?></strong></th>
                          <?php } ?>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th></th>
                          <?php for($c=0; $c<count($arr1); $c++) { ?>
                            <th><strong><?= $arr1[$c] ?></strong></th>
                          <?php } ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for($a=0; $a<count($sum_kriteria); $a++) { ?>
                          <tr>
                          <td><strong><?= $arr1[$a] ?></strong></td>
                          <?php for($b=0; $b<count($sum_kriteria); $b++) { ?>
                            <td><?= $sum_kriteria[$a][$b] ?></td>
                          <?php } ?>
                          </tr>
                        <?php } ?>
                        <tr>
                          <td><strong>TOTAL</strong></td>
                          <?php for($c=0; $c<count($sum_arr_kriteria); $c++) { ?>
                            <th><strong><?= $sum_arr_kriteria[$c] ?></strong></th>
                          <?php } ?>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>