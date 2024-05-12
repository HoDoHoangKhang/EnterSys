<?php
class KhachHang {
    private $id;
    private $ten;
    private $diaChi;
    private $sdt;

    function __construct($id, $ten, $diaChi, $sdt) {
        $this->id = $id;
        $this->ten = $ten;
        $this->diaChi = $diaChi;
        $this->sdt = $sdt;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
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
}