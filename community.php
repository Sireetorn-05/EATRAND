<?php
include('header.php');

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

// ดึงข้อมูลร้านอาหารที่ได้รับการอนุมัติ
$sql = "SELECT * FROM restaurants WHERE is_approved = 1";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EatRand</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/community.css">
</head>
<body>
<main>
    <div class="restaurant-list">
        <h2>ร้านอาหารบริเวณชุมชน</h2>
        <a href="add_restaurant.php" class="add-restaurant">+ เพิ่มร้านอาหาร</a> <!-- ลิงก์ไปยังหน้าสำหรับเพิ่มร้านอาหาร -->

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='restaurant-item'>";
                echo "<img src='" . $row['image_path'] . "' alt='รูปภาพร้านอาหาร'>";
                echo "<div class='restaurant-info'>";
                echo "<h3>" . $row['NAME'] . "</h3>";
                echo "<p>" . $row['details'] . "</p>";
                echo "<p>เวลาเปิด-ปิด: " . $row['opening_hours'] . "</p>";
                echo "<p><a href='" . $row['gps_url'] . "' target='_blank'>ดูใน Google Map</a></p>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>ยังไม่มีร้านอาหารที่ได้รับการอนุมัติ</p>";
        }

        // ปิดการเชื่อมต่อ
        $conn->close();
        ?>
    </div>
</main>
<script src="js/script.js"></script>
</body>
</html>
