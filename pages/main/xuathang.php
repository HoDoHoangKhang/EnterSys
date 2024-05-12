<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="row" style="justify-content: space-between;">
          <h2 class="mb-2 page-title">Danh sách phiếu xuất</h2>
        </div>
        <div class="row my-4">
          <!-- Small table -->
          <div class="col-md-12">
            <div class="card shadow">
              <div class="card-body">
                <!-- table -->
                <table class="table datatables" id="dataTable-1">
                  <thead>
                    <tr>
                      <th>Mã đơn hàng</th>
                      <th>Mã khách hàng</th>
                      <th>Mã nhân viên</th>
                      <th>Ngày xuất</th>
                      <th>Số lượng</th>
                      <th>Tổng tiền</th>
                      <th>Trạng thái</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    hienThiDanhSachPhieuXuat();
                    ?>
                    <!-- <tr>
                      <td>1</td>
                      <td>
                          23
                      </td>
                      <td>43</td>
                      <td>02/03/2003</td>
                      <td>123</td>
                      <td>30.000.000</td>
                      <td>Đang xử lý</td>
                      <td><button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="text-muted sr-only">Action</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" data-toggle="modal"
                                                        data-target="#chitietphieunhap" href="#">
                                                        Chi tiết
                                                    </a>                          <a class="dropdown-item" href="#">Đã xác nhận</a>
                          <a class="dropdown-item" href="#">Hủy đơn</a>
                          </div>
                      </td>
                    </tr> -->
                  </tbody>
                </table>
              </div>
            </div>
          </div> <!-- simple table -->
        </div> <!-- end section -->
      </div> <!-- .col-12 -->
    </div> <!-- .row -->
  </div> <!-- .container-fluid -->
  <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="list-group list-group-flush my-n3">
            <div class="list-group-item bg-transparent">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="fe fe-box fe-24"></span>
                </div>
                <div class="col">
                  <small><strong>Package has uploaded successfull</strong></small>
                  <div class="my-0 text-muted small">Package is zipped and uploaded</div>
                  <small class="badge badge-pill badge-light text-muted">1m ago</small>
                </div>
              </div>
            </div>
            <div class="list-group-item bg-transparent">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="fe fe-download fe-24"></span>
                </div>
                <div class="col">
                  <small><strong>Widgets are updated successfull</strong></small>
                  <div class="my-0 text-muted small">Just create new layout Index, form, table</div>
                  <small class="badge badge-pill badge-light text-muted">2m ago</small>
                </div>
              </div>
            </div>
            <div class="list-group-item bg-transparent">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="fe fe-inbox fe-24"></span>
                </div>
                <div class="col">
                  <small><strong>Notifications have been sent</strong></small>
                  <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo</div>
                  <small class="badge badge-pill badge-light text-muted">30m ago</small>
                </div>
              </div> <!-- / .row -->
            </div>
            <div class="list-group-item bg-transparent">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="fe fe-link fe-24"></span>
                </div>
                <div class="col">
                  <small><strong>Link was attached to menu</strong></small>
                  <div class="my-0 text-muted small">New layout has been attached to the menu</div>
                  <small class="badge badge-pill badge-light text-muted">1h ago</small>
                </div>
              </div>
            </div> <!-- / .row -->
          </div> <!-- / .list-group -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade modal-shortcut modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="defaultModalLabel">Shortcuts</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body px-5">
          <div class="row align-items-center">
            <div class="col-6 text-center">
              <div class="squircle bg-success justify-content-center">
                <i class="fe fe-cpu fe-32 align-self-center text-white"></i>
              </div>
              <p>Control area</p>
            </div>
            <div class="col-6 text-center">
              <div class="squircle bg-primary justify-content-center">
                <i class="fe fe-activity fe-32 align-self-center text-white"></i>
              </div>
              <p>Activity</p>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6 text-center">
              <div class="squircle bg-primary justify-content-center">
                <i class="fe fe-droplet fe-32 align-self-center text-white"></i>
              </div>
              <p>Droplet</p>
            </div>
            <div class="col-6 text-center">
              <div class="squircle bg-primary justify-content-center">
                <i class="fe fe-upload-cloud fe-32 align-self-center text-white"></i>
              </div>
              <p>Upload</p>
            </div>
          </div>
          <div class="row align-items-center">
            <div class="col-6 text-center">
              <div class="squircle bg-primary justify-content-center">
                <i class="fe fe-users fe-32 align-self-center text-white"></i>
              </div>
              <p>Users</p>
            </div>
            <div class="col-6 text-center">
              <div class="squircle bg-primary justify-content-center">
                <i class="fe fe-settings fe-32 align-self-center text-white"></i>
              </div>
              <p>Settings</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="chitietphieuxuat" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="width: 800px;">
        <div class="modal-header">
          <h5 class="modal-title" id="varyModalLabel">Chi tiết phiếu xuất</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-8">
          <div class="card shadow mb-8">
            <form class="needs-validation" novalidate>
              <div class="card shadow">
                <table class="table datatables" id="dataTable-1">
                  <thead>
                    <tr>
                      <th style="width: 300px;">Tên SP</th>
                      <th>Size</th>
                      <th>Số lượng</th>
                      <th>Giá bán</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div> <!-- /.card -->
            </form>
          </div> <!-- /.card -->
        </div>
      </div>
    </div> <!-- new event modal -->
  </div>
