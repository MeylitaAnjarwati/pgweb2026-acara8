
<?php

// Mengambil data dari formulir
$kecamatan = trim($_POST['kecamatan'] ?? '');
$longitude = $_POST['longitude'] ?? '';
$latitude = $_POST['latitude'] ?? '';
$luas = $_POST['luas'] ?? '';
$jumlah_penduduk = $_POST['jumlah_penduduk'] ?? '';

// Memeriksa data input
if (
    $kecamatan === '' ||
    strlen($kecamatan) > 100 ||
    !is_numeric($longitude) ||
    !is_numeric($latitude) ||
    !is_numeric($luas) ||
    filter_var(
        $jumlah_penduduk,
        FILTER_VALIDATE_INT,
        ["options" => ["min_range" => 0]]
    ) === false ||
    (float)$longitude < -180 ||
    (float)$longitude > 180 ||
    (float)$latitude < -90 ||
    (float)$latitude > 90 ||
    (float)$luas < 1
) {
    die("Data input tidak valid.");
}

// Konfigurasi MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "latihan";

// Membuat koneksi database
$conn = new mysqli(
    $servername,
    $username,
    $password,
    $dbname
);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Membuat query INSERT
$sql = "INSERT INTO penduduk
        (kecamatan, longitude, latitude, luas, jumlah_penduduk)
        VALUES (?, ?, ?, ?, ?)";

// Menyiapkan perintah SQL
$stmt = $conn->prepare($sql);

// Memasukkan nilai ke query
$stmt->bind_param(
    "sdddi",
    $kecamatan,
    $longitude,
    $latitude,
    $luas,
    $jumlah_penduduk
);

// Menjalankan query
if ($stmt->execute()) {

    // Menutup koneksi
    $stmt->close();
    $conn->close();

    // Mengarahkan ke halaman utama
    header("Location: ../index.php");
    exit();

} else {

    echo "Data gagal disimpan.";

}

// Menutup koneksi
$stmt->close();
$conn->close();

?>
