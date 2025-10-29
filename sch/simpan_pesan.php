<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Pastikan file ini ada setelah instalasi Composer

// Konfigurasi database
$DB_HOST = 'localhost';  // Ganti sesuai dengan host database Anda
$DB_USER = 'root';       // Ganti dengan username database Anda
$DB_PASS = '';           // Ganti dengan password database Anda
$DB_NAME = 'sman8';  // Nama database Anda

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO pesan (nama, email, subjek, pesan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message); // ✅ Perbaikan di sini

    if ($stmt->execute()) {
        $mail = new PHPMailer(true);
        try {
            // Konfigurasi server SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'febyyyamelia28@gmail.com'; 
            $mail->Password   = 'zudpmzyodyeyqepg';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Pengaturan email
            $mail->setFrom($mail->Username, 'Pengirim');
            $mail->addAddress('febyyyaaa02@gmail.com', 'Feby Amelya');
            $mail->addReplyTo($email, $name);

            // Konten email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = "<h3>Pesan dari: $name</h3>
                              <p><strong>Email:</strong> $email</p>
                              <p><strong>Pesan:</strong><br>$message</p>";

            $mail->send();

            // Redirect dengan status sukses
            header("Location: contact.html?status=success");
            exit;
        } catch (Exception $e) {
            header("Location: contact.html?status=error");
            exit;
        }
    } else {
        header("Location: contact.html?status=dberror");
        exit;
    }

    $stmt->close();
}

$conn->close();
?>
