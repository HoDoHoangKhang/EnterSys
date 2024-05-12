<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/sanpham.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/size.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/soluong.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/nhacungcap.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/khohang.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/khachhang.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/nhanhieu.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/taikhoan.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/nhanvien.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/chucvu.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/phieunhap.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/chitietphieunhap.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/phieuxuat.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/chitietphieuxuat.php');

const DA_XOA = 0;
const CON_HANG = 1;
const HET_HANG = 2;
const ADMIN = 'admin';
const NHAN_VIEN = 'nhanvien';
const QUAN_LY_KHO = 'quanlykho';
const QUAN_LY_NHAN_SU = 'quanlynhansu';
const QUAN_LY_KINH_DOANH = 'quanlykinhdoanh';
const DA_NHAN = 1;
const DA_HUY = 2;
const DA_XAC_NHAN = 1;
const DANG_XU_LY = 0;
const TRA_HANG_CHO_NHA_CUNG_CAP = 0;
const XUAT_CHO_KHACH_HANG = 1;
const CHUYEN_DEN_KHO_KHAC = 2;	

// Lấy mảng tất cả sản phẩm
function getProductList()
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `sanpham`");
	$productArr = array();
	while ($row = mysqli_fetch_assoc($kq)) {
		$sanPham = new SanPham(
			$row['maSanPham'],
			$row['tenSanPham'],
			$row['giaCu'],
			$row['giaMoi'],
			$row['moTa'],
			$row['hinhAnh'],
			$row['maNhanHieu'],
			$row['sanPhamMoi'],
			$row['sanPhamHot'],
			$row['tinhTrang']
		);
		$productArr[] = $sanPham;
	}
	$db->disconnect();
	return $productArr;
}

function getSoLuongSanPham($maSanPham)
{
	if (!isExistMaSanPham($maSanPham)) {
		return 0;
	}
	$db = new Database();
	$sql = "SELECT SUM(soLuong) as `SoLuong` FROM soluong WHERE maSanPham = '" . $maSanPham . "'";
	$kq = mysqli_query($db->getConnection(), $sql);
	$row = mysqli_fetch_assoc($kq);
	$db->disconnect();
	return $row['SoLuong'];
}

function isExistMaSanPham($maSanPham)
{
	$db = new Database();
	$sql = "SELECT * FROM `sanpham` WHERE maSanPham ='" . $maSanPham . "'";
	$kq = mysqli_query($db->getConnection(), $sql);
	$row = mysqli_fetch_assoc($kq);
	if (is_null($row)) {
		$db->disconnect();
		return false;
	} else {
		$db->disconnect();
		return true;
	}
}

function getChiTietSoLuong($maSanPham)
{
	$db = new Database();
	$sql = "SELECT * FROM `soluong` WHERE maSanPham = '" . $maSanPham . "'";
	$kq = mysqli_query($db->getConnection(), $sql);
	$soLuongArr = array();
	while ($row = mysqli_fetch_assoc($kq)) {
		$soLuong = new SoLuong(
			$row['maSanPham'],
			$row['soLuong'],
			$row['maSize']
		);
		$soLuongArr[] = $soLuong;
	}
	$db->disconnect();
	return $soLuongArr;
}

function getNhaCungCapList()
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `nhacungcap` Where tinhTrang=1");
	$nhaCungCapArr = array();
	while ($row = mysqli_fetch_assoc($kq)) {
		$nhaCungCap = new NhaCungCap(
			$row['maNCC'],
			$row['tenNCC'],
			$row['diaChiNCC'],
			$row['sdtNCC'],
			$row['emailNCC'],
			$row['tinhTrang']
		);
		$nhaCungCapArr[] = $nhaCungCap;
	}
	$db->disconnect();
	return $nhaCungCapArr;
}

function getNhaCungCapById($id)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `nhacungcap` WHERE maNCC = '" . $id . "'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$nhaCungCap = new NhaCungCap(
			$row['maNCC'],
			$row['tenNCC'],
			$row['diaChiNCC'],
			$row['sdtNCC'],
			$row['emailNCC'],
			$row['tinhTrang']
		);
		$db->disconnect();
		return $nhaCungCap;
	} else {
		$db->disconnect();
		return null;
	}
}

