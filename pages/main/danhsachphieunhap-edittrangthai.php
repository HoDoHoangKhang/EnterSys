<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/action.php');

if (isset($_GET['maPhieuNhap']) && isset($_GET['trangThai'])) {
    $maPhieuNhap = $_GET['maPhieuNhap'];
    $trangThaiMoi = $_GET['trangThai'];
    $query = "";
    $phieuNhap = getPhieuNhapById($maPhieuNhap);
    $trangThaiCu = $phieuNhap->getTrangThai();


    if ($trangThaiCu == $trangThaiMoi) {
        echo "
        <script>
            sessionStorage.setItem('editTrangThaiPhieuNhap', 'same" . $trangThaiMoi . "');
            window.location = '/HTTT-DN/index.php?page=nhaphang&id=danhsachphieunhap';     
        </script>";
    } else {
        $db = new Database();
        if ($trangThaiCu == DANG_XU_LY) {
            if ($trangThaiMoi == DA_NHAN) {
                $chiTietPhieuNhapList = getChiTietPhieuNhapListByMaPhieuNhap($maPhieuNhap);
                for ($i = 0; $i < count($chiTietPhieuNhapList); $i++) {
                    $chiTietPhieuNhap = $chiTietPhieuNhapList[$i];
                    $maSanPham = $chiTietPhieuNhap->getMaSanPham();
                    $maSize = $chiTietPhieuNhap->getMaSize();
                    $soLuong = $chiTietPhieuNhap->getSoLuong();
                    if (isExistMaSizeOfMaSanPham($maSanPham, $maSize)) {
                        $query = "UPDATE `soluong` SET soLuong = soLuong + $soLuong WHERE maSanPham = '$maSanPham' AND maSize = '$maSize'";
                    } else {
                        $query = "INSERT INTO `soluong` (maSanPham, soLuong, maSize) VALUES ($maSanPham, $soLuong, $maSize)";
                    }
                    $db->insert_update_delete($query);
                }
            } 
            $query = "UPDATE `phieunhap` SET trangThai = '$trangThaiMoi' WHERE maPhieuNhap = '$maPhieuNhap'";
            if ($db->insert_update_delete($query)) {
                echo "
            <script>
                sessionStorage.setItem('editTrangThaiPhieuNhap', 'success');
                window.location = '/HTTT-DN/index.php?page=nhaphang&id=danhsachphieunhap';     
            </script>";
            } else {
                echo "
            <script>
                sessionStorage.setItem('editTrangThaiPhieuNhap', 'fail');
                window.location = '/HTTT-DN/index.php?page=nhaphang&id=danhsachphieunhap';     
            </script>";
            }
        } else if ($trangThaiCu == DA_NHAN) {
            echo "
            <script>
                sessionStorage.setItem('editTrangThaiPhieuNhap', 'cannotChange');
                window.location = '/HTTT-DN/index.php?page=nhaphang&id=danhsachphieunhap';     
            </script>";
        } else {
            echo "
            <script>
                sessionStorage.setItem('editTrangThaiPhieuNhap', 'cannotChange');
                window.location = '/HTTT-DN/index.php?page=nhaphang&id=danhsachphieunhap';     
            </script>";
        }

        // $query = "UPDATE `phieunhap` SET trangThai = '$trangThaiMoi' WHERE maPhieuNhap = '$maPhieuNhap'";
        // if ($db->insert_update_delete($query)) {
        //     echo "
        //     <script>
        //         sessionStorage.setItem('editTrangThaiPhieuNhap', 'success');
        //         window.location = '/HTTT-DN/index.php?page=nhaphang&id=danhsachphieunhap';     
        //     </script>";
        // } else {
        //     echo "
        //     <script>
        //         sessionStorage.setItem('editTrangThaiPhieuNhap', 'fail');
        //         window.location = '/HTTT-DN/index.php?page=nhaphang&id=danhsachphieunhap';     
        //     </script>";
        // }
    }
}
