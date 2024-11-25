<?php
// รวมไฟล์เมนูข้าวและเส้น
include('menuall-meat-rice.php');
include('menuall-meat-noodles.php');

// รวมข้อมูลเมนูข้าวและเส้น
$all_menus = array_merge_recursive($menus_rice, $menus_noodles);

// API สำหรับสุ่มเมนู
if(isset($_GET['action']) && $_GET['action'] == 'random') {
    // กรองเฉพาะหมวดหมู่ที่มีเมนู
    $categories = array_filter($all_menus, function($category) {
        return !empty($category);
    });

    // ตรวจสอบว่ามีหมวดหมู่ที่ไม่ว่างหรือไม่
    if (empty($categories)) {
        echo json_encode(['menu' => 'ไม่มีเมนูให้สุ่ม', 'type' => '']);
        exit;
    }

    // สุ่มหมวดหมู่และเมนู
    $randomCategoryKey = array_rand($categories);
    $randomCategory = $categories[$randomCategoryKey];
    $randomMenu = $randomCategory[array_rand($randomCategory)];

    // ตรวจสอบประเภทของเมนู (ข้าวหรือเส้น)
    $type = in_array($randomMenu, $menus_rice[$randomCategoryKey]) ? 'rice' : 'noodle';

    // ส่งผลลัพธ์กลับในรูปแบบ JSON
    header('Content-Type: application/json');
    echo json_encode(['menu' => $randomMenu, 'type' => $type]);
    exit;
}
?>

<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EatRand</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/random-food.css">
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6SjIJZ9gXbLHqowwvRLbzXGnWm_lo5S4&libraries=places"></script>
</head>
<body>
<section class="home" id="home">
    <div class="content">
        <h1>เริ่มสุ่มอาหาร</h1>
        <div class="buttons">
            <a href="#" class="btn" id="random-btn">เริ่มสุ่ม</a>
            <a href="index.php" class="btn">กลับ</a>
        </div> 
    </div> 
</section>

<!-- Modal Box -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>เมนูที่ได้</h2>
        <div id="result" class="result"></div>
        <div id="map" class="map"></div>
        <div class="buttons">
            <a href="#" class="btn btn-random" id="random-again-btn">เริ่มสุ่มใหม่</a>
            <a href="#" class="btn btn-nearby" id="nearby-shops-btn">ร้านอาหารแนะนำ</a>
            <a href="#" class="btn btn-cancel" id="cancel-btn">Close</a>
        </div>
    </div>
</div>

