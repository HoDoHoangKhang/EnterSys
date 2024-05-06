<?php
$con = new mysqli('localhost', 'root', '', 'htttdn');

$data = [];

if (isset($_GET['month'])) {
    $selectedTime = $_GET['month'];
    $selectedYear = substr($selectedTime, 0, 4);
    $selectedMonth = substr($selectedTime, 5, 2);
    
    $sql = "
    SELECT
    ngay,
    SUM(tong_san_pham_nhap) AS TongSanPhamNhap,
    SUM(tong_san_pham_xuat) AS TongSanPhamXuat
FROM
    (SELECT
        DATE(pn.ngayNhap) AS ngay,
        SUM(ctpn.soLuong) AS tong_san_pham_nhap,
        0 AS tong_san_pham_xuat
    FROM
        phieunhap pn
        JOIN chitietphieunhap ctpn ON pn.maPhieuNhap = ctpn.maPhieuNhap
    GROUP BY
        DATE(pn.ngayNhap)
    UNION ALL
    SELECT
        DATE(px.ngayXuat) AS ngay,
        0 AS tong_san_pham_nhap,
        SUM(ctpx.soLuong) AS tong_san_pham_xuat
    FROM
        phieuxuat px
        JOIN chitietphieuxuat ctpx ON px.maPhieuXuat = ctpx.maPhieuXuat
    GROUP BY
        DATE(px.ngayXuat)) AS tong_san_pham
WHERE ngay BETWEEN '$selectedYear-$selectedMonth-01' AND '$selectedYear-$selectedMonth-31'
GROUP BY ngay";
    } elseif(isset($_GET['quarter'])){
    $selectedTime = $_GET['quarter'];
    $selectedQuarter = $selectedTime[1];
    $selectedYear = $_GET['year'];

    echo $selectedQuarter;

    $startMonth = null;
    $endMonth = null;

    switch ($selectedQuarter) {
        case 1:
            $startMonth = 1;
            $endMonth = 3;
            break;
        case 2:
            $startMonth = 4;
            $endMonth = 6;
            break;
        case 3:
            $startMonth = 7;
            $endMonth = 9;
            break;
        case 4:
            $startMonth = 10;
            $endMonth = 12;
            break;
        default:
            throw new Exception('Invalid quarter number');
    }

    
    $sql = "
    SELECT
    ngay,
    SUM(tong_san_pham_nhap) AS TongSanPhamNhap,
    SUM(tong_san_pham_xuat) AS TongSanPhamXuat
FROM
    (SELECT
        DATE(pn.ngayNhap) AS ngay,
        SUM(ctpn.soLuong) AS tong_san_pham_nhap,
        0 AS tong_san_pham_xuat
    FROM
        phieunhap pn
        JOIN chitietphieunhap ctpn ON pn.maPhieuNhap = ctpn.maPhieuNhap
    GROUP BY
        DATE(pn.ngayNhap)
    UNION ALL
    SELECT
        DATE(px.ngayXuat) AS ngay,
        0 AS tong_san_pham_nhap,
        SUM(ctpx.soLuong) AS tong_san_pham_xuat
    FROM
        phieuxuat px
        JOIN chitietphieuxuat ctpx ON px.maPhieuXuat = ctpx.maPhieuXuat
    GROUP BY
        DATE(px.ngayXuat)) AS tong_san_pham
WHERE ngay BETWEEN '$selectedYear-$startMonth-01' AND '$selectedYear-$endMonth-31'
GROUP BY
    ngay;";
}else{
    $sql = "
    SELECT
    ngay,
    SUM(tong_san_pham_nhap) AS TongSanPhamNhap,
    SUM(tong_san_pham_xuat) AS TongSanPhamXuat
FROM
    (SELECT
        DATE(pn.ngayNhap) AS ngay,
        SUM(ctpn.soLuong) AS tong_san_pham_nhap,
        0 AS tong_san_pham_xuat
    FROM
        phieunhap pn
        JOIN chitietphieunhap ctpn ON pn.maPhieuNhap = ctpn.maPhieuNhap
    GROUP BY
        DATE(pn.ngayNhap)
    UNION ALL
    SELECT
        DATE(px.ngayXuat) AS ngay,
        0 AS tong_san_pham_nhap,
        SUM(ctpx.soLuong) AS tong_san_pham_xuat
    FROM
        phieuxuat px
        JOIN chitietphieuxuat ctpx ON px.maPhieuXuat = ctpx.maPhieuXuat
    GROUP BY
        DATE(px.ngayXuat)) AS tong_san_pham
GROUP BY
    ngay;";
}
$result = $con->query($sql);
    
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'ngay' => $row['ngay'],
        'tongSanPhamNhap' => $row['TongSanPhamNhap'],
        'tongSanPhamXuat' => $row['TongSanPhamXuat']
    ];
}
;

