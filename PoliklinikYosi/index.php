<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once("koneksi.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Poliklinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistem Informasi Poliklinik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Data Master</a>
                        <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?page=jadwal_dokter">Jadwal Dokter</a></li>
                            <?php
                            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                                ?>
                                <li><a class="dropdown-item" href="index.php?page=pasien">Pasien</a></li>
                                <li><a class="dropdown-item" href="index.php?page=dokter">Dokter</a></li>
                                <li><a class="dropdown-item" href="index.php?page=poli">Poli</a></li>
                                <li><a class="dropdown-item" href="index.php?page=obat">Obat</a></li>
                                <?php
                            } elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'pasien') {
                                ?>
                                <li><a class="dropdown-item" href="index.php?page=daftar_pasien">Daftar Pasien</a></li>
                                <li><a class="dropdown-item" href="index.php?page=daftar_poli">Daftar Poli</a></li>
                                <?php
                            } elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'dokter') {
                                ?>
                                <li><a class="dropdown-item" href="index.php?page=jadwal_periksa">Jadwal Periksa</a></li>
                                <li><a class="dropdown-item" href="index.php?page=periksa">Periksa</a></li>
                                <li><a class="dropdown-item" href="index.php?page=detail_periksa">Detail Periksa</a></li>
                                <li><a class="dropdown-item" href="index.php?page=riwayat_pasien">Riwayat Pasien</a></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <?php
                    if (isset($_SESSION['username'])) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout (<?php echo $_SESSION['username'] ?>)</a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=login"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=register"><i class="fas fa-user-plus"></i> Register</a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <main role="main" class="container">
        <?php
        if (isset($_GET['page'])) {
            $allowedPagesAdmin = array('pasien', 'dokter', 'poli', 'obat', 'jadwal_dokter');
            $allowedPagesPasien = array('daftar_pasien', 'daftar_poli', 'jadwal_dokter');
            $allowedPagesDokter = array('jadwal_periksa', 'periksa', 'detail_periksa', 'riwayat_pasien', 'jadwal_dokter');

            if (isset($_SESSION['role'])) {
                $currentPage = $_GET['page'];

                switch ($_SESSION['role']) {
                    case 'admin':
                        if (in_array($currentPage, $allowedPagesAdmin)) {
                            include($currentPage . ".php");
                        } else {
                            echo "Access Denied!";
                        }
                        break;
                    case 'pasien':
                        if (in_array($currentPage, $allowedPagesPasien)) {
                            include($currentPage . ".php");
                        } else {
                            echo "Access Denied!";
                        }
                        break;
                    case 'dokter':
                        if (in_array($currentPage, $allowedPagesDokter)) {
                            include($currentPage . ".php");
                        } else {
                            echo "Access Denied!";
                        }
                        break;
                    default:
                        echo "Invalid Role!";
                }
            } else {
                $currentPage = isset($_GET['page']) ? $_GET['page'] : '';

                if ($currentPage == 'login' || $currentPage == 'register' || $currentPage == 'jadwal_dokter') {
                    include($currentPage . ".php");
                } else {
                    echo "Please log in to access the system.";
                }
            }
        } else {
            echo "<div class='welcome-message'><h2>Selamat Datang di Sistem Informasi Poliklinik";

            if (isset($_SESSION['username'])) {
                echo ", " . $_SESSION['username'] . "</h2><hr>";
            } else {
                echo "</h2><hr></div><div class='login-message'>Silakan Login untuk menggunakan sistem. Jika belum memiliki akun silakan Register terlebih dahulu.</div>";
            }
        }
        ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/9ee92bcd9e.js" crossorigin="anonymous"></script>
</body>
</html>
