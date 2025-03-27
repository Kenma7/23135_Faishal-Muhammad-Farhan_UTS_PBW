<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../phpmailer/src/PHPMailer.php';
require __DIR__ . '/../phpmailer/src/SMTP.php';
require __DIR__ . '/../phpmailer/src/Exception.php';


header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? htmlspecialchars($_POST["name"]) : '';
    $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : '';
    $subject = isset($_POST["subject"]) ? htmlspecialchars($_POST["subject"]) : '';
    $message = isset($_POST["message"]) ? htmlspecialchars($_POST["message"]) : '';

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "Semua bidang harus diisi!"]);
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Konfigurasi SMTP Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'faishalmuhammad233@gmail.com'; // Ganti dengan email kamu
        $mail->Password = 'slwr ovgb zahr locx';  // Ganti dengan App Password Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Pengaturan email
        $mail->setFrom('faishalmuhammad233@gmail.com', 'Web Contact Form'); // Pakai email pengirim yang valid
        $mail->addReplyTo($email, $name); // Agar penerima bisa membalas ke pengirim form
        $mail->addAddress('youremail@gmail.com'); // Ganti dengan email penerima
        
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<h3>Pesan dari Contact Form</h3>
                          <p><strong>Nama:</strong> $name</p>
                          <p><strong>Email:</strong> $email</p>
                          <p><strong>Pesan:</strong></p>
                          <p>$message</p>";
        $mail->AltBody = "Nama: $name\nEmail: $email\n\nPesan:\n$message";

        // Kirim email
        if ($mail->send()) {
            echo json_encode(["status" => "success", "message" => "Pesan berhasil dikirim!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal mengirim pesan."]);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Gagal mengirim pesan: " . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Akses tidak diizinkan!"]);
}
?>
