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

?>