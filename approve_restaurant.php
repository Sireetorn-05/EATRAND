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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // อัปเดตสถานะร้านอาหารเป็นได้รับการอนุมัติ
    $sql = "UPDATE restaurants SET is_approved = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo 'อนุมัติร้านอาหารสำเร็จ!';
    } else {
        echo 'เกิดข้อผิดพลาด: ' . $stmt->error;
    }

    $stmt->close();
} else {
    echo 'คำขอไม่ถูกต้อง.';
}

$conn->close();
?>
