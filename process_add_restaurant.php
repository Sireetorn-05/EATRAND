<?php
// ตั้งค่าการเชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eatrand1"; // ใส่ชื่อฐานข้อมูลของคุณ

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

$success = false; // ตัวแปรสำหรับเก็บสถานะความสำเร็จ

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากแบบฟอร์ม
    $name = $_POST['name'];
    $details = $_POST['details'];
    $opening_hours = $_POST['opening_hours'];
    $gps_url = $_POST['gps_url'];

    // จัดการอัพโหลดรูปภาพ
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $uploadDir = 'uploads/';
        $imageUploadPath = $uploadDir . $imageName;

        // ตรวจสอบว่ามีโฟลเดอร์สำหรับอัพโหลดหรือไม่
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // ย้ายรูปภาพไปยังโฟลเดอร์ที่กำหนด
        if (move_uploaded_file($imageTmpPath, $imageUploadPath)) {
            // เตรียมคำสั่ง SQL สำหรับบันทึกข้อมูลร้านอาหารลงฐานข้อมูล
            $stmt = $conn->prepare("INSERT INTO restaurants (name, details, opening_hours, gps_url, image_path) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $details, $opening_hours, $gps_url, $imageUploadPath);

            if ($stmt->execute()) {
                $success = true; // การเพิ่มร้านอาหารสำเร็จ
            } else {
                $error_message = 'เกิดข้อผิดพลาด: ' . $stmt->error;
            }

            $stmt->close();
        } else {
            $error_message = 'เกิดข้อผิดพลาดในการอัพโหลดรูปภาพ.';
        }
    } else {
        $error_message = 'กรุณาอัพโหลดรูปภาพ.';
    }
} else {
    $error_message = 'คำขอไม่ถูกต้อง.';
}

$conn->close();

// ส่งกลับไปที่หน้า add_restaurant.php พร้อมสถานะความสำเร็จ
header("Location: add_restaurant.php?success=" . ($success ? '1' : '0'));
exit();
?>