function getProductById($id)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `sanpham` WHERE maSanPham = '" . $id . "'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$sanPham = new SanPham(
			$row['maSanPham'],
			$row['tenSanPham'],
			$row['giaCu'],
			$row['giaMoi'],
			$row['moTa'],
			$row['hinhAnh'],
			$row['maNhanHieu'],
			$row['sanPhamMoi'],
			$row['sanPhamHot'],
			$row['tinhTrang']
		);
		$db->disconnect();
		return $sanPham;
	} else {
		$db->disconnect();
		return null;
	}
}

function getNhanHieuList()
{
	$db = new Database();
	$sql = "SELECT * FROM `nhanhieu`";
	$kq = mysqli_query($db->getConnection(), $sql);
	$arr = array();
	while ($row = mysqli_fetch_assoc($kq)) {
		$nhanHieu = new NhanHieu(
			$row['maNhanHieu'],
			$row['tenNhanHieu']
		);
		$arr[] = $nhanHieu;
	}
	$db->disconnect();
	return $arr;
}

// Lấy mã sản phẩm dự kiến của sản phẩm sắp tạo
function getNewestMaSanPham()
{
	$db = new Database();
	$sql = "SELECT max(maSanPham) + 1 as 'maSanPham' FROM `sanpham`";
	$kq = mysqli_query($db->getConnection(), $sql);
	$row = mysqli_fetch_assoc($kq);
	$maSanPham = $row['maSanPham'];
	$db->disconnect();
	return $maSanPham;
}

function getNewestMaNCC()
{
	$db = new Database();
	$sql = "SELECT max(maNCC) + 1 as 'maNCC' FROM `nhacungcap`";
	$kq = mysqli_query($db->getConnection(), $sql);
	$row = mysqli_fetch_assoc($kq);
	$maNCC = $row['maNCC'];
	$db->disconnect();
	return $maNCC;
}

function getNewestMaPhieuNhap()
{
	$db = new Database();
	$sql = "SELECT max(maPhieuNhap) + 1 as 'maPhieuNhap' FROM `phieunhap`";
	$kq = mysqli_query($db->getConnection(), $sql);
	$row = mysqli_fetch_assoc($kq);
	$maPhieuNhap = $row['maPhieuNhap'];
	$db->disconnect();
	return $maPhieuNhap;
}

function getNewestMaChiTietPhieuNhap()
{
	$db = new Database();
	$sql = "SELECT max(maChiTietPhieuNhap) + 1 as 'maChiTietPhieuNhap' FROM `chitietphieunhap`";
	$kq = mysqli_query($db->getConnection(), $sql);
	$row = mysqli_fetch_assoc($kq);
	$maChiTietPhieuNhap = $row['maChiTietPhieuNhap'];
	$db->disconnect();
	return $maChiTietPhieuNhap;
}

function getNewestMaPhieuXuat()
{
	$db = new Database();
	$sql = "SELECT max(maPhieuXuat) + 1 as 'maPhieuXuat' FROM `phieuxuat`";
	$kq = mysqli_query($db->getConnection(), $sql);
	$row = mysqli_fetch_assoc($kq);
	$maPhieuXuat = $row['maPhieuXuat'];
	$db->disconnect();
	return $maPhieuXuat;
}

function getNewestMaChiTietPhieuXuat()
{
	$db = new Database();
	$sql = "SELECT max(maChiTietPhieuXuat) + 1 as 'maChiTietPhieuXuat' FROM `chitietphieuxuat`";
	$kq = mysqli_query($db->getConnection(), $sql);
	$row = mysqli_fetch_assoc($kq);
	$maChiTietPhieuXuat = $row['maChiTietPhieuXuat'];
	$db->disconnect();
	return $maChiTietPhieuXuat;
}

function getTaiKhoanBy($taiKhoan)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `taikhoan` WHERE taiKhoan = '$taiKhoan'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$taiKhoan = new TaiKhoan(
			$row['taiKhoan'],
			$row['matKhau'],
			$row['maNhomQuyen']
		);
		$db->disconnect();
		return $taiKhoan;
	} else {
		$db->disconnect();
		return null;
	}
}

