<?php
// Koneksi Database
$koneksi = mysqli_connect("localhost", "root", "", "Data_siswa");

// membuat fungsi query dalam bentuk array
function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Membuat fungsi tambah (TANPA GAMBAR)
function tambah($data)
{
    global $koneksi;

    $nis = htmlspecialchars($data['nis']);
    $nama = htmlspecialchars($data['nama']);
    $tmpt_Lahir = htmlspecialchars($data['tmpt_Lahir']);
    $tgl_Lahir = $data['tgl_Lahir'];
    $jekel = $data['jekel'];
    $jurusan = $data['jurusan'];
    $email = htmlspecialchars($data['email']);
    $alamat = htmlspecialchars($data['alamat']);

    // Tidak lagi menyertakan kolom gambar
    $sql = "INSERT INTO siswa (nis, nama, tmpt_Lahir, tgl_Lahir, jekel, jurusan, email, alamat)
            VALUES ('$nis','$nama','$tmpt_Lahir','$tgl_Lahir','$jekel','$jurusan','$email','$alamat')";

    mysqli_query($koneksi, $sql);

    return mysqli_affected_rows($koneksi);
}

// Membuat fungsi hapus
function hapus($nis)
{
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM siswa WHERE nis = $nis");
    return mysqli_affected_rows($koneksi);
}

// Membuat fungsi ubah (TANPA GAMBAR)
function ubah($data)
{
    global $koneksi;

    $nis = $data['nis'];
    $nama = htmlspecialchars($data['nama']);
    $tmpt_Lahir = htmlspecialchars($data['tmpt_Lahir']);
    $tgl_Lahir = $data['tgl_Lahir'];
    $jekel = $data['jekel'];
    $jurusan = $data['jurusan'];
    $email = htmlspecialchars($data['email']);
    $alamat = htmlspecialchars($data['alamat']);

    // gambar dihapus dari query
    $sql = "UPDATE siswa SET 
                nama = '$nama', 
                tmpt_Lahir = '$tmpt_Lahir', 
                tgl_Lahir = '$tgl_Lahir', 
                jekel = '$jekel', 
                jurusan = '$jurusan', 
                email = '$email',
                alamat = '$alamat'
            WHERE nis = $nis";

    mysqli_query($koneksi, $sql);

    return mysqli_affected_rows($koneksi);
}

// Fungsi upload DIHAPUS karena sudah tidak dipakai

function registrasi($data)
{
    global $koneksi;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($koneksi, $data["password"]);
    $password2 = mysqli_real_escape_string($koneksi, $data["password2"]);

    $result = mysqli_query($koneksi, "SELECT username FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('username sudah terdaftar');</script>";
        return false;
    }

    if ($password !== $password2) {
        echo "<script>alert('konfirmasi password tidak sesuai');</script>";
        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($koneksi, "INSERT INTO user VALUES('', '$username', '$password')");

    return mysqli_affected_rows($koneksi);
}
?>
