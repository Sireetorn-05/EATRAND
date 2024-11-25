<?php
include ('header.php');
?>
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

// ดึงข้อมูลร้านอาหารที่ยังไม่ได้รับการอนุมัติ
$sql = "SELECT * FROM restaurants WHERE is_approved = 0";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin_approve.css">
    <title>AdminEatRand</title>
</head>
<body>
    <h2>รายการร้านอาหารที่รอการอนุมัติ</h2>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='restaurant-card'>";
                echo "<img class='restaurant-img' src='" . $row['image_path'] . "' alt='รูปภาพร้านอาหาร'>"; // ขยับรูปภาพมาข้างหน้าข้อความ
                echo "<div class='restaurant-details'>";
                echo "<h3>" . $row['NAME'] . "</h3>";
                echo "<p>" . $row['details'] . "</p>";
                echo "<p>เวลาเปิด-ปิด: " . $row['opening_hours'] . "</p>";
                echo "<p><a href='" . $row['gps_url'] . "' target='_blank'>ดูใน Google Map</a></p>";
                echo "</div>";
                echo "<a class='approve-btn' href='approve_restaurant.php?id=" . $row['id'] . "'>อนุมัติ</a>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-data'>ไม่มีร้านอาหารที่รอการอนุมัติ</p>";
        }
        $conn->close();
        ?>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