function getNhanVienById($id)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `nhanvien` WHERE maNhanVien = '$id'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$nhanVien = new NhanVien(
			$row['maNhanVien'],
			$row['cmnd'],
			$row['hoTen'],
			$row['gioiTinh'],
			$row['ngaySinh'],
			$row['diaChi'],
			$row['sdt'],
			$row['danToc'],
			$row['email'],
			$row['maChucVu'],
			$row['maPhong'],
			$row['avatar']
		);
		$db->disconnect();
		return $nhanVien;
	} else {
		$db->disconnect();
		return null;
	}
}

function getChucVuById($id)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `chucvu` WHERE maChucVu = '$id'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$chucVu = new ChucVu(
			$row['maChucVu'],
			$row['tenChucVu']
		);
		$db->disconnect();
		return $chucVu;
	} else {
		$db->disconnect();
		return null;
	}
}

function tonTaiPhieuNhapCuaNhanVienTrongNgay($maNhanVien, $ngayNhap)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `phieunhap` WHERE maNhanVien = $maNhanVien AND ngayNhap = '$ngayNhap'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$phieuNhap = new PhieuNhap(
			$row['maPhieuNhap'],
			$row['maNhanVien'],
			$row['ngayNhap'],
			$row['maNhaCungCap'],
			$row['tongTien'],
			$row['tongSoLuong'],
			$row['trangThai']
		);
		$db->disconnect();
		return $phieuNhap;
	} else {
		$db->disconnect();
		return null;
	}
}

function tonTaiPhieuXuatCuaNhanVienTrongNgay($maNhanVien, $ngayXuat)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `phieuxuat` WHERE maNhanVien = $maNhanVien AND ngayXuat = '$ngayXuat'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$phieuXuat = new PhieuXuat(
			$row['maPhieuXuat'],
			$row['maKhachHang'],
			$row['maNhanVien'],
			$row['tongTien'],
			$row['ngayXuat'],
			$row['tongSoLuong'],
			$row['trangThai'],
			$row['lyDo'],
			$row['maNCC'],
			$row['maKho']
		);
		$db->disconnect();
		return $phieuXuat;
	} else {
		$db->disconnect();
		return null;
	}
}

function getPhieuNhapById($id)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `phieunhap` WHERE maPhieuNhap = $id");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$phieuNhap = new PhieuNhap(
			$row['maPhieuNhap'],
			$row['maNhanVien'],
			$row['ngayNhap'],
			$row['maNhaCungCap'],
			$row['tongTien'],
			$row['tongSoLuong'],
			$row['trangThai']
		);
		$db->disconnect();
		return $phieuNhap;
	} else {
		$db->disconnect();
		return null;
	}
}

function getPhieuNhapList()
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `phieunhap`");
	$phieuNhapList = array();
	while ($row = mysqli_fetch_assoc($kq)) {
		$phieuNhap = new PhieuNhap(
			$row['maPhieuNhap'],
			$row['maNhanVien'],
			$row['ngayNhap'],
			$row['maNhaCungCap'],
			$row['tongTien'],
			$row['tongSoLuong'],
			$row['trangThai']
		);
		$phieuNhapList[] = $phieuNhap;
	}
	$db->disconnect();
	return $phieuNhapList;
}

function isExistMaPhieuNhap($maPhieuNhap)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `phieunhap` WHERE maPhieuNhap = $maPhieuNhap");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$db->disconnect();
		return true;
	} else {
		$db->disconnect();
		return false;
	}
}

function isExistMaPhieuXuat($maPhieuXuat)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `phieuxuat` WHERE maPhieuXuat = $maPhieuXuat");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$db->disconnect();
		return true;
	} else {
		$db->disconnect();
		return false;
	}
}

function isExistMaSizeOfMaSanPham($maSanPham, $maSize)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `soluong` WHERE maSanPham = '$maSanPham' AND maSize = '$maSize'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$db->disconnect();
		return true;
	} else {
		$db->disconnect();
		return false;
	}
}

function getChiTietPhieuNhapListByMaPhieuNhap($maPhieuNhap)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `chitietphieunhap` WHERE maPhieuNhap = '$maPhieuNhap'");
	$chiTietList = array();
	while ($row = mysqli_fetch_assoc($kq)) {
		$chiTiet = new ChiTietPhieuNhap(
			$row['maChiTietPhieuNhap'],
			$row['maPhieuNhap'],
			$row['maSanPham'],
			$row['soLuong'],
			$row['giaNhap'],
			$row['maSize']
		);
		$chiTietList[] = $chiTiet;
	}
	$db->disconnect();
	return $chiTietList;
}