</main> <!-- main -->
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
<script>
  $('#dataTable-1').DataTable({
    autoWidth: true,
    "lengthMenu": [
      [16, 32, 64, -1],
      [16, 32, 64, "All"]
    ]
  });
</script>
<script src="js/apps.js"></script>
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
  function getChiTietPhieuXuat(maPhieuXuat) {
    var xml = new XMLHttpRequest();
    var request = "/HTTT-DN/pages/main/xuathang-list.php?maPhieuXuat=" + maPhieuXuat;
    xml.open("GET", request, true);
    xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xml.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("chitietphieuxuat").innerHTML = this.responseText;
      }
    };
    xml.send();
  }
</script>

<?php
function hienThiDanhSachPhieuXuat()
{
  require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/action.php');

  $phieuXuatList = getPhieuXuatList();
  for ($i = 0; $i < count($phieuXuatList); $i++) {
    $phieuXuat = $phieuXuatList[$i];
    $nhanVien = getNhanVienById($phieuXuat->getMaNhanVien());
    $trangThai = "";
    if ($phieuXuat->getTrangThai() == DA_XAC_NHAN)
      $trangThai = "Đã xác nhận";
    else if ($phieuXuat->getTrangThai() == DANG_XU_LY)
      $trangThai = "Đang xử lý";
    else
      $trangThai = "Đã hủy";
    echo '
        <tr>
          <td>' . $phieuXuat->getMaPhieuXuat() . '</td>
          <td>' . $phieuXuat->getMaKhachHang() . '</td>
          <td>' . $nhanVien->getMaNhanVien() . '</td>
          <td>' . $phieuXuat->getNgayXuat() . '</td>
          <td>' . $phieuXuat->getTongSoLuong() . '</td>
          <td>' . changeMoney($phieuXuat->getTongTien()) . '₫</td>
          <td>' . $trangThai . '</td>
          <td>
            <button class="btn btn-sm dropdown-toggle more-horizontal" type="button" data-toggle="dropdown" 
            aria-haspopup="true" aria-expanded="false">
              <span class="text-muted sr-only">Action</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" data-toggle="modal"
                data-target="#chitietphieuxuat" href="#" onclick="getChiTietPhieuXuat(' . $phieuXuat->getMaPhieuXuat() . ')">Chi tiết</a>                          
              <a class="dropdown-item"  href="/HTTT-DN/pages/main/xuathang-edittrangthai.php?maPhieuXuat=' . $phieuXuat->getMaPhieuXuat() . '&trangThai=1">Đã xác nhận</a>
              <a class="dropdown-item" href="/HTTT-DN/pages/main/xuathang-edittrangthai.php?maPhieuXuat=' . $phieuXuat->getMaPhieuXuat() . '&trangThai=2">Hủy đơn</a>
            </div>
          </td>
        </tr>';
  }
}
?>