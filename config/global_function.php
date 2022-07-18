<?php 

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

function object_kriteria() {
    include "connection.php";
    $tmp_arr = array();
    $q = mysqli_query($conn, "SELECT id, nama_kriteria FROM kriteria");
    while($data=mysqli_fetch_array($q)) {
        $tmp_arr[$data['id']] = $data['nama_kriteria'];
    };
    return (object)$tmp_arr;
}

function array_kriteria() {
    include "connection.php";
    $tmp_arr = array();
    $q = mysqli_query($conn, "SELECT id FROM kriteria");
    while($data=mysqli_fetch_array($q)) {
        $tmp_arr[] = $data['id'];
      };
    return $tmp_arr;
}

function array_kritria_twod() {
    $arr = array_kriteria();
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

function reverse_array($string) {
    $tmp = explode("-", $string);
    return $tmp[1]."-".$tmp[0];
}

function explode_array($string) {
    $tmp = explode("-", $string);
    return $tmp;
}

?>