<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/action.php');

$taiKhoan = null;
if (isset($_SESSION['taiKhoan'])) {
  $taiKhoan = getTaiKhoanBy($_SESSION['taiKhoan']);
  if (strcmp($taiKhoan->getMaNhomQuyen(), QUAN_LY_KHO) != 0) {
    header('location:../HTTT-DN/index.php');
    echo "<script>alert('Bạn không có quyền vào trang này')</script>";
  }
} else {
  header('location:../HTTT-DN/index.php');
  echo "<cript>alert('Bạn không có quyền vào trang này')</script>";
}
$nhanVien = getNhanVienById($taiKhoan->getTaiKhoan());
$chucVu = getChucVuById($nhanVien->getMaChucVu());
$nhaCungCapList = getNhaCungCapList();
$khoList = getKhoHangList();
$phieuXuatMoi = tonTaiPhieuXuatCuaNhanVienTrongNgay($nhanVien->getMaNhanVien(), date("Y-m-d"));
$maPhieuXuatMoi = '';
if ($phieuXuatMoi != null) {
  $maPhieuXuatMoi = $phieuXuatMoi->getMaPhieuXuat();
} else {
  $maPhieuXuatMoi = getNewestMaPhieuXuat();
}

?>
<main role="main" class="main-content">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-12">
        <div id="back-to-prev-page">
          <a href="">
            <div class="icon"></div>
            <div class="title"></div>
          </a>
          <input name="submit-form-btn" id="submit-form-btn" type="submit" value="Lưu" style="margin-bottom: 20px;" onclick="luuPhieuXuat()">
        </div>
        <div class="card shadow">
          <div class="card-body p-5">
            <div class="row">
              <div class="col-12 text-center mb-4">
                <img src="./assets/images/logo.svg" class="navbar-brand-img brand-sm mx-auto mb-4" alt="...">
                <h2 class="mb-0 text-uppercase">Phiếu xuất</h2>
              </div>
              <div class="col-md-5" style="display: flex; gap: 30px; padding-top: 15px;">
                <div class="">
                  <p class="small text-muted text-uppercase mb-2">Người xuất kho</p>
                  <p class="mb-4">
                    <?php
                    echo '<strong>Mã NV: ' . $nhanVien->getMaNhanVien() . '</strong><br /> ' . $nhanVien->getHoTen() . '<br />' .
                      $chucVu->getTenChucVu() . ' <br /> ' . $nhanVien->getEmail() . ' <br /> ' . $nhanVien->getSDT() . '<br />';
                    ?>
                  </p>
                  <p>
                    <span class="small text-muted text-uppercase">Mã phiếu xuất #</span><br />
                    <strong id="maPhieuXuat"></strong>
                  </p>
                </div>
                <div class="">
                  <p class="small text-muted text-uppercase mb-2">MỤC ĐÍCH XUẤT KHO</p>
                  <input type="radio" id="red" name="mucdichxuatkho" value="trahangchonhacungcap" checked>
                  <label for="red">Trả hàng cho nhà cung cấp</label><br>

                  <input type="radio" id="blue" name="mucdichxuatkho" value="xuatchokhachhang">
                  <label for="blue">Xuất cho khách hàng</label><br>

                  <input type="radio" id="yellow" name="mucdichxuatkho" value="chuyenkhohang">
                  <label for="yellow">Chuyển đến kho khác</label><br>
                  <p class="small text-muted text-uppercase mb-2">NGƯỜI NHẬN</p>
                  <div class="mb-4">
                    <div class="trahangchonhacungcap">
                      <strong>
                        <select class="form-control select2" id="maNhaCungCap" name="maNhaCungCap" required onchange="getNhaCungCapInfo()">
                          <option value="" selected disabled hidden>Chọn nhà cung cấp</option>
                          <?php
                          for ($i = 0; $i < count($nhaCungCapList); $i++) {
                            echo '<option value="' . $nhaCungCapList[$i]->getId() . '">' .
                              $nhaCungCapList[$i]->getId() . ' - ' . $nhaCungCapList[$i]->getTen() . '</option>';
                          }
                          ?>
                        </select>
                      </strong>
                      <div id="nccInfo"></div>
                    </div>
                    <div class="xuatchokhachhang">
                      <div class="form-group" style="margin-bottom: 10pxpx;">
                        <label style="margin-bottom: 2px;">Tên khách hàng</label>
                        <input type="text" id="tenKhachHang" class="form-control" name="temKhachHang" value="">
                      </div>
                      <div class="form-group" style="margin-bottom: 10px;">
                        <label style="margin-bottom: 2px;">Địa chỉ</label>
                        <input type="text" id="diaChi" class="form-control" name="diaChi" value="">
                      </div>
                      <div class="form-group" style="margin-bottom: 2px;">
                        <label style="margin-bottom: 2px;">Số điện thoại</label>
                        <input type="text" id="sodienthoai" class="form-control" name="sodienthoai" value="">
                      </div>
                    </div>
                    <div class="chuyenkhohang">
                      <strong>
                        <select class="form-control select2" id="khoHang" name="khoHang" required onchange="getKhoHangInfo()">
                          <option value="" selected disabled hidden>Chọn Kho</option>
                          <?php
                          for ($i = 0; $i < count($khoList); $i++) {
                            echo '<option value="' . $khoList[$i]->getMaKho() . '">' .
                              $khoList[$i]->getMaKho() . ' - ' . $khoList[$i]->getTen() . '</option>';
                          }
                          ?>
                        </select>
                      </strong>
                      <div id="khoInfo"></div>
                    </div>
                  </div>
                  <p>
                    <small class="small text-muted text-uppercase">Ngày xuất</small><br />
                    <strong><?php echo date("Y-m-d"); ?></strong>
                  </p>
                </div>
              </div>
              <div class="col-md-7">
                <table class="table table-borderless table-striped" id="chiTietPhieuXuatTable">
                  <thead>
                    <tr>
                      <th scope="col">Mã</th>
                      <th scope="col">Sản phẩm</th>
                      <th scope="col">Size</th>
                      <th scope="col" class="text-right">Giá xuất</th>
                      <th scope="col" class="text-right">Số lượng</th>
                      <th scope="col" class="text-right">Thành tiền</th>
                    </tr>
                  </thead>
                  <tbody id="chiTietPhieuXuat"></tbody>
                </table>
                <div class="row mt-5">
                  <div class="col-md-12">
                    <div class="text-right mr-2" id="totalMoneyContainer">
                      <p class="mb-2 h6">
                        <span class="text-muted">Thành tiền : </span>
                        <strong id="tongTien">0₫</strong>
                      </p>
                    </div>
                  </div>
                </div> <!-- /.row -->
              </div>
            </div> <!-- /.row -->
          </div> <!-- /.card-body -->
        </div> <!-- /.card -->
        <div class="row" style="justify-content: space-between; margin-top: 30px;">
          <h2 class="mb-2 ml-3 page-title">Danh sách sản phẩm</h2>
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
                      <th>Ảnh</th>
                      <th>Tên</th>
                      <th>Giá cũ</th>
                      <th>Giá mới</th>
                      <th>Nhãn hiệu</th>
                      <th>Danh mục</th>
                      <th>Số lượng</th>
                      <th>Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    echo hienThiSanPham();
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
  <!-- new event modal -->
  <div class="modal fade" id="chitietsoluong" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="varyModalLabel">Chi tiết số lượng</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-4">
          <table class="table datatables" id="dataTable-1">
            <thead>
              <tr>
                <th>Kích thước</th>
                <th>Số lượng</th>
              </tr>
            </thead>
            <tbody class="chiTietSoLuong"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div> <!-- new event modal -->
  <!-- new event modal -->
  <div class="modal fade" id="nhapsanpham" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="width: 600px;">
        <div class="modal-header">
          <h5 class="modal-title" id="varyModalLabel">Phiếu xuất</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closePhieuNhapBtn">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body p-4">
          <div style="display: flex;">
            <table class="table datatables" id="dataTable-1">
              <thead>
                <tr>
                  <th style="width: 100px;">Kích thước</th>
                  <th>Số lượng</th>
                </tr>
              </thead>
              <tr>
                <td>30</td>
                <td>
                  <input class="form-control" id="30" type="number" name="30" min="0">
                </td>
              </tr>
              <tr>
                <td>31</td>
                <td>
                  <input class="form-control" id="31" type="number" name="31" min="0">
                </td>
              </tr>
              <tr>
                <td>32</td>
                <td>
                  <input class="form-control" id="32" type="number" name="32" min="0">
                </td>
              </tr>
              <tr>
                <td>33</td>
                <td>
                  <input class="form-control" id="33" type="number" name="33" min="0">
                </td>
              </tr>
              <tr>
                <td>34</td>
                <td>
                  <input class="form-control" id="34" type="number" name="34" min="0">
                </td>
              </tr>
              <tr>
                <td>35</td>
                <td>
                  <input class="form-control" id="35" type="number" name="35" min="0">
                </td>
              </tr>
              <tr>
                <td>36</td>
                <td>
                  <input class="form-control" id="36" type="number" name="36" min="0">
                </td>
              </tr>
              <tr>
                <td>37</td>
                <td>
                  <input class="form-control" id="37" type="number" name="37" min="0">
                </td>
              </tr>

              </tbody>
            </table>
            <table class="table datatables" id="dataTable-1">
              <thead>
                <tr>
                  <th style="width: 100px;">Kích thước</th>
                  <th>Số lượng</th>
                </tr>
              </thead>
              <tr>
                <td>38</td>
                <td>
                  <input class="form-control" id="38" type="number" name="38" min="0">
                </td>
              </tr>
              <tr>
                <td>39</td>
                <td>
                  <input class="form-control" id="39" type="number" name="39" min="0">
                </td>
              </tr>
              <tr>
                <td>40</td>
                <td>
                  <input class="form-control" id="40" type="number" name="40" min="0">
                </td>
              </tr>
              <tr>
                <td>41</td>
                <td>
                  <input class="form-control" id="41" type="number" name="41" min="0">
                </td>
              </tr>
              <tr>
                <td>42</td>
                <td>
                  <input class="form-control" id="42" type="number" name="42" min="0">
                </td>
              </tr>
              <tr>
                <td>43</td>
                <td>
                  <input class="form-control" id="43" type="number" name="43" min="0">
                </td>
              </tr>
              <tr>
                <td>44</td>
                <td>
                  <input class="form-control" id="44" type="number" name="44" min="0">
                </td>
              </tr>
              <tr id="giaXuatInput">
                <td style="color: #1B68FF;">Giá xuất </td>
                <td>
                  <input class="form-control" id="giaXuat" type="number" name="giaNhap" min="0">
                </td>
              </tr>
              </tbody>
            </table>
          </div>

          <div style="display: flex; justify-content: end;" id="nhapFormBtnContainer">
            <input class="btn btn-primary" type="button" value="Xuất" onclick="submitNhapForm()"></input>
          </div>
        </div>

      </div>
    </div>
  </div> <!-- new event modal -->
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
<script src='js/select2.min.js'></script>
<script>
  $('.select2').select2({
    theme: 'bootstrap4',
  });
  $('.select2-multi').select2({
    multiple: true,
    theme: 'bootstrap4',
  });
  // $('.drgpicker').daterangepicker({
  //     singleDatePicker: true,
  //     timePicker: false,
  //     showDropdowns: true,
  //     locale: {
  //         format: 'MM/DD/YYYY'
  //     }
  // });
  // $('.time-input').timepicker({
  //     'scrollDefault': 'now',
  //     'zindex': '9999' /* fix modal open */
  // });
  // /** date range picker */
  // if ($('.datetimes').length) {
  //     $('.datetimes').daterangepicker({
  //         timePicker: true,
  //         startDate: moment().startOf('hour'),
  //         endDate: moment().startOf('hour').add(32, 'hour'),
  //         locale: {
  //             format: 'M/DD hh:mm A'
  //         }
  //     });
  // }
  // var start = moment().subtract(29, 'days');
  // var end = moment();

  // function cb(start, end) {
  //     $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
  // }
  // $('#reportrange').daterangepicker({
  //     startDate: start,
  //     endDate: end,
  //     ranges: {
  //         'Today': [moment(), moment()],
  //         'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
  //         'Last 7 Days': [moment().subtract(6, 'days'), moment()],
  //         'Last 30 Days': [moment().subtract(29, 'days'), moment()],
  //         'This Month': [moment().startOf('month'), moment().endOf('month')],
  //         'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
  //     }
  // }, cb);
  // cb(start, end);
  // $('.input-placeholder').mask("00/00/0000", {
  //     placeholder: "__/__/____"
  // });
  // $('.input-zip').mask('00000-000', {
  //     placeholder: "____-___"
  // });
  // $('.input-money').mask("#.##0,00", {
  //     reverse: true
  // });
  // $('.input-phoneus').mask('(000) 000-0000');
  // $('.input-mixed').mask('AAA 000-S0S');
  // $('.input-ip').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
  //     translation: {
  //         'Z': {
  //             pattern: /[0-9]/,
  //             optional: true
  //         }
  //     },
  //     placeholder: "___.___.___.___"
  // });
  // // editor
  // var editor = document.getElementById('editor');
  // if (editor) {
  //     var toolbarOptions = [
  //         [{
  //             'font': []
  //         }],
  //         [{
  //             'header': [1, 2, 3, 4, 5, 6, false]
  //         }],
  //         ['bold', 'italic', 'underline', 'strike'],
  //         ['blockquote', 'code-block'],
  //         [{
  //                 'header': 1
  //             },
  //             {
  //                 'header': 2
  //             }
  //         ],
  //         [{
  //                 'list': 'ordered'
  //             },
  //             {
  //                 'list': 'bullet'
  //             }
  //         ],
  //         [{
  //                 'script': 'sub'
  //             },
  //             {
  //                 'script': 'super'
  //             }
  //         ],
  //         [{
  //                 'indent': '-1'
  //             },
  //             {
  //                 'indent': '+1'
  //             }
  //         ], // outdent/indent
  //         [{
  //             'direction': 'rtl'
  //         }], // text direction
  //         [{
  //                 'color': []
  //             },
  //             {
  //                 'background': []
  //             }
  //         ], // dropdown with defaults from theme
  //         [{
  //             'align': []
  //         }],
  //         ['clean'] // remove formatting button
  //     ];
  //     var quill = new Quill(editor, {
  //         modules: {
  //             toolbar: toolbarOptions
  //         },
  //         theme: 'snow'
  //     });
  // }
  // // Example starter JavaScript for disabling form submissions if there are invalid fields
  // (function() {
  //     'use strict';
  //     window.addEventListener('load', function() {
  //         // Fetch all the forms we want to apply custom Bootstrap validation styles to
  //         var forms = document.getElementsByClassName('needs-validation');
  //         // Loop over them and prevent submission
  //         var validation = Array.prototype.filter.call(forms, function(form) {
  //             form.addEventListener('submit', function(event) {
  //                 if (form.checkValidity() === false) {
  //                     event.preventDefault();
  //                     event.stopPropagation();
  //                 }
  //                 form.classList.add('was-validated');
  //             }, false);
  //         });
  //     }, false);
  // })();
