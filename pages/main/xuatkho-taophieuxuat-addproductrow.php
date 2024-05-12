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
        $maSanPham = $data['id'];
        $ngayXuat = date("Y-m-d");
        $product = getProductById($maSanPham);

        if ($lyDo == 0) {
            $giaXuat = $data['giaXuat'];
            $maNCC = $data['maNCC'];
            $tongTien = intval($data['tongTien']);
            $chiTietTable = '';

            foreach ($data as $key => $value) {
                if (
                    strcmp($key, 'id') == 0 || strcmp($key, 'giaXuat') == 0 ||
                    strcmp($key, 'maPhieuXuat') == 0 || strcmp($key, 'maNCC') == 0 ||
                    strcmp($key, 'tongTien') == 0 || strcmp($key, 'lyDo') == 0
                )
                    continue;

                $maSize = $key;
                $soLuong = $value;

                // Cập nhật số lượng và tổng tiền của phiếu xuat
                $soTien = $giaXuat * $soLuong;
                $thanhTien = intval($soLuong) * intval($giaXuat);
                $tongTien += $thanhTien;
                $chiTietTable .= '
                    <tr>
                        <th scope="row">' . $maSanPham . '</th>
                        <td>' . $product->getTenSanPham() . '</td>
                        <td>' . $maSize . '</td>
                        <td class="text-right">' . changeMoney($giaXuat) . '₫</td>
                        <td class="text-right">' . $soLuong . '</td>
                        <td class="text-right">' . changeMoney($thanhTien) . '₫</td>
                    </tr>';
            }
            //$tongTien = changeMoney($phieuNhap->getTongTien());
            $response = [
                'chiTietTable' => $chiTietTable,
                'tongTien' => changeMoney($tongTien),
                'error' => 'None',
                'lyDo' => $lyDo
            ];
        } else if ($lyDo == 1) {
            $chiTietTable = '';
            $giaBan = $product->getGiaMoi();
            $tongTien = intval($data['tongTien']);

            foreach ($data as $key => $value) {
                if (
                    strcmp($key, 'id') == 0 || strcmp($key, 'maPhieuXuat') == 0 ||
                    strcmp($key, 'tongTien') == 0 || strcmp($key, 'lyDo') == 0
                )
                    continue;

                $maSize = $key;
                $soLuong = $value;

                // Cập nhật số lượng và tổng tiền của phiếu xuat
                $soTien = $giaBan * $soLuong;
                $thanhTien = intval($soLuong) * intval($giaBan);
                $tongTien += $thanhTien;
                $chiTietTable .= '
                    <tr>
                        <th scope="row">' . $maSanPham . '</th>
                        <td>' . $product->getTenSanPham() . '</td>
                        <td>' . $maSize . '</td>
                        <td class="text-right">' . changeMoney($giaBan) . '₫</td>
                        <td class="text-right">' . $soLuong . '</td>
                        <td class="text-right">' . changeMoney($thanhTien) . '₫</td>
                    </tr>';
            }
            //$tongTien = changeMoney($phieuNhap->getTongTien());
            $response = [
                'chiTietTable' => $chiTietTable,
                'tongTien' => changeMoney($tongTien),
                'error' => 'None',
                'lyDo' => $lyDo
            ];
        } else {
            $chiTietTable = '';

            foreach ($data as $key => $value) {
                if (
                    strcmp($key, 'id') == 0 || strcmp($key, 'giaXuat') == 0 ||
                    strcmp($key, 'maPhieuXuat') == 0 || strcmp($key, 'maNCC') == 0 ||
                    strcmp($key, 'tongTien') == 0 || strcmp($key, 'lyDo') == 0
                )
                    continue;

                $maSize = $key;
                $soLuong = $value;

                $chiTietTable .= '
                    <tr>
                        <th scope="row">' . $maSanPham . '</th>
                        <td>' . $product->getTenSanPham() . '</td>
                        <td>' . $maSize . '</td>
                        <td class="text-right"> - - </td>
                        <td class="text-right">' . $soLuong . '</td>
                        <td class="text-right"> - - </td>
                    </tr>';
            }
            $response = [
                'chiTietTable' => $chiTietTable,
                'error' => 'None',
                'lyDo' => $lyDo
            ];
        }
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
