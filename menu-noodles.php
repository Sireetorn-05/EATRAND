<?php
include ('header.php');
include ('menuall-meat-noodles.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EatRand</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/menu-all.css">
</head>
<body>
    <section class="menu-header">
        <h2>เมนูอาหารทั้งหมด</h2>
        <div class="menu">
            <div class="column">
                <a href="Menu-All.php"><h3>ข้าว</h3></a>
            </div>
            <div class="column">
                <a href="#"><h3>เส้น</h3></a>
            </div>
        </div>
    </section>

    <section class="menuall" id="menuall">
            <ul class="accordion">
                <li>
                    <input type="radio" name="accordion" id="first" checked>
                    <label for="first">หมู</label>
                    <div class="content">
                        <?php foreach ($menus_noodles['pork'] as $item): ?>
                            <div class="item"><?= $item ?></div>
                        <?php endforeach; ?>
                    </div>
                </li>
                <li>
                    <input type="radio" name="accordion" id="second">
                    <label for="second">ไก่</label>
                    <div class="content">
                        <?php foreach ($menus_noodles['chicken'] as $item): ?>
                            <div class="item"><?= $item ?></div>
                        <?php endforeach; ?>
                    </div>
                </li>
                <li>
                    <input type="radio" name="accordion" id="third">
                    <label for="third">เนื้อวัว</label>
                    <div class="content">
                        <?php foreach ($menus_noodles['beef'] as $item): ?>
                            <div class="item"><?= $item ?></div>
                        <?php endforeach; ?>
                    </div>
                </li>
                <li>
                    <input type="radio" name="accordion" id="fourth">
                    <label for="fourth">ปลา</label>
                    <div class="content">
                        <?php foreach ($menus_noodles['fish'] as $item): ?>
                            <div class="item"><?= $item ?></div>
                        <?php endforeach; ?>
                    </div>
                </li>
                <li>
                    <input type="radio" name="accordion" id="fifth">
                    <label for="fifth">หมึก</label>
                    <div class="content">
                        <?php foreach ($menus_noodles['squid'] as $item): ?>
                            <div class="item"><?= $item ?></div>
                        <?php endforeach; ?>
                    </div>
                </li>
                <li>
                    <input type="radio" name="accordion" id="sixth">
                    <label for="sixth">กุ้ง</label>
                    <div class="content">
                        <?php foreach ($menus_noodles['shrimp'] as $item): ?>
                            <div class="item"><?= $item ?></div>
                        <?php endforeach; ?>
                    </div>
                </li>
            </ul>
    </section>
    <script src="js/script.js"></script>
</body>
</html>
