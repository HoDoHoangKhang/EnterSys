<?php
class PhieuXuat
{
    private $maPhieuXuat;
    private $maKhachHang;
    private $maNhanVien;
    private $tongTien;
    private $ngayXuat;
    private $tongSoLuong;
    private $trangThai;
    private $lyDo;
    private $maNCC;
    private $maKho;

    function __construct($maPhieuXuat, $maKhachHang, $maNhanVien, $tongTien, $ngayXuat, $tongSoLuong, $trangThai, $lyDo, $maNCC, $maKho)
    {
        $this->maPhieuXuat = $maPhieuXuat;
        $this->maKhachHang = $maKhachHang;
        $this->maNhanVien = $maNhanVien;
        $this->tongTien = $tongTien;
        $this->ngayXuat = $ngayXuat;
        $this->tongSoLuong = $tongSoLuong;
        $this->trangThai = $trangThai;
        $this->lyDo = $lyDo;
        $this->maNCC = $maNCC;
        $this->maKho = $maKho;
    }

    public function setMaPhieuXuat($maPhieuXuat)
    {
        $this->maPhieuXuat = $maPhieuXuat;
    }

    public function getMaPhieuXuat()
    {
        return $this->maPhieuXuat;
    }

    public function setMaKhachHang($maKhachHang)
    {
        $this->maKhachHang = $maKhachHang;
    }

    public function getMaKhachHang()
    {
        return $this->maKhachHang;
    }

    public function setMaNhanVien($maNhanVien)
    {
        $this->maNhanVien = $maNhanVien;
    }

    public function getMaNhanVien()
    {
        return $this->maNhanVien;
    }

    public function setTongTien($tongTien)
    {
        $this->tongTien = $tongTien;
    }

    public function getTongTien()
    {
        return $this->tongTien;
    }

    public function setNgayXuat($ngayXuat)
    {
        $this->ngayXuat = $ngayXuat;
    }

    public function getNgayXuat()
    {
        return $this->ngayXuat;
    }

    public function setTongSoLuong($tongSoLuong) {
        $this->tongSoLuong = $tongSoLuong;
    }

    public function getTongSoLuong() {
        return $this->tongSoLuong;
    }

    public function setTrangThai($trangThai) {
        $this->trangThai = $trangThai;
    }

    public function getTrangThai() {
        return $this->trangThai;
    }

    public function setMaNCC($maNCC) {
        $this->maNCC = $maNCC;
    }

    public function setLyDo($lyDo) {
        $this->lyDo = $lyDo;
    }

    public function getLyDo() {
        return $this->lyDo;
    }

    public function getMaNCC() {
        return $this->maNCC;
    }

    public function setMaKho($maKho) {
        $this->maKho = $maKho;
    }

    public function getMaKho() {
        return $this->maKho;
    }
}

