<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'random') {
    $foodType = $_GET['food-type'] ?? '';
    $meatType = $_GET['meat-type'] ?? '';
    
    $menus = [];
    
    // โหลดเมนูตามประเภทที่เลือก
    if ($foodType === 'rice') {
        include('menuall-meat-rice.php');
        $menus = $menus_rice;
    } elseif ($foodType === 'noodles') {
        include('menuall-meat-noodles.php');
        $menus = $menus_noodles;
    }

    $response = [];
    if (isset($menus[$meatType])) {
        $randomMenu = $menus[$meatType][array_rand($menus[$meatType])];
        $response = [
            'menu' => $randomMenu,
            'type' => $foodType
        ];
    } else {
        $response = [
            'error' => 'ไม่พบเมนูสำหรับประเภทที่เลือก'
        ];
    }

    // ส่งข้อมูลกลับเป็น JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
