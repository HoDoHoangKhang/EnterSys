<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/action.php');

// if (isset($_GET['maPhieuXuat']) && isset($_GET['trangThai'])) {
//     $maPhieuXuat = $_GET['maPhieuXuat'];
//     $trangThai = $_GET['trangThai'];

//     $phieuXuat = getPhieuXuatById($maPhieuXuat);
//     if ($phieuXuat->getTrangThai() == $trangThai) {
//         echo "
//         <script>
//             sessionStorage.setItem('editTrangThaiPhieuXuat', 'same" . $trangThai . "');
//             window.location = '/HTTT-DN/index.php?page=xuathang';     
//         </script>";
//     } else {
//         $db = new Database();
//         $query = "UPDATE `phieuXuat` SET trangThai = '$trangThai' WHERE maPhieuXuat = '$maPhieuXuat'";
//         if($db->insert_update_delete($query)) {
//             echo "
//             <script>
//                 sessionStorage.setItem('editTrangThaiPhieuXuat', 'success');
//                 window.location = '/HTTT-DN/index.php?page=xuathang'; 
//             </script>";
//         } else {
//             echo "
//             <script>
//                 sessionStorage.setItem('editTrangThaiPhieuXuat', 'fail');
//                 window.location = '/HTTT-DN/index.php?page=xuathang'; 
//             </script>";
//         }
//     }
// }




if (isset($_GET['maPhieuXuat']) && isset($_GET['trangThai'])) {
    $maPhieuXuat = $_GET['maPhieuXuat'];
    $trangThaiMoi = $_GET['trangThai'];
    $query = "";
    $phieuXuat = getPhieuXuatById($maPhieuXuat);
    $trangThaiCu = $phieuXuat->getTrangThai();

    if ($trangThaiCu == $trangThaiMoi) {
        echo "
        <script>
            sessionStorage.setItem('editTrangThaiPhieuXuat', 'same" . $trangThaiMoi . "');
            window.location = '/HTTT-DN/index.php?page=xuatkho&id=danhsachphieuxuat';     
        </script>";
    } else {
        $db = new Database();
        if ($trangThaiCu == DANG_XU_LY) {
            if ($trangThaiMoi == DA_XAC_NHAN) {
                if ($phieuXuat->getLyDo() !== CHUYEN_DEN_KHO_KHAC) {
                    $chiTietPhieuXuatList = getChiTietPhieuXuatListByMaPhieuXuat($maPhieuXuat);
                    for ($i = 0; $i < count($chiTietPhieuXuatList); $i++) {
                        $chiTietPhieuXuat = $chiTietPhieuXuatList[$i];
                        $maSanPham = $chiTietPhieuXuat->getMaSanPham();
                        $maSize = $chiTietPhieuXuat->getMaSize();
                        $soLuong = $chiTietPhieuXuat->getSoLuong();
                        $query = "UPDATE `soluong` SET soLuong = soLuong - $soLuong WHERE maSanPham = '$maSanPham' AND maSize = '$maSize'";
                        $db->insert_update_delete($query);
                    }
                }
            }
            $query = "UPDATE `phieuxuat` SET trangThai = '$trangThaiMoi' WHERE maPhieuXuat = '$maPhieuXuat'";
            if ($db->insert_update_delete($query)) {
                echo "
            <script>
                sessionStorage.setItem('editTrangThaiPhieuXuat', 'success');
                window.location = '/HTTT-DN/index.php?page=xuatkho&id=danhsachphieuxuat';     
            </script>";
            } else {
                echo "
            <script>
                sessionStorage.setItem('editTrangThaiPhieuXuat', 'fail');
                window.location = '/HTTT-DN/index.php?page=xuatkho&id=danhsachphieuxuat';     
            </script>";
            }
        } else if ($trangThaiCu == DA_XAC_NHAN) {
            echo "
            <script>
                sessionStorage.setItem('editTrangThaiPhieuXuat', 'cannotChange');
                window.location = '/HTTT-DN/index.php?page=xuatkho&id=danhsachphieuxuat';     
            </script>";
        } else {
            echo "
            <script>
                sessionStorage.setItem('editTrangThaiPhieuXuat', 'cannotChange');
                window.location = '/HTTT-DN/index.php?page=xuatkho&id=danhsachphieuxuat';     
            </script>";
        }
    }
}
