<?php
session_start();
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/action.php');

// Nhận dữ liệu JSON được gửi từ client
$jsonData = file_get_contents('php://input');
$response = null;

// Kiểm tra xem dữ liệu có hợp lệ không
if ($jsonData) {
    // Giải mã chuỗi JSON thành một mảng kết hợp trong PHP
    $data = json_decode($jsonData, true);

    // Kiểm tra xem mảng kết hợp đã được giải mã thành công hay không
    if ($data !== null) {
        $lyDo = intval($data['lyDo']);
        $maNhanVien = $_SESSION['taiKhoan'];
        $ngayXuat = date("Y-m-d");
        $chiTietList = $data['chiTietList'];
        $db = new Database();

        if ($lyDo == TRA_HANG_CHO_NHA_CUNG_CAP) {
            $maPhieuXuat = $data['maPhieuXuat'];
            $maNCC = $data['maNCC'];

            //Kiểm tra và tạo ra phiếu nhập mới nếu chưa tồn tại mã phiếu nhập được gửi đến
            $sqlTaoPhieuXuat = "";
            if (!isExistMaPhieuXuat($maPhieuXuat)) {
                $sqlTaoPhieuXuat = "INSERT INTO `phieuxuat` (maPhieuXuat, maKhachHang, maNhanVien, tongTien, ngayXuat, tongSoLuong, trangThai, lyDo, maNCC, maKho)
                VALUES ('$maPhieuXuat', NULL, '$maNhanVien', NULL, '$ngayXuat', 0, 0, '$lyDo', '$maNCC', NULL)";
                if (!$db->insert_update_delete($sqlTaoPhieuXuat)) {
                    $response = [
                        'error' => 'Không thể tạo phiêú xuất mới'
                    ];
                    echo json_encode($response);
                    return;
                }
            }

            $soTien = 0;
            $tongSoLuong = 0;
            foreach ($chiTietList as $chiTiet) {
                $maSanPham = $chiTiet['maSanPham'];
                $maSize = $chiTiet['size'];
                $soLuong = intval($chiTiet['soLuong']);
                $giaXuat = intval($chiTiet['giaXuat']);

                $soTien += $giaXuat * $soLuong;
                $tongSoLuong += $soLuong;

                // Tạo chi tiết phiếu xuat mới
                $maChiTietPhieuXuatMoi = getNewestMaChiTietPhieuXuat();
                $sqlChiTietPhieuXuat = "INSERT INTO `chitietphieuxuat` (maChiTietPhieuXuat, maPhieuXuat, maSanPham, maSize, soLuong, giaBan)
                VALUES ($maChiTietPhieuXuatMoi, $maPhieuXuat, $maSanPham, $maSize, $soLuong, $giaXuat)";
                $db->insert_update_delete($sqlChiTietPhieuXuat);
            }
            // Cập nhật số lượng và tổng tiền của phiếu xuat            
            $sqlEditPhieuXuat = "UPDATE `phieuxuat` SET tongSoLuong = $tongSoLuong, tongTien = $soTien
            WHERE maPhieuXuat = $maPhieuXuat";
            $db->insert_update_delete($sqlEditPhieuXuat);

            $response = [
                'alert' => 'Tạo thành công',
                'error' => 'None'
            ];
        } else if ($lyDo == XUAT_CHO_KHACH_HANG) {
            $maPhieuXuat = getNewestMaPhieuXuat();
            $tenKH = $data['tenKH'];
            $diaChi = $data['diaChi'];
            $sdt = $data['sdt'];
            $idKH = NULL;

            if (!isExistSDTKhachHang($sdt)) {
                // Tạo khách hàng mới
                $idKH = getNewestMaKhachHang();
                $sqlTaoKH = "INSERT INTO `khachhang` (id, ten, diaChi, sdt) 
                VALUES ('$idKH', '$tenKH', '$diaChi', '$sdt')";
                $db->insert_update_delete($sqlTaoKH);
            } else {
                $khachhang = getKhachHangBySDT($sdt);
                $idKH = $khachhang->getSDT();
            }

            //Kiểm tra và tạo ra phiếu nhập mới nếu chưa tồn tại mã phiếu nhập được gửi đến
            $sqlTaoPhieuXuat = "";
            if (!isExistMaPhieuXuat($maPhieuXuat)) {
                $sqlTaoPhieuXuat = "INSERT INTO `phieuxuat` (maPhieuXuat, maKhachHang, maNhanVien, tongTien, ngayXuat, tongSoLuong, trangThai, lyDo, maNCC, maKho)
                VALUES ('$maPhieuXuat', '$idKH', '$maNhanVien', NULL, '$ngayXuat', 0, 0, '$lyDo', NULL, NULL)";
                if (!$db->insert_update_delete($sqlTaoPhieuXuat)) {
                    $response = [
                        'error' => 'Không thể tạo phiêú xuất mới'
                    ];
                    echo json_encode($response);
                    return;
                }
            }

            $soTien = 0;
            $tongSoLuong = 0;
            foreach ($chiTietList as $chiTiet) {
                $maSanPham = $chiTiet['maSanPham'];
                $maSize = $chiTiet['size'];
                $soLuong = intval($chiTiet['soLuong']);
                $giaXuat = intval($chiTiet['giaXuat']);

                $soTien += $giaXuat * $soLuong;
                $tongSoLuong += $soLuong;

                // Tạo chi tiết phiếu xuat mới
                $maChiTietPhieuXuatMoi = getNewestMaChiTietPhieuXuat();
                $sqlChiTietPhieuXuat = "INSERT INTO `chitietphieuxuat` (maChiTietPhieuXuat, maPhieuXuat, maSanPham, maSize, soLuong, giaBan)
                VALUES ($maChiTietPhieuXuatMoi, $maPhieuXuat, $maSanPham, $maSize, $soLuong, $giaXuat)";
                $db->insert_update_delete($sqlChiTietPhieuXuat);
            }
            // Cập nhật số lượng và tổng tiền của phiếu xuat            
            $sqlEditPhieuXuat = "UPDATE `phieuxuat` SET tongSoLuong = $tongSoLuong, tongTien = $soTien
            WHERE maPhieuXuat = $maPhieuXuat";
            $db->insert_update_delete($sqlEditPhieuXuat);

            $response = [
                'alert' => 'Tạo thành công',
                'error' => 'None'
            ];
        } else {
            $maPhieuXuat = $data['maPhieuXuat'];
            $maKho = $data['maKho'];

            //Kiểm tra và tạo ra phiếu nhập mới nếu chưa tồn tại mã phiếu nhập được gửi đến
            $sqlTaoPhieuXuat = "";
            if (!isExistMaPhieuXuat($maPhieuXuat)) {
                $sqlTaoPhieuXuat = "INSERT INTO `phieuxuat` (maPhieuXuat, maKhachHang, maNhanVien, tongTien, ngayXuat, tongSoLuong, trangThai, lyDo, maNCC, maKho)
                VALUES ('$maPhieuXuat', NULL, '$maNhanVien', 0, '$ngayXuat', 0, 0, '$lyDo', NULL, '$maKho')";
                if (!$db->insert_update_delete($sqlTaoPhieuXuat)) {
                    $response = [
                        'error' => 'Không thể tạo phiêú xuất mới'
                    ];
                    echo json_encode($response);
                    return;
                }
            }

            $tongSoLuong = 0;
            foreach ($chiTietList as $chiTiet) {
                $maSanPham = $chiTiet['maSanPham'];
                $maSize = $chiTiet['size'];
                $soLuong = intval($chiTiet['soLuong']);

                $tongSoLuong += $soLuong;

                // Tạo chi tiết phiếu xuat mới
                $maChiTietPhieuXuatMoi = getNewestMaChiTietPhieuXuat();
                $sqlChiTietPhieuXuat = "INSERT INTO `chitietphieuxuat` (maChiTietPhieuXuat, maPhieuXuat, maSanPham, maSize, soLuong, giaBan)
                VALUES ($maChiTietPhieuXuatMoi, $maPhieuXuat, $maSanPham, $maSize, $soLuong, NULL)";
                $db->insert_update_delete($sqlChiTietPhieuXuat);
            }
            // Cập nhật số lượng và tổng tiền của phiếu xuat            
            $sqlEditPhieuXuat = "UPDATE `phieuxuat` SET tongSoLuong = $tongSoLuong WHERE maPhieuXuat = $maPhieuXuat";
            $db->insert_update_delete($sqlEditPhieuXuat);

            $response = [
                'alert' => 'Tạo thành công',
                'error' => 'None'
            ];
        }

        $db->disconnect();
    } else {
        // Nếu không thể giải mã JSON, trả về một thông báo lỗi
        $response = [
            'error' => "Error decoding JSON data"
        ];
    }
} else {
    // Nếu không có dữ liệu JSON, trả về một thông báo lỗi
    $response = [
        'error' => "No JSON data received"
    ];
}
echo json_encode($response);
