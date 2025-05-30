<?php
require_once './object/database.php';

$row = new Database;
$arr = $row->executeQuery('select distinct nv.maNhanVien, trangthai, avatar, hoTen, gioiTinh, ngaySinh, diaChi, tenPhong, tenChucVu, ngayKetThuc, luongCoBan from chucvu cv join nhanvien nv on cv.maChucVu=nv.maChucVu join phongban pb on pb.maPhong=nv.maPhong join hopdong hd on hd.maNhanVien=nv.maNhanVien order by nv.maNhanVien asc');
$thangChamCong = date('m', time()) - 1;
$getNhanVienChamCong = $row->executeQuery("SELECT c.maNhanVien  FROM `chamcong` c JOIN nhanvien nv on c.maNhanVien = nv.maNhanVien WHERE thangChamCong = $thangChamCong and namChamCong = 2024");
?>

<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="row" style="justify-content: space-between;">
          <h2 class="mb-2 page-title">Chấm công</h2>

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
                      <th>Mã</th>
                      <th>Avatar</th>
                      <th>Tên</th>
                      <th>Giới tính</th>
                      <th>Ngày sinh</th>
                      <th>Địa chỉ</th>
                      <th>Phòng ban</th>
                      <th>Chức vụ</th>
                      <th>Kết thúc hợp đồng</th>
                      <th>Lương cơ bản</th>
                      <th>Trạng thái</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($arr as $element) {
                      $maNV = $element['maNhanVien'];
                      if ($element['trangthai'] == '1') {
                    ?>
                        <tr>
                          <td class="manv" manv="<?php echo $maNV ?>"><?php echo $maNV ?></td>
                          <td>
                            <img src="assets/avatars/<?php echo $element['avatar'] ?>" alt="" style="width: 50px; height: 50px; border-radius: 1000px;">
                          </td>
                          <td><?php echo $element['hoTen'] ?></td>
                          <td><?php echo $element['gioiTinh'] ?></td>
                          <td><?php echo $element['ngaySinh'] ?></td>
                          <td><?php echo $element['diaChi'] ?></td>
                          <td><?php echo $element['tenPhong'] ?></td>
                          <td><?php echo $element['tenChucVu'] ?></td>
                          <td><?php echo $element['ngayKetThuc'] ?></td>
                          <td><?php echo $element['luongCoBan'] ?></td>
                          <td>
                            <?php
                            $str = "<span style='color: red;'>Chưa chấm công</span>";
                            if(isset($getNhanVienChamCong) && is_array($getNhanVienChamCong)) {
                            foreach ($getNhanVienChamCong as $nvcc) {
                            ?>
                              <?php if ($nvcc['maNhanVien'] == $element['maNhanVien']) $str = "<span style='color: green; font-weight: 900;'>Đã chấm công</span>";
                              ?>
                            <?php
                            }
                          }
                            echo $str
                            ?>
                          </td>
                          <td>
                            <?php
                            $str = "<button class='btn btn-sm dropdown-toggle more-horizontal' type='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <span class='text-muted sr-only'>Action</span>
                          </button>
                          <div class='dropdown-menu dropdown-menu-right'>
                            <a class='dropdown-item' href='index.php?page=chamcongnhanvien&manv=$maNV'>Chấm công</a>
                          </div>";
                          if(isset($getNhanVienChamCong) && is_array($getNhanVienChamCong)) {
                            foreach ($getNhanVienChamCong as $nvcc) {
                            ?>
                              <?php if ($nvcc['maNhanVien'] == $element['maNhanVien']) $str = "";
                              ?>
                            <?php
                            }
                          }
                            echo $str
                            ?>
                          </td>
                        </tr>
                    <?php
                      }
                    }
                    ?>

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