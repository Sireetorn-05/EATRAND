<?php
include('header.php');
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EatRand</title>
    <link rel="stylesheet" href="css/community.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>เพิ่มร้านอาหาร</h2>
        <form action="process_add_restaurant.php" method="post" enctype="multipart/form-data">
            <label for="name">ชื่อร้านอาหาร:</label>
            <input type="text" id="name" name="name" required>

            <label for="details">รายละเอียด:</label>
            <textarea id="details" name="details" required></textarea>

            <label for="opening_hours">เวลาเปิด-ปิด:</label>
            <input type="text" id="opening_hours" name="opening_hours" required>

            <label for="gps_url">URL GPS (Google Map):</label>
            <input type="url" id="gps_url" name="gps_url" required>

            <label for="image">รูปภาพ:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit">เพิ่มร้านอาหาร</button>
        </form>
    </div>

   <!-- โมเดลบ็อกซ์ -->
   <div id="successModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="success-icon">
                <div class="checkmark"><i class="fas fa-check"></i></div>
            </div>
            <p>เพิ่มร้านอาหารสำเร็จ! กรุณารอให้แอดมินตรวจสอบ</p>
            <div class="modal-buttons">
                <button class="ok-button">OK</button>
            </div>
        </div>
    </div>

    <script>
        // ตรวจสอบค่าพารามิเตอร์ success ใน URL
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === '1') {
                // แสดงโมเดลบ็อกซ์เมื่อเพิ่มร้านอาหารสำเร็จ
                const modal = document.getElementById('successModal');
                modal.style.display = "block";
            }

            // ปิดโมเดลเมื่อคลิกที่ปุ่มปิด
            document.querySelector('.close').onclick = function() {
                document.getElementById('successModal').style.display = "none";
            };

            // ปิดโมเดลเมื่อคลิกนอกโมเดล
            window.onclick = function(event) {
                const modal = document.getElementById('successModal');
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };

            // ปิดโมเดลเมื่อคลิกที่ปุ่ม OK
            document.querySelector('.ok-button').onclick = function() {
                document.getElementById('successModal').style.display = "none";
            };
        });
    </script>
</body>
</html>
