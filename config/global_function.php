<?php 

use Dompdf\Dompdf;
require 'vendor/autoload.php';
$dompdf = new Dompdf();

function get_env() {
  return "dev"; // [production, dev]
}

function get_url() {
  $env = get_env(); // [production, dev]
  $protocol = $env === 'production' ? 'https://' : 'http://';
  $server_name = $_SERVER['HTTP_HOST']; 
  $app = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  return $protocol.$server_name.$app;
}

function url_file() {
  $env = get_env(); // [production, dev]
  $path_dev = 'http://localhost/spk-ahp-vikor/pages/perhitungan';
  $path_prod = get_url().'/pages/perhitungan';
  $final_path = $env === 'dev' ? $path_dev : $path_prod;
  return $final_path;
}

function url_preview_file() {
  $env = get_env(); // [production, dev]
  $path_dev = 'http://localhost/spk-ahp-vikor/file/cetak.pdf';
  $path_prod = 'https://spk.janjiku.id/file/cetak.pdf';
  $final_path = $env === 'dev' ? $path_dev : $path_prod;
  return $final_path;
}

function encrypt_decrypt($action, $string) {
  $output = false;
  $encrypt_method = "AES-256-CBC";
  $secret_key = 'xxxxxxxxxxxxxxxxxxxxxxxx';
  $secret_iv = 'xxxxxxxxxxxxxxxxxxxxxxxxx';
  $key = hash('sha256', $secret_key);    
  $iv = substr(hash('sha256', $secret_iv), 0, 16);
  if ($action == 'encrypt') {
      $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
      $output = base64_encode($output);
  } else if($action == 'decrypt') {
      $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
  }
  return $output;
}

function get_user_login($token) {
  include "connection.php";
  $id = encrypt_decrypt("decrypt", $token);
  $data = mysqli_query($conn, "SELECT * FROM login WHERE id='$id'");
  return mysqli_fetch_array($data);
}

function get_banding_kriteria($string) {
  include "connection.php";
  $data = mysqli_query($conn, "SELECT * FROM banding_kriteria WHERE id='$string'");
  return mysqli_fetch_array($data);
}

function get_banding_alternatif($key, $string) {
  include "connection.php";
  $tmp = array();
  $query = mysqli_query($conn, "SELECT * FROM banding_dosen");
  $isi = mysqli_fetch_array($query);
  $obj = json_decode($isi['data']);
  foreach($obj->$key as $key => $val) {
    if ($val->id == $string) {
      $tmp[] = $val;
    }
  }
  return $tmp[0];
}

function reverse_array($string) {
  $tmp = explode("-", $string);
  return $tmp[1]."-".$tmp[0];
}

function explode_array($string) {
  $tmp = explode("-", $string);
  return $tmp;
}

function object_ri() {
  $tmp = [
      1 => 0.00,
      2 => 0.00,
      3 => 0.58,
      4 => 0.90,
      5 => 1.12,
      6 => 1.24,
      7 => 1.32,
      8 => 1.41,
      9 => 1.45,
      10 => 1.49,
  ];
  return $tmp;
}

function object_kriteria() {
  include "connection.php";
  $tmp_arr = array();
  $q = mysqli_query($conn, "SELECT id, nama_kriteria FROM kriteria");
  while($data=mysqli_fetch_array($q)) {
      $tmp_arr[$data['id']] = $data['nama_kriteria'];
  };
  return (object)$tmp_arr;
}

function object_dosen() {
  include "connection.php";
  $tmp_arr = array();
  $q = mysqli_query($conn, "SELECT id, nama FROM dosen");
  while($data=mysqli_fetch_array($q)) {
      $tmp_arr[$data['id']] = $data['nama'];
  };
  return (object)$tmp_arr;
}

function array_kriteria($table_name) {
  include "connection.php";
  $tmp_arr = array();
  $q = mysqli_query($conn, "SELECT id FROM $table_name");
  while($data=mysqli_fetch_array($q)) {
      $tmp_arr[] = $data['id'];
    };
  return $tmp_arr;
}

function array_alternatif() {
  include "connection.php";
  $tmp_arr = array();
  $q = mysqli_query($conn, "SELECT dosen_id FROM alternatif");
  while($data=mysqli_fetch_array($q)) {
      $tmp_arr[] = $data['dosen_id'];
    };
  return $tmp_arr;
}

function array_kriteria_twod($arr) {
  $tmp = array();
  foreach ($arr as $key_p => $val_p) {
      foreach ($arr as $key_c => $val_c) {
        if ($arr[$key_p] != $arr[$key_c]) {
          $tmp[] = $arr[$key_p]."-".$arr[$key_c];
        }
      }
  }
  return $tmp;
}

function array_kriteria_banding_unik($arr) {
  $tmp = array();
  foreach ($arr as $key => $val) {
      if (empty($tmp)) {
        $tmp[] = $arr[$key];
      } else {
        if (!in_array(reverse_array($arr[$key]), $tmp)) {
          $tmp[] = $arr[$key];
        }
      }
  }
  return $tmp;
}

function hitung_kriteria_column($arr) {
  $tmp = 0;
  foreach ($arr as $key => $val) {
    $tmp += $val;
  }
  return $tmp;
}

