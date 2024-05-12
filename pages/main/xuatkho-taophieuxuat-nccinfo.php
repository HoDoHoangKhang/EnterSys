<?php
session_start();
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/action.php');

if (isset($_GET['maNhaCungCap'])) {
    // Lấy thông tin nhà cung cấp
    $maNhaCungCap = $_GET['maNhaCungCap'];
    $ncc = getNhaCungCapById($maNhaCungCap);
    $nhaCungCapInfo = $ncc->getTen() . '<br /> ' . $ncc->getDiaChi() . '<br />' .
        $ncc->getEmail() . '<br />' . $ncc->getSDT() . '<br />';

    // Kiểm tra có tồn tại phiếu nhập vào hôm nay, do cùng nhân viên tạo ra và có cùng nhà cung cấp    

    $maPhieuXuatDuKien = getNewestMaPhieuXuat();
    $response = [
        'nccInfo' => $nhaCungCapInfo,
        'isExistPhieuXuat' => "false",
        'maPhieuXuat' => $maPhieuXuatDuKien
    ];
    echo json_encode($response);
}
