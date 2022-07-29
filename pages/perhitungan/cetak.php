<?php 
    include '../../config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Ticket Invoice</title>
        <style>
            body {
                font-size: 9pt;
            }
            table {
                width: 100%;
                border-spacing: 0;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
        <?php
            $get = mysqli_query($conn, "SELECT * FROM hasil_ranking 
                                        JOIN dosen ON dosen.id=hasil_ranking.dosen_id
                                        ORDER BY ranking ASC") or die (mysqli_error($conn));
            $data = mysqli_fetch_array($get);
        ?>
        <div style="width:100%;height: auto;box-sizing: border-box;">
            <div style="text-align: right;height: 100px;">
                <img src="images/logo-itpln-2.jpg" style="position: absolute;left: 10px;width: 150px;margin:-20px 0 0 0;" />
                <p style="line-height:1.6;padding:0;margin:0;font-size:27px;font-weight:bold;">Institut Teknologi PLN Jakarta</p>
                <p style="line-height:1.6;padding:0;margin:0;font-size:15px;">Sistem Penentuan Dosen Terbaik Menggunakan Metode AHP-VIKOR</p>
            </div>
        </div>
        <table>
            <tr>
                <td style="width: 5%; border:1px solid #000;padding: 5px;">
                    <p style="line-height:1.6;margin:0; padding: 0;text-align: center;">No</p>
                </td>
                <td style="width: 30%; border:1px solid #000;padding: 5px;">
                    <p style="line-height:1.6;margin:0; padding: 0;text-align: center;">Dosen</p>
                </td>
                <td style="width: 20%; border:1px solid #000;padding: 5px;">
                    <p style="line-height:1.6;margin:0; padding: 0;text-align: center;">Nilai S</p>
                </td>
                <td style="width: 15%; border:1px solid #000;padding: 5px;">
                    <p style="line-height:1.6;margin:0; padding: 0;text-align: center;">Nilai R</p>
                </td>
                <td style="width: 15%; border:1px solid #000;padding: 5px;">
                    <p style="line-height:1.6;margin:0; padding: 0;text-align: center;">Result</p>
                </td>
                <td style="width: 15%; border:1px solid #000;padding: 5px;">
                    <p style="line-height:1.6;margin:0; padding: 0;text-align: center;">Ranking</p>
                </td>
            </tr>
            <?php
            $no = 1;
            $q = mysqli_query($conn, "SELECT * FROM hasil_ranking 
                                        JOIN dosen ON dosen.id=hasil_ranking.dosen_id
                                        ORDER BY ranking ASC") or die (mysqli_error($conn));
            while($data = mysqli_fetch_array($q)) { ?>
                <tr>
                    <td style="width: 5%; border:1px solid #000;padding: 5px;">
                        <p style="line-height:1.6;margin:0; padding: 0;text-align: center;"><?= $no ?>.</p>
                    </td>
                    <td style="width: 30%; border:1px solid #000;padding: 5px;">
                        <p style="line-height:1.6;margin:0; padding: 0;text-align: center;">(<?= $data['dosen_id'] ?>) <?= $data['nama'] ?></p>
                    </td>
                    <td style="width: 20%; border:1px solid #000;padding: 5px;">
                        <p style="line-height:1.6;margin:0; padding: 0;text-align: center;"><?= $data['nilai_s'] ?></p>
                    </td>
                    <td style="width: 15%; border:1px solid #000;padding: 5px;">
                        <p style="line-height:1.6;margin:0; padding: 0;text-align: center;"><?= $data['nilai_r'] ?></p>
                    </td>
                    <td style="width: 15%; border:1px solid #000;padding: 5px;">
                        <p style="line-height:1.6;margin:0; padding: 0;text-align: center;"><?= $data['result'] ?></p>
                    </td>
                    <td style="width: 15%; border:1px solid #000;padding: 5px;">
                        <p style="line-height:1.6;margin:0; padding: 0;text-align: center;"><?= $data['ranking'] ?></p>
                    </td>
                </tr>
            <?php $no++; } ?>
        <table>
    </body>
</html>