function hitung_array_kriteria_column_unmerged($arr) {
  $tmp = array();
  foreach ($arr as $key => $val) {
    $tmp[] = array_sum($val);
  }
  return $tmp;
}

function hitung_array_max($arr) {
  $tmp = array();
  foreach ($arr as $key => $val) {
    $tmp[] = max($val);
  }
  return $tmp;
}

function hitung_array_kriteria_column($arr) {
  $tmp = array();
  foreach ($arr as $k => $subArray) {
    foreach ($subArray as $id => $value) {
      $tmp[$id] += $value;
    }
  }
  array_push($arr, $tmp);
  return $arr;
}

function array_kriteria_satu($arr, $arr2) {
  $tmp = array();
  $sum_arr = array();
  for ($a=0; $a<count($arr); $a++) {
    for ($b=0; $b<count($arr); $b++) {
      if ($arr[$a] == $arr[$b]) {
        $tmp[$a][$b] = 1;
      } else {
        if (in_array($arr[$a]."-".$arr[$b], $arr2)) {
          $isi = get_banding_kriteria($arr[$a]."-".$arr[$b]);
          if ($isi["kriteria_utama"] == $arr[$a]) {
            $tmp[$a][$b] = $isi["nilai_perbandingan"];
          } else {
            $tmp[$a][$b] = 1/$isi["nilai_perbandingan"];
          }
        }

        if (in_array(reverse_array($arr[$a]."-".$arr[$b]), $arr2)) {
          $isi = get_banding_kriteria(reverse_array($arr[$a]."-".$arr[$b]));
          if ($isi["kriteria_utama"] == $arr[$a]) {
            $tmp[$a][$b] = $isi["nilai_perbandingan"];
          } else {
            $tmp[$a][$b] = 1/$isi["nilai_perbandingan"];
          }
        }
      }
    }
  }

  // hitung total nilai tiap column
  foreach ($tmp as $k => $subArray) {
      foreach ($subArray as $id => $value) {
        $sum_arr[$id] += $value;
      }
  }

  array_push($tmp, $sum_arr);
  return $tmp;
}

function array_kriteria_dosen_satu($arr, $arr2, $key) {
  $tmp = array();
  $sum_arr = array();
  for ($a=0; $a<count($arr); $a++) {
    for ($b=0; $b<count($arr); $b++) {
      if ($arr[$a] == $arr[$b]) {
        $tmp[$a][$b] = 1;
      } else {
        if (in_array($arr[$a]."-".$arr[$b], $arr2)) {
          $isi = get_banding_alternatif($key, $arr[$a]."-".$arr[$b]);
          if ($isi->kriteria_utama == $arr[$a]) {
            $tmp[$a][$b] = $isi->nilai_perbandingan;
          } else {
            $tmp[$a][$b] = 1/$isi->nilai_perbandingan;
          }
        }

        if (in_array(reverse_array($arr[$a]."-".$arr[$b]), $arr2)) {
          $isi = get_banding_alternatif($key, reverse_array($arr[$a]."-".$arr[$b]));
          if ($isi->kriteria_utama == $arr[$a]) {
            $tmp[$a][$b] = $isi->nilai_perbandingan;
          } else {
            $tmp[$a][$b] = 1/$isi->nilai_perbandingan;
          }
        }
      }
    }
  }

  // hitung total nilai tiap column
  foreach ($tmp as $k => $subArray) {
      foreach ($subArray as $id => $value) {
        $sum_arr[$id] += $value;
      }
  }

  array_push($tmp, $sum_arr);
  return $tmp;
}

function array_kriteria_dua($arr) {
    $arr_last = $arr[(int)count($arr) - 1];
    $arr_slice = array_slice($arr, 0, (int)count($arr) - 1);
    $tmp = array();
    $sum = array();
    foreach($arr_slice as $key => $val) {
      foreach($val as $key_c => $val_c) {
        $tmp[$key][$key_c] = ($val_c/$arr_last[$key_c]);
        $sum[$key_c] += $tmp[$key][$key_c];
      }
    }
    $serial = array_map(function($v){return $v;}, $sum) ;
    array_push($tmp, $serial);
    return $tmp;
}

function hitung_vektor($arr) {
    $tmp = array();
    foreach($arr as $key_p => $val_p) {
        $hit = 0;
        foreach($val_p as $key_c => $val_c) {
            $hit += $val_c;
        }
            $tmp[] = $hit;
    }
    return $tmp;
}

function hitung_bobot($arr, $count) {
    $tmp = array();
    foreach($arr as $key => $val) {
        $tmp[] = $val/$count;
    }
    return $tmp;
}

function eigen_value($arr, $arr2) {
    $tmp = array();
    $hit = 0;
    foreach($arr as $key => $val) {
        $tmp[] = $val * $arr2[$key];
        $hit += $val * $arr2[$key];
    }
    array_push($tmp, $hit);
    return $tmp;
}

function ranking_dosen($arr) {
  $tmp = array();
  $rank = $arr;
  rsort($rank);
  foreach($arr as $sort) {
    $tmp[] =  "Ranking " . (array_search($sort, $rank) + 1);
  }
  return $tmp;
}

function ranking_vikor($arr) {
  $tmp = array();
  $rank = $arr;
  sort($rank);
  foreach($arr as $sort) {
    $tmp[] =  "Ranking " . (array_search($sort, $rank) + 1);
  }
  return $tmp;
}

?>