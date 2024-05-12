<?php
class KhoHang {
    private $maKho;
    private $ten;
    private $diaChi;
    private $sdt;
    private $trangThai;

    function __construct($maKho, $ten, $diaChi, $sdt, $trangThai) {
        $this->maKho = $maKho;
        $this->ten = $ten;
        $this->diaChi = $diaChi;
        $this->sdt = $sdt;
        $this->trangThai = $trangThai;
    }

    public function setMaKho($maKho) {
        $this->maKho = $maKho;
    }

    public function getMaKho() {
        return $this->maKho;
    }

    public function setTen($ten) {
        $this->ten = $ten;
    }

    public function getTen() {
        return $this->ten;        
    }

    public function setDiaChi($diaChi) {
        $this->diaChi = $diaChi;
    }

    public function getDiaChi() {
        return $this->diaChi;
    }

    public function setSDT($sdt) {
        $this->sdt = $sdt;        
    }

    public function getSDT() {
        return $this->sdt;
    }

    public function setTrangThai($trangThai) {
        $this->trangThai = $trangThai;
    }

    public function getTrangThai() {
        return $this->trangThai;
    }
}