</script>
<script>
  var uptarg = document.getElementById('drag-drop-area');
  if (uptarg) {
    var uppy = Uppy.Core().use(Uppy.Dashboard, {
      inline: true,
      target: uptarg,
      proudlyDisplayPoweredByUppy: false,
      theme: 'dark',
      width: 770,
      height: 210,
      plugins: ['Webcam']
    }).use(Uppy.Tus, {
      endpoint: 'https://master.tus.io/files/'
    });
    uppy.on('complete', (result) => {
      console.log('Upload complete! We’ve uploaded these files:', result.successful)
    });
  }
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
  function getChiTietSoLuong(maSanPham) {
    var xml = new XMLHttpRequest();
    var request = "/HTTT-DN/pages/main/admin-sanpham-chitietsoluong.php?maSanPham=" + maSanPham;
    xml.open("GET", request, true);
    xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xml.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.querySelectorAll("#dataTable-1 .chiTietSoLuong")[0].innerHTML = this.responseText;
      }
    };
    xml.send();
  }

  function getNhaCungCapInfo() {
    var ncc = document.getElementById("maNhaCungCap").value;
    var xhr = new XMLHttpRequest();
    var request = "/HTTT-DN/pages/main/xuatkho-taophieuxuat-nccinfo.php?maNhaCungCap=" + ncc;
    xhr.open("GET", request, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.status === 200) {
        if (xhr.responseText.trim() !== "") {
          var response = JSON.parse(xhr.responseText);
          document.getElementById("nccInfo").innerHTML = response.nccInfo;
          document.getElementById("maPhieuXuat").innerHTML = response.maPhieuXuat;
        }
      } else {
        console.error('Request failed: ' + xhr.status);
      }
    };
    xhr.send();
  }

  function getKhoHangInfo() {
    var khoHang = document.getElementById("khoHang").value;
    var xhr = new XMLHttpRequest();
    var request = "/HTTT-DN/pages/main/xuatkho-taophieuxuat-khoinfo.php?maKho=" + khoHang;
    xhr.open("GET", request, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.status === 200) {
        if (xhr.responseText.trim() !== "") {
          var response = JSON.parse(xhr.responseText);
          document.getElementById("khoInfo").innerHTML = response.khoInfo;
          document.getElementById("maPhieuXuat").innerHTML = response.maPhieuXuat;
        }
      } else {
        console.error('Request failed: ' + xhr.status);
      }
    };
    xhr.send();
  }

  function getMucDich() {
    var mucDichList = document.getElementsByName("mucdichxuatkho");
    var mucDich = "";
    for (var i = 0; i < mucDichList.length; i++) {
      if (mucDichList[i].checked) {
        mucDich = mucDichList[i].value;
        break;
      }
    }

    return mucDich;
  }

  function submitNhapForm(id) {
    var mucDich = getMucDich();

    if (mucDich == "trahangchonhacungcap") {
      var maNCC = document.getElementById("maNhaCungCap").value;
      if (maNCC === "") {
        alert("Hãy chọn nhà cung cấp")
        return;
      }
      // Tạo một đối tượng để lưu trữ dữ liệu của các input có giá trị khác không
      var dataToSend = {};

      // Lặp qua tất cả các input trong bảng
      var inputs = document.querySelectorAll("#dataTable-1 .form-control");
      for (var index = 0; index < inputs.length - 1; index++) {
        var input = inputs[index];
        var value = parseInt(input.value);
        if (value !== 0 && input.value !== "") {
          dataToSend[input.id] = value;
        }
      }
      var giaXuat = inputs[inputs.length - 1].value;

      console.log(Object.keys(dataToSend).length)
      // Kiểm tra xem có dữ liệu để gửi không
      if (Object.keys(dataToSend).length > 0 && giaXuat !== "") {
        if (parseInt(giaXuat) !== 0) {
          dataToSend['lyDo'] = 0;
          dataToSend['giaXuat'] = parseInt(giaXuat);
          dataToSend['id'] = parseInt(id);
          dataToSend['maNCC'] = parseInt(maNCC);
          var maPhieuXuat = document.getElementById("maPhieuXuat").innerText;
          dataToSend['maPhieuXuat'] = maPhieuXuat;

          var chiTietTable = document.getElementById("chiTietPhieuXuatTable");
          var rowCount = chiTietTable.rows.length - 1;
          if (rowCount == 0) {
            dataToSend['tongTien'] = 0;
          } else {
            var currentTotalMoney = 0;
            for (var i = 1; i < chiTietTable.rows.length; i++) {
              var row = chiTietTable.rows[i];
              var thanhTienCell = row.cells[5];
              var thanhTienData = thanhTienCell.innerHTML;
              currentTotalMoney += parseInt(thanhTienData);
            }
            dataToSend['tongTien'] = currentTotalMoney;
          }

          // Sử dụng AJAX để gửi dữ liệu về server
          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.responseText.trim() !== "") {
                var response = JSON.parse(xhr.responseText);
                if (response.error == "None") {
                  document.getElementById("closePhieuNhapBtn").click();
                  resetPhieuXuat();
                  document.getElementById("chiTietPhieuXuat").insertAdjacentHTML("beforeend", response.chiTietTable);
                  document.getElementById("tongTien").innerHTML = response.tongTien + "₫";
                } else {
                  alert(response.error);
                }
              }
            }
          };
          xhr.open("POST", "/HTTT-DN/pages/main/xuatkho-taophieuxuat-addproductrow.php", true);
          xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
          xhr.send(JSON.stringify(dataToSend));
        } else {
          alert("Giá xuất không thể bằng 0")
        }
      } else if (Object.keys(dataToSend).length > 0 && giaXuat === "") {
        alert("Chưa nhập giá xuất")
      } else if (Object.keys(dataToSend).length === 0 && giaXuat !== "") {
        alert("Chưa nhập số lượng sản phẩm xuất")
      } else {
        alert("Không có gì trong form")
      }
    } else if (mucDich == "xuatchokhachhang") {
      // Tạo một đối tượng để lưu trữ dữ liệu của các input có giá trị khác không
      var dataToSend = {};

      // Lặp qua tất cả các input trong bảng
      var inputs = document.querySelectorAll("#dataTable-1 .form-control");
      for (var index = 0; index < inputs.length - 1; index++) {
        var input = inputs[index];
        var value = parseInt(input.value);
        if (value !== 0 && input.value !== "") {
          dataToSend[input.id] = value;
        }
      }

      // Kiểm tra xem có dữ liệu để gửi không
      if (Object.keys(dataToSend).length > 0) {
        dataToSend['id'] = parseInt(id);
        dataToSend['lyDo'] = 1;

        var chiTietTable = document.getElementById("chiTietPhieuXuatTable");
        var rowCount = chiTietTable.rows.length - 1;
        if (rowCount == 0) {
          dataToSend['tongTien'] = 0;
        } else {
          var currentTotalMoney = 0;
          for (var i = 1; i < chiTietTable.rows.length; i++) {
            var row = chiTietTable.rows[i];
            var thanhTienCell = row.cells[5];
            var thanhTienData = thanhTienCell.innerHTML;
            
            currentTotalMoney += parseInt(changeMoneyToNum(thanhTienData.split("₫")[0]));
          }
          dataToSend['tongTien'] = currentTotalMoney;
        }

        // Sử dụng AJAX để gửi dữ liệu về server
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.responseText.trim() !== "") {
              var response = JSON.parse(xhr.responseText);
              if (response.error == "None") {
                document.getElementById("closePhieuNhapBtn").click();
                resetPhieuXuat();
                document.getElementById("chiTietPhieuXuat").insertAdjacentHTML("beforeend", response.chiTietTable);
                document.getElementById("tongTien").innerHTML = response.tongTien + "₫";
              } else {
                alert(response.error);
              }
            }
          }
        };
        xhr.open("POST", "/HTTT-DN/pages/main/xuatkho-taophieuxuat-addproductrow.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.send(JSON.stringify(dataToSend));
      } else {
        alert("Chưa nhập số lượng sản phẩm xuất")
      }
    } else {
      var maKho = document.getElementById("khoHang").value;
      if (maKho === "") {
        alert("Hãy chọn kho hàng")
        return;
      }

      // Tạo một đối tượng để lưu trữ dữ liệu của các input có giá trị khác không
      var dataToSend = {};

      // Lặp qua tất cả các input trong bảng
      var inputs = document.querySelectorAll("#dataTable-1 .form-control");
      for (var index = 0; index < inputs.length - 1; index++) {
        var input = inputs[index];
        var value = parseInt(input.value);
        if (value !== 0 && input.value !== "") {
          dataToSend[input.id] = value;
        }
      }

      // Kiểm tra xem có dữ liệu để gửi không
      if (Object.keys(dataToSend).length > 0) {
        dataToSend['id'] = parseInt(id);
        dataToSend['lyDo'] = 2;

        // Sử dụng AJAX để gửi dữ liệu về server
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.responseText.trim() !== "") {
              var response = JSON.parse(xhr.responseText);
              if (response.error == "None") {
                document.getElementById("closePhieuNhapBtn").click();
                resetPhieuXuat();
                document.getElementById("chiTietPhieuXuat").insertAdjacentHTML("beforeend", response.chiTietTable);
              } else {
                alert(response.error);
              }
            }
          }
        };
        xhr.open("POST", "/HTTT-DN/pages/main/xuatkho-taophieuxuat-addproductrow.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.send(JSON.stringify(dataToSend));
      } else {
        alert("Chưa nhập số lượng sản phẩm xuất")
      }
    }


  }

  function resetPhieuXuat() {
    var inputs = document.querySelectorAll("#dataTable-1 .form-control");
    for (var index = 0; index < inputs.length; index++) {
      inputs[index].value = "";
    }
  }

  function themIdIntoForm(id) {
    document.getElementById("nhapFormBtnContainer").innerHTML = "<input class='btn btn-primary' type='button' value='Xuất' onclick='submitNhapForm(" + id + ")'></input>"
  }

  function luuPhieuXuat() {
    var chiTietTable = document.getElementById("chiTietPhieuXuatTable");
    var rowCount = chiTietTable.rows.length - 1;
    if (rowCount == 0) {
      alertMessage('info', 'Phiếu xuất chưa có thông tin sản phẩm!');
      return;
    }
    var mucDich = getMucDich();
    if (mucDich == "trahangchonhacungcap") {
      var lyDo = 0;
      var maPhieuXuat = document.getElementById("maPhieuXuat").innerText;
      var maNCC = document.getElementById("maNhaCungCap").value;
      var chiTietTable = document.getElementById("chiTietPhieuXuatTable");

      // Tạo một đối tượng để lưu trữ dữ liệu của các input có giá trị khác không
      var chiTietList = [];

      // Lặp qua tất cả các input trong bảng
      for (var i = 1; i < chiTietTable.rows.length; i++) {
        var row = chiTietTable.rows[i];

        var maSanPham = row.cells[0].innerHTML;
        var size = row.cells[2].innerHTML;
        var giaXuat = row.cells[3].innerHTML.split("₫")[0];
        var soLuong = row.cells[4].innerHTML;

        var rowData = {
          "maSanPham": maSanPham,
          "size": size,
          "giaXuat": changeMoneyToNum(giaXuat),
          "soLuong": soLuong
        };
        chiTietList.push(rowData);
      }

      var phieuXuatData = {
        'maNCC': parseInt(maNCC),
        'maPhieuXuat': maPhieuXuat,
        'chiTietList': chiTietList,
        'lyDo': lyDo
      };

      // Sử dụng AJAX để gửi dữ liệu về server
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.responseText.trim() !== "") {
            var response = JSON.parse(xhr.responseText);
            if (response.error == "None") {
              document.getElementById("closePhieuNhapBtn").click();
              resetPhieuXuat();
              document.getElementById("chiTietPhieuXuat").innerHTML = "";
              document.getElementById("tongTien").innerHTML = "0₫";
              document.getElementById("maPhieuXuat").innerHTML = "";
              alertMessage('success', response.alert);
            } else {
              alert(response.error);
            }
          }
        }
      };
      xhr.open("POST", "/HTTT-DN/pages/main/xuatkho-taophieuxuat-addphieuxuat.php", true);
      xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      xhr.send(JSON.stringify(phieuXuatData));
      console.log(JSON.stringify(phieuXuatData));
    } else if (mucDich == "xuatchokhachhang") {
      var lyDo = 1;

      var tenKH = document.getElementById("tenKhachHang");
      var diaChi = document.getElementById("diaChi");
      var sdt = document.getElementById("sodienthoai");
      var phoneRegEx = /^0[0-9]{8,9}$/;

      if (tenKH.value.trim() == "") {
        alertMessage('warning', 'Chưa nhập tên khách hàng');
        return;
      } else if (diaChi.value.trim() == "") {
        alertMessage('warning', 'Chưa nhập địa chỉ');
        return;
      } else if (sdt.value.trim() == "") {
        alertMessage('warning', 'Chưa nhập số điện thoại');
        return;
      } else if (sdt.value != "" && !phoneRegEx.test(sdt.value.trim())) {
        alertMessage('warning', "Số điện thoại không đúng định dạng");
        return;
      }
      
      var maPhieuXuat = document.getElementById("maPhieuXuat").innerText;
      var chiTietTable = document.getElementById("chiTietPhieuXuatTable");

      // Tạo một đối tượng để lưu trữ dữ liệu của các input có giá trị khác không
      var chiTietList = [];

      // Lặp qua tất cả các input trong bảng
      for (var i = 1; i < chiTietTable.rows.length; i++) {
        var row = chiTietTable.rows[i];

        var maSanPham = row.cells[0].innerHTML;
        var size = row.cells[2].innerHTML;
        var giaXuat = row.cells[3].innerHTML.split("₫")[0];
        var soLuong = row.cells[4].innerHTML;

        var rowData = {
          "maSanPham": maSanPham,
          "size": size,
          "giaXuat": changeMoneyToNum(giaXuat),
          "soLuong": soLuong
        };
        chiTietList.push(rowData);
      }

      var phieuXuatData = {
        'chiTietList': chiTietList,
        'tenKH' : tenKH.value,
        'diaChi' : diaChi.value,
        'sdt' : sdt.value,
        'lyDo': lyDo
      };

      // Sử dụng AJAX để gửi dữ liệu về server
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.responseText.trim() !== "") {
            var response = JSON.parse(xhr.responseText);
            if (response.error == "None") {
              document.getElementById("closePhieuNhapBtn").click();
              resetPhieuXuat();
              document.getElementById("chiTietPhieuXuat").innerHTML = "";
              document.getElementById("tongTien").innerHTML = "0₫";
              tenKH.value = "";
              diaChi.value = "";
              sdt.value = "";
              alertMessage('success', response.alert);
            } else {
              alert(response.error);
            }
          }
        }
      };
      xhr.open("POST", "/HTTT-DN/pages/main/xuatkho-taophieuxuat-addphieuxuat.php", true);
      xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      xhr.send(JSON.stringify(phieuXuatData));
      console.log(JSON.stringify(phieuXuatData));
    } else {
      var lyDo = 2;
      var maPhieuXuat = document.getElementById("maPhieuXuat").innerText;
      var maKho = document.getElementById("khoHang").value;
      var chiTietTable = document.getElementById("chiTietPhieuXuatTable");

      // Tạo một đối tượng để lưu trữ dữ liệu của các input có giá trị khác không
      var chiTietList = [];

      // Lặp qua tất cả các input trong bảng
      for (var i = 1; i < chiTietTable.rows.length; i++) {
        var row = chiTietTable.rows[i];

        var maSanPham = row.cells[0].innerHTML;
        var size = row.cells[2].innerHTML;
        var soLuong = row.cells[4].innerHTML;

        var rowData = {
          "maSanPham": maSanPham,
          "size": size,
          "soLuong": soLuong
        };
        chiTietList.push(rowData);
      }

      var phieuXuatData = {
        'maKho': parseInt(maKho),
        'maPhieuXuat': maPhieuXuat,
        'chiTietList': chiTietList,
        'lyDo': lyDo
      };

      // Sử dụng AJAX để gửi dữ liệu về server
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.responseText.trim() !== "") {
            var response = JSON.parse(xhr.responseText);
            if (response.error == "None") {
              document.getElementById("closePhieuNhapBtn").click();
              resetPhieuXuat();
              document.getElementById("chiTietPhieuXuat").innerHTML = "";
              document.getElementById("tongTien").innerHTML = "0₫";
              document.getElementById("maPhieuXuat").innerHTML = "";
              alertMessage('success', response.alert);
            } else {
              alert(response.error);
            }
          }
        }
      };
      xhr.open("POST", "/HTTT-DN/pages/main/xuatkho-taophieuxuat-addphieuxuat.php", true);
      xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
      xhr.send(JSON.stringify(phieuXuatData));
      console.log(JSON.stringify(phieuXuatData));
    }

  }