<script>
    // ดึง modal
    var modal = document.getElementById("myModal");

    // ดึง <span> ที่ใช้ปิด modal
    var span = document.getElementsByClassName("close")[0];

    // ดึง div สำหรับผลลัพธ์
    var resultDiv = document.getElementById('result');
    var mapDiv = document.getElementById('map');

    // ฟังก์ชันเปิด modal พร้อมแอนิเมชันซูมเข้า
    function openModal() {
        modal.style.display = "block";
        setTimeout(() => {
            modal.classList.add("show");
            modal.classList.remove("hide");
        }, 10); // ให้เวลาสั้นๆ เพื่อให้เกิด transition
    }

    // ฟังก์ชันปิด modal พร้อมแอนิเมชันซูมออก
    function closeModal() {
        modal.classList.remove("show");
        modal.classList.add("hide");
        setTimeout(() => {
            modal.style.display = "none";
        }, 300); // ให้เวลาตรงกับ transition เพื่อไม่ให้เกิดการกระพริบ
    }

    // เริ่มสุ่มอาหาร
    document.getElementById('random-btn').addEventListener('click', function(event) {
    event.preventDefault(); // ป้องกันการโหลดหน้าใหม่

    // เปลี่ยนหัวข้อกลับเป็น "เมนูที่ได้"
    document.querySelector('.modal-content h2').textContent = 'เมนูที่ได้';

    // แสดงแอนิเมชั่นการโหลด
    resultDiv.innerHTML = `<div class="loader"></div>`;
    mapDiv.style.display = "none"; // ซ่อนแผนที่

    // แสดง modal พร้อมกับแอนิเมชั่นซูมเข้า
    openModal();

    // ใช้ fetch เพื่อดึงข้อมูลจากเซิร์ฟเวอร์
    fetch('Random-Food.php?action=random')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.menu) {
                // ใช้ setTimeout เพื่อจำลองการโหลดข้อมูล
                setTimeout(function() {
                    let imageSrc = data.type === 'rice' ? 'images/rice.png' : 'images/noodles.png';
                    resultDiv.innerHTML = `
                        <img src="${imageSrc}" alt="${data.type} Image">
                        <p>${data.menu}</p>
                    `;
                }, 500); // เพิ่มการหน่วงเวลาเล็กน้อยเพื่อให้แอนิเมชั่นเห็นได้ชัด
            } else {
                resultDiv.innerHTML = `<p>ไม่พบข้อมูลเมนู</p>`;
            }
        })
        .catch(error => {
            resultDiv.innerHTML = `<p>เกิดข้อผิดพลาด: ${error.message}</p>`;
        });
});

    // เมื่อผู้ใช้คลิกที่ <span> (x) ให้ปิด modal
    span.onclick = function() {
        closeModal();
    }

    // ร้านค้าใกล้เคียง
    document.getElementById('nearby-shops-btn').addEventListener('click', function(event) {
    event.preventDefault();
    openModal();
    document.querySelector('.modal-content h2').textContent = 'ร้านอาหารแนะนำ'; // เปลี่ยนหัวข้อเป็น ร้านอาหารแนะนำ
    findNearbyShops(); // เรียกฟังก์ชันเพื่อค้นหาร้านค้าใกล้เคียง
    });

    // เริ่มสุ่มใหม่
    document.getElementById('random-again-btn').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('random-btn').click();
    });

    // ยกเลิก
    document.getElementById('cancel-btn').addEventListener('click', function(event) {
        event.preventDefault();
        closeModal();
    });

    // เมื่อผู้ใช้คลิกที่นอก modal ให้ปิด modal
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }

    // ฟังก์ชันแสดงผลร้านค้าใกล้เคียง
    function showNearbyShops(shops, map) {
    resultDiv.innerHTML = '';
    mapDiv.style.display = "block"; // แสดงแผนที่
    var bounds = new google.maps.LatLngBounds();
    
    // เลือกร้านแค่ 6 ร้านแรก
    const limitedShops = shops.slice(0, 6);
    
    limitedShops.forEach(function(shop) {
        var shopLocation = new google.maps.LatLng(shop.geometry.location.lat(), shop.geometry.location.lng());
        bounds.extend(shopLocation);

        resultDiv.innerHTML += `
            <div class="shop-item">
                <h4>${shop.name}</h4>
                <p>${shop.vicinity}</p>
            </div>
        `;

        new google.maps.Marker({
            position: shopLocation,
            map: map,
            title: shop.name
        });
    });

    map.fitBounds(bounds);
}

    // ฟังก์ชันหาตำแหน่งร้านค้าใกล้เคียง
    function findNearbyShops() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                var location = new google.maps.LatLng(latitude, longitude);

                var request = {
                    location: location,
                    radius: '1500',
                    type: ['restaurant']
                };

                var map = new google.maps.Map(document.getElementById('map'), {
                    center: location,
                    zoom: 15
                });

                var service = new google.maps.places.PlacesService(map);
                service.nearbySearch(request, function(results, status) {
                    if (status === google.maps.places.PlacesServiceStatus.OK) {
                        showNearbyShops(results, map);
                    } else {
                        alert('ไม่พบร้านค้าใกล้เคียง');
                    }
                });
            }, function() {
                alert('ไม่สามารถเข้าถึงตำแหน่งของคุณได้');
            });
        } else {
            alert('บราวเซอร์ของคุณไม่สนับสนุน Geolocation');
        }
    }
</script>
<script src="js/script.js"></script>
</body>
</html>
