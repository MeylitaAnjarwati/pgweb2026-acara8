<?php

// Konfigurasi MySQL pada Laragon
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

// Memeriksa koneksi database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengambil seluruh data dari tabel penduduk
$sql = "SELECT * FROM penduduk";
$result = $conn->query($sql);


// Menambahkan tautan menuju formulir input
echo "<a href='input/index.html'>Input</a><br><br>";

// Memeriksa hasil query
if ($result && $result->num_rows > 0) {

    // Membuat tabel HTML
    echo "<table border='1px' cellpadding='8'>";

    // Membuat judul kolom tabel
    echo "<tr>
            <th>Kecamatan</th>
            <th>Longitude</th>
            <th>Latitude</th>
            <th>Luas</th>
            <th>Jumlah Penduduk</th>
          </tr>";

    // Menampilkan data setiap baris
    while ($row = $result->fetch_assoc()) {

        echo "<tr>";

        echo "<td>" .
             htmlspecialchars($row["kecamatan"]) .
             "</td>";

        echo "<td>" .
             $row["longitude"] .
             "</td>";

        echo "<td>" .
             $row["latitude"] .
             "</td>";

        echo "<td>" .
             $row["luas"] .
             "</td>";

        echo "<td align='right'>" .
             $row["jumlah_penduduk"] .
             "</td>";

        echo "</tr>";
    }

    // Menutup tabel HTML
    echo "</table>";

} else {

    // Menampilkan pesan jika data kosong
    echo "0 results";
}

// Menutup koneksi database
$conn->close();

?>