?>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="page-title">Thống kê nhập xuất sản phẩm</h2>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="m-2">
                            <form id="time-period-form" action="/" method="GET">
                                <select id="time-period" name="time-period" required>
                                    <option value="">Chọn hình thức thống kê</option>
                                    <option value="month">Theo tháng</option>
                                    <option value="quarter">Theo quý</option>
                                    <option value="year">Theo năm</option>
                                </select>

                                <div id="additional-inputs"></div>

                                <button type="submit" class="btn btn-primary my-2">Thống kê</button>
                            </form>
                        </div>
                        <div class="row my-4">
                            <div class="col-md-12">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <?php if($data) { ?>
                                        <?php
                                            if(isset($_GET['time-period'])) {
                                            if(isset($_GET['month'])) { echo "<h6>Tháng " . $selectedMonth . " - Năm " . $selectedYear ."</h6>";}
                                            elseif(isset($_GET['quarter'])) {echo "<h6>Quý " . $selectedQuarter . " - Năm " . $selectedYear ."</h6>"; }
                                            echo "<h4> Tổng số sản phẩm đã nhập: " . array_sum(array_column($data, 'tongSanPhamNhap')) . "</h4>";
                                            echo "<h4> Tổng số sản phẩm đã xuất: " . array_sum(array_column($data, 'tongSanPhamXuat')) . "</h4>";
                                        }
                                        ?>
                                        <!-- table -->
                                        <table class="table datatables" id="dataTable-1">
                                            <thead>
                                                <tr>
                                                    <th>Ngày</th>
                                                    <th>Tổng sản phẩm nhập</th>
                                                    <th>Tổng sản phẩm xuất</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach ($data as $row) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row['ngay'] . "</td>";
                                                        echo "<td>" . $row['tongSanPhamNhap'] . "</td>";
                                                        echo "<td>" . $row['tongSanPhamXuat'] . "</td>";
                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                        <?php } else { echo "<h2>Không có dữ liệu thỏa điều kiện!</h2>";} ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>

<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/simplebar.min.js"></script>
<script src='js/daterangepicker.js'></script>
<script src='js/jquery.stickOnScroll.js'></script>
<script src="js/tinycolor-min.js"></script>
<script src="js/config.js"></script>
<script src='js/jquery.dataTables.min.js'></script>
<script src='js/dataTables.bootstrap4.min.js'></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-56159088-1');
</script>

<script>
    $('#dataTable-1').DataTable(
        {
            autoWidth: true,
            "lengthMenu": [
                [16, 32, 64, -1],
                [16, 32, 64, "All"]
            ]
        });
</script>

<script>
    const timePeriodInput = document.getElementById('time-period');
    const additionalInputsContainer = document.getElementById('additional-inputs');
    const form = document.getElementById('time-period-form');

    timePeriodInput.addEventListener('change', function () {
        additionalInputsContainer.innerHTML = ''; // Clear previous inputs

        switch (this.value) {
            case 'month':
                additionalInputsContainer.innerHTML = '<input class="my-2 py-1" type="month" id="month" name="month" required>';
                break;
            case 'quarter':
                additionalInputsContainer.innerHTML = `
                    <select id="quarter" name="quarter" class="my-2 py-1" required>
                    <option value="">Chọn quý</option>
                    <option value="Q1">Qúy 1</option>
                    <option value="Q2">Qúy 2</option>
                    <option value="Q3">Qúy 3</option>
                    <option value="Q4">Qúy 4</option>
                    </select>
                    <input type="number" id="year" name="year" min="2000" max="2100" value="${new Date().getFullYear()}" placeholder="Năm">
                `;
                break;
            case 'year':
                // No additional inputs needed for 'year' option
                break;
            default:
                // No additional inputs needed if no option is selected
                break;
        }
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the form from submitting normally

        const formData = new FormData(this);
        const queryParams = new URLSearchParams(formData).toString();
        const url = `./index.php?page=thongkexuat&${queryParams}`;

        window.location.replace(url);
    });
</script>