</script>

<?php
function hienThiSanPham()
{
  require_once($_SERVER['DOCUMENT_ROOT'] . '/HTTT-DN/object/action.php');

  $productList = getProductList();
  for ($i = 0; $i < count($productList); $i++) {
    $product = $productList[$i];
    if ($product->getTinhTrang() == DA_XOA)
      continue;
    echo '
    <tr>
        <td>' . $product->getMaSanPham() . '</td>
        <td>' .
      '<div class="product-img" style="background-color:#EDEAEB; width: 100px; height: 80px;  border-radius: 5px;">
      <img src="' . $product->getHinhAnh() . '" alt="" style="width:100%; height:100%; object-fit:contain;">
        </div>' .
      '</td>
        <td>' . $product->getTenSanPham() . '</td>
        <td>' . changeMoney($product->getGiaCu()) . '₫</td>
        <td>' . changeMoney($product->getGiaMoi()) . '₫</td>
        <td>' . $product->getMaNhanHieu() . '</td>
        <td>Nam, thể thao</td>
        <td>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#chitietsoluong" 
            onclick="getChiTietSoLuong(' . $product->getMaSanPham() . ')">'
      . getSoLuongSanPham($product->getMaSanPham()) . '</button>
            </td>
        <td>
            <div>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#nhapsanpham" 
                onclick="themIdIntoForm(' . $product->getMaSanPham() . ')">Xuất</button>
            </div>
        </td>
    </tr>';
  }
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $('input[type="radio"][name="mucdichxuatkho"]').change(function() {
      $('.trahangchonhacungcap, .xuatchokhachhang, .chuyenkhohang').hide();
      if (this.value == 'trahangchonhacungcap') {
        $('.trahangchonhacungcap').show();
        $('#maPhieuXuat').html("");
        $('#giaXuatInput').show();
        $('#chiTietPhieuXuat').html("");
        $('#tongTien').html("0₫");
      } else if (this.value == 'xuatchokhachhang') {
        $('.xuatchokhachhang').show();
        $('#maPhieuXuat').html("");
        $('#giaXuatInput').hide();
        $('#chiTietPhieuXuat').html("");
        $('#tongTien').html("0₫");
      } else if (this.value == 'chuyenkhohang') {
        $('.chuyenkhohang').show();
        $('#maPhieuXuat').html("");
        $('#giaXuatInput').hide();
        $('#chiTietPhieuXuat').html("");
        $('#tongTien').html("0₫");
      }
    });
    $('input[type="radio"][name="mucdichxuatkho"]:checked').change();
  });
</script>