function getChiTietPhieuNhapByMaChiTietPhieuNhap($maChiTietPhieuNhap)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `chitietphieunhap` WHERE maChiTietPhieuNhap = '$maChiTietPhieuNhap'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$chiTiet = new ChiTietPhieuNhap(
			$row['maChiTietPhieuNhap'],
			$row['maPhieuNhap'],
			$row['maSanPham'],
			$row['soLuong'],
			$row['giaNhap'],
			$row['maSize']
		);
		$db->disconnect();
		return $chiTiet;
	} else
		return null;
}

function getPhieuXuatById($id)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `phieuxuat` WHERE maPhieuXuat = $id");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$phieuXuat = new PhieuXuat(
			$row['maPhieuXuat'],
			$row['maKhachHang'],
			$row['maNhanVien'],
			$row['tongTien'],
			$row['ngayXuat'],
			$row['tongSoLuong'],
			$row['trangThai'],
			$row['lyDo'],
			$row['maNCC'],
			$row['maKho']
		);
		$db->disconnect();
		return $phieuXuat;
	} else {
		$db->disconnect();
		return null;
	}
}

function getPhieuXuatList()
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `phieuxuat`");
	$phieuXuatList = array();
	while ($row = mysqli_fetch_assoc($kq)) {
		$phieuXuat = new PhieuXuat(
			$row['maPhieuXuat'],
			$row['maKhachHang'],
			$row['maNhanVien'],
			$row['tongTien'],
			$row['ngayXuat'],
			$row['tongSoLuong'],
			$row['trangThai'],
			$row['lyDo'],
			$row['maNCC'],
			$row['maKho']
		);
		$phieuXuatList[] = $phieuXuat;
	}
	$db->disconnect();
	return $phieuXuatList;
}

function getChiTietPhieuXuatListByMaPhieuXuat($maPhieuXuat)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `chitietphieuxuat` WHERE maPhieuXuat = '$maPhieuXuat'");
	$chiTietList = array();
	while ($row = mysqli_fetch_assoc($kq)) {
		$chiTiet = new ChiTietPhieuXuat(
			$row['maChiTietPhieuXuat'],
			$row['maPhieuXuat'],
			$row['maSanPham'],
			$row['maSize'],
			$row['soLuong'],
			$row['giaBan']
		);
		$chiTietList[] = $chiTiet;
	}
	$db->disconnect();
	return $chiTietList;
}

function getChiTietPhieuXuatByMaChiTietPhieuXuat($maChiTietPhieuXuat)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `chitietphieuxuat` WHERE maChiTietPhieuXuat = '$maChiTietPhieuXuat'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$chiTiet = new ChiTietPhieuXuat(
			$row['maChiTietPhieuXuat'],
			$row['maPhieuXuat'],
			$row['maSanPham'],
			$row['maSize'],
			$row['soLuong'],
			$row['giaBan']
		);
		$db->disconnect();
		return $chiTiet;
	} else
		return null;
}

function getNhanHieuById($id)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `nhanhieu` WHERE maNhanHieu = '$id'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$nhanHieu = new NhanHieu(
			$row['maNhanHieu'],
			$row['tenNhanHieu']
		);
		$db->disconnect();
		return $nhanHieu;
	} else {
		$db->disconnect();
		return null;
	}
}

function displayNhanHieuOption()
{
	echo "<option value=\"all\" selected>Mặc định</option>";
	$nhanHieuList = getNhanHieuList();
	for ($i = 0; $i < count($nhanHieuList); $i++) {
		echo "<option value=\"" . $nhanHieuList[$i]->getMaNhanHieu() . "\">" . $nhanHieuList[$i]->getTenNhanHieu() . "</option>";
	}
}

/*
	Hàm chuyển đỗi chuỗi số thành tiền
	VD: 3000000
	Result => 3.000.000
*/
function changeMoney($moneyIn)
{
	$arr = array();
	$arr = str_split($moneyIn, 1);
	$count = 0;
	$temp = "";
	for ($i = count($arr) - 1; $i >= 0; $i--) {
		++$count;
		if ($count % 3 == 0 && $i > 0) {
			$temp .= $arr[$i];
			$temp .= ".";
			continue;
		}
		$temp .= $arr[$i];
	}
	// Đảo ngược chuỗi
	$moneyOut = "";
	$count = 0;
	$arr = str_split($temp, 1);
	for ($i = count($arr) - 1; $i >= 0; --$i) {
		$moneyOut .= $arr[$i];
		$count++;
	}
	return $moneyOut;
}

