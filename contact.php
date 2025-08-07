<?php
/**
 * Ini adalah file PHP untuk menerima data dari formulir kontak Anda.
 * Ganti alamat email di bawah ini dengan alamat email tujuan Anda.
 */
$receiving_email_address = '183220015@std.ulbi.ac.id';

// Cek apakah file ini diakses dengan metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil dan bersihkan data dari form
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST['subject']), FILTER_SANITIZE_STRING);
    $message = trim($_POST['message']);

    // Validasi dasar
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Jika ada data yang tidak valid, kirim respons error
        http_response_code(400);
        echo 'Harap isi semua kolom dengan benar.';
        exit;
    }

    // Siapkan konten email
    $email_content = "Nama: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Subjek: $subject\n\n";
    $email_content .= "Pesan:\n$message\n";

    // Siapkan header email
    $email_headers = "From: $name <$email>";

    // Kirim email menggunakan fungsi mail() bawaan PHP
    if (mail($receiving_email_address, $subject, $email_content, $email_headers)) {
        // Jika berhasil, kirim respons sukses
        http_response_code(200);
        echo 'Pesan Anda telah terkirim. Terima kasih!';
    } else {
        // Jika gagal, kirim respons error server
        http_response_code(500);
        echo 'Oops! Terjadi kesalahan di server kami.';
    }
} else {
    // Jika diakses tidak dengan metode POST
    http_response_code(403);
    echo 'Terjadi masalah dengan pengiriman Anda.';
}
?>