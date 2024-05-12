<?php
session_start();
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/action.php');

if (isset($_GET['maKho'])) {
    // Lấy thông tin kho
    $maKho = $_GET['maKho'];
    $kho = getKhoHangById($maKho);
    $khoInfo = $kho->getTen() . '<br /> ' . $kho->getDiaChi() . '<br />' . $kho->getSDT() . '<br />';

    $maPhieuXuatDuKien = getNewestMaPhieuXuat();
    $response = [
        'khoInfo' => $khoInfo,
        'isExistPhieuXuat' => "false",
        'maPhieuXuat' => $maPhieuXuatDuKien
    ];
    echo json_encode($response);
}
