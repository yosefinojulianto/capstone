<?php
include 'koneksi.php';
?>

<div class="container">
    <div class="header">
        <h1>Data Dokter dan Jadwal Dokter</h1>
    </div>
    <!-- Table Dokter -->
    <div class="row">
        <div class="col-md-12 table-container">
            <h2>Data Dokter</h2>
            <table class="custom-table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Dokter</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Nomor Handphone</th>
                        <th scope="col">Nama Poli</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($mysqli, "SELECT dokter.*, poli.nama_poli 
                        FROM dokter 
                        LEFT JOIN poli ON (dokter.id_poli = poli.id) 
                        ORDER BY dokter.id");

                    if (!$result) {
                        die("Error: " . mysqli_error($mysqli));
                    }

                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $data['nama'] . "</td>";
                            echo "<td>" . $data['alamat'] . "</td>";
                            echo "<td>" . $data['no_hp'] . "</td>";
                            echo "<td>" . $data['nama_poli'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No rows returned.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Table Jadwal Periksa -->
    <div class="row">
        <div class="col-md-12 table-container">
            <h2>Jadwal Periksa</h2>
            <table class="custom-table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Dokter</th>
                        <th scope="col">Hari</th>
                        <th scope="col">Jam Mulai</th>
                        <th scope="col">Jam Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = mysqli_query($mysqli, "SELECT dp.*, p.nama as 'nama_dokter' FROM jadwal_periksa dp LEFT JOIN dokter p ON (dp.id_dokter=p.id) ORDER BY dp.hari ASC, dp.jam_mulai ASC");

                    if (!$result) {
                        die("Error: " . mysqli_error($mysqli));
                    }

                    if (mysqli_num_rows($result) > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $data['nama_dokter'] . "</td>";
                            echo "<td>" . $data['hari'] . "</td>";
                            echo "<td>" . $data['jam_mulai'] . "</td>";
                            echo "<td>" . $data['jam_selesai'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No rows returned.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