function changeMoneyToNum($money)
{
	$arr = explode(".", $money);
	$num = '';
	for ($i = 0; $i < count($arr); $i++) {
		$num .= $arr[$i];
	}
	return $num;
}

function hienThiSanPhamAdmin($list)
{
	$data = '';
	$productList = null;
	if ($list == null) {
		$productList = getProductList();
	} else {
		$productList = $list;
	}
	for ($i = 0; $i < count($productList); $i++) {
		$product = $productList[$i];
		if ($product->getTinhTrang() == DA_XOA)
			continue;
		$data .= '<tr>' .
			'<td>' . $product->getMaSanPham() . '</td>' .
			'<td>' .
			'<div class="product-img" style="background-color:#EDEAEB; width: 100px; height: 80px;  border-radius: 5px;">
				<img src="' . $product->getHinhAnh() . '" alt="" style="width:100%; height:100%; object-fit:contain;">
			  </div>' .
			'</td>' .
			'<td>' . $product->getTenSanPham() . '</td>' .
			'<td>' . changeMoney($product->getGiaCu()) . '₫</td>' .
			'<td>' . changeMoney($product->getGiaMoi()) . '₫</td>' .
			'<td>' . getNhanHieuById($product->getMaNhanHieu())->getTenNhanHieu() . '</td>' .
			'<td>Nam, thể thao</td>' .
			'<td>' .
			'<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#chitietsoluong" 
  onclick="getChiTietSoLuong(' . $product->getMaSanPham() . ')"></span>'
			. getSoLuongSanPham($product->getMaSanPham()) . '</button>' .
			'</td>' .
			'</tr>';
	}
	return $data;
}

function getKhoHangList() {
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `khohang`");
	$khoHangList = array();
	while ($row = mysqli_fetch_assoc($kq)) {
		$khoHang = new KhoHang(
			$row['maKho'],
			$row['ten'],
			$row['diaChi'],
			$row['sdt'],
			$row['trangThai']
		);
		$khoHangList[] = $khoHang;
	}
	$db->disconnect();
	return $khoHangList;
}

function getKhoHangById($id)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `khohang` WHERE maKho = '" . $id . "'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$khoHang = new KhoHang(
			$row['maKho'],
			$row['ten'],
			$row['diaChi'],
			$row['sdt'],
			$row['trangThai']
		);
		$db->disconnect();
		return $khoHang;
	} else {
		$db->disconnect();
		return null;
	}
}

function getKhachHangList() {
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `khohang`");
	$khoHangList = array();
	while ($row = mysqli_fetch_assoc($kq)) {
		$khachHang = new KhachHang(
			$row['id'],
			$row['ten'],
			$row['diaChi'],
			$row['sdt']
		);
		$khachHangList[] = $khachHang;
	}
	$db->disconnect();
	return $khoHangList;
}

function getKhachHangBySDT($sdt)
{
	$db = new Database();
	$kq = mysqli_query($db->getConnection(), "SELECT * FROM `khachhang` WHERE sdt = '" . $sdt . "'");
	$row = mysqli_fetch_assoc($kq);
	if ($row) {
		$khachHang = new KhachHang(
			$row['id'],
			$row['ten'],
			$row['diaChi'],
			$row['sdt']
		);
		$db->disconnect();
		return $khachHang;
	} else {
		$db->disconnect();
		return null;
	}
}

function getNewestMaKhachHang()
{
	$db = new Database();
	$sql = "SELECT max(id) + 1 as 'id' FROM `khachhang`";
	$kq = mysqli_query($db->getConnection(), $sql);
	$row = mysqli_fetch_assoc($kq);
	$id = $row['id'];
	$db->disconnect();
	return $id;
}

function isExistSDTKhachHang($sdt)
{
	$db = new Database();
	$sql = "SELECT * FROM `khachhang` WHERE sdt = '" . $sdt . "'";
	$kq = mysqli_query($db->getConnection(), $sql);
	$row = mysqli_fetch_assoc($kq);
	if (is_null($row)) {
		$db->disconnect();
		return false;
	} else {
		$db->disconnect();
		return true;
	}
}