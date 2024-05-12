function alertMessage(type, message) {
    document.getElementById("alert-theme").classList.add("alertActive");
    var alert = document.getElementById("alert-container");
    var alertIcon = document.querySelectorAll(".alert-icon")[0];
    var typeMessage = document.querySelectorAll(".type-message")[0];
    var msg = document.querySelectorAll(".message")[0];
    var button = document.getElementById("confirm-btn");
    switch (type) {
        case "success":
            alert.classList.add("active");
            alertIcon.innerHTML = "<i class=\"fa-solid fa-check\" style=\"color: #A5DC86;\"></i>";
            alertIcon.style.border = "3px solid #EDF8E7";
            typeMessage.innerText = "Success"
            msg.innerText = message;
            break;
        case "fail":
            alert.classList.add("active");
            alertIcon.innerHTML = "<i class=\"fa-solid fa-xmark\" style=\"color: #F37777;\"></i>";
            alertIcon.style.border = "3px solid #F27474";
            typeMessage.innerText = "Error!"
            msg.innerText = message;
            break;
        case "warning":
            alert.classList.add("active");
            alertIcon.innerHTML = "<i class=\"fa-solid fa-exclamation\" style=\"color: #F8BB86;\"></i>";
            alertIcon.style.border = "3px solid #FACEA8";
            typeMessage.innerText = "Warning!"
            msg.innerText = message;
            break;
        case "info":
            alert.classList.add("active");
            alertIcon.innerHTML = "<i class=\"fa-solid fa-info\" style=\"color: #3FC3EE;\"></i>";
            alertIcon.style.border = "3px solid #9DE0F6";
            typeMessage.innerText = "Info!"
            msg.innerText = message;
            break;
        case "question":
            alert.classList.add("active");
            alertIcon.innerHTML = "<i class=\"fa-solid fa-question\" style=\"color: #87ADBD;\"></i>";
            alertIcon.style.border = "3px solid #C9DAE1";
            typeMessage.innerText = "Question!"
            msg.innerText = message;
            break;
    }
    button.focus();
    setTimeout(closeAlert, 2000);
}

function closeAlert() {
    var message = document.getElementById("alert-container").querySelectorAll(".message")[0].innerText;
    switch (message) {
        case "Bạn cần phải đăng nhập để thêm sản phẩm vào giỏ hàng":
            window.location.replace("/faion/index.php/login/");
            break;
        case "Đăng ký thành công":
            //window.location.replace("/faion/index.php/login/"); 
            break;
        default:
            document.getElementById("alert-container").classList.remove("active");
            document.getElementById("alert-theme").classList.remove("alertActive");
    }
}

var btn = document.getElementById("confirm-btn");
btn.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
        btn.click();
    }
});

function displayDelete(id) {
    var container = document.getElementById("confirm-container");
    container.classList.add("active");
    var inputAttribute = document.getElementById("inputAttribute");
    inputAttribute.value = id;
}

function closeConfirmContainer(e) {
    e.preventDefault();
    document.getElementById("confirm-container").classList.remove("active");
}

function checkAlert() {
    if (sessionStorage.getItem('deleteProduct') !== null) {
        if (sessionStorage.getItem('deleteProduct') == 'success')
            alertMessage('success', 'Xóa sản phẩm thành công');
        else
            alertMessage('fail', 'Xóa sản phẩm thất bại');
        sessionStorage.removeItem('deleteProduct');
    }
    if (sessionStorage.getItem('addProduct') !== null) {
        if (sessionStorage.getItem('addProduct') == 'success')
            alertMessage('success', 'Thêm sản phẩm thành công');
        else
            alertMessage('fail', 'Thêm sản phẩm thất bại');
        sessionStorage.removeItem('addProduct');
    }
    if (sessionStorage.getItem('deleteNhaCungCap') !== null) {
        if (sessionStorage.getItem('deleteNhaCungCap') == 'success')
            alertMessage('success', 'Xóa nhà cung cấp thành công');
        else
            alertMessage('fail', 'Xóa nhà cung cấp thất bại');
        sessionStorage.removeItem('deleteNhaCungCap');
    }
    if (sessionStorage.getItem('addNCC') !== null) {
        if (sessionStorage.getItem('addNCC') == 'success')
            alertMessage('success', 'Thêm nhà cung cấp thành công');
        else
            alertMessage('fail', 'Thêm nhà cung cấp thất bại');
        sessionStorage.removeItem('addNCC');
    }
    if (sessionStorage.getItem('editTrangThaiPhieuNhap') !== null) {
        if (sessionStorage.getItem('editTrangThaiPhieuNhap') == 'success')
            alertMessage('success', 'Đổi trạng thái phiếu nhập thành công');
        else if (sessionStorage.getItem('editTrangThaiPhieuNhap') == 'same1')
            alertMessage('info', 'Phiếu nhập đã ở trạng thái đã nhận hàng!');
        else if (sessionStorage.getItem('editTrangThaiPhieuNhap') == 'same0')
            alertMessage('info', 'Phiếu nhập đã ở trạng thái chưa nhận hàng!');
        else if (sessionStorage.getItem('editTrangThaiPhieuNhap') == 'gail')
            alertMessage('fail', 'Đổi trạng thái phiếu nhập thất bại');
        else if (sessionStorage.getItem('editTrangThaiPhieuNhap') == 'cannotChange') 
            alertMessage('info', 'Không được đổi trạng thái của phiếu nhập này');
        sessionStorage.removeItem('editTrangThaiPhieuNhap');
    }
    if (sessionStorage.getItem('editTrangThaiPhieuXuat') !== null) {
        if (sessionStorage.getItem('editTrangThaiPhieuXuat') == 'success')
            alertMessage('success', 'Đổi trạng thái phiếu xuất thành công');
        else if (sessionStorage.getItem('editTrangThaiPhieuXuat') == 'same1')
            alertMessage('info', 'Phiếu xuất đã ở trạng thái đã xác nhận!');
        else if (sessionStorage.getItem('editTrangThaiPhieuXuat') == 'same0')
            alertMessage('info', 'Phiếu xuất đã ở trạng thái hủy đơn!');
        else
            alertMessage('fail', 'Đổi trạng thái phiếu xuất thất bại');
        sessionStorage.removeItem('editTrangThaiPhieuXuat');
    }
    if (sessionStorage.getItem('editTrangThaiPhieuXuat') !== null) {
        if (sessionStorage.getItem('editTrangThaiPhieuXuat') == 'success')
            alertMessage('success', 'Đổi trạng thái phiếu xuất thành công');
        else if (sessionStorage.getItem('editTrangThaiPhieuXuat') == 'same1')
            alertMessage('info', 'Phiếu xuất đã ở trạng thái đã xuất hàng!');
        else if (sessionStorage.getItem('editTrangThaiPhieuXuat') == 'same0')
            alertMessage('info', 'Phiếu xuất đã ở trạng thái chưa xuất hàng!');
        else if (sessionStorage.getItem('editTrangThaiPhieuXuat') == 'fail')
            alertMessage('fail', 'Đổi trạng thái phiếu xuất thất bại');
        else if (sessionStorage.getItem('editTrangThaiPhieuXuat') == 'cannotChange') 
            alertMessage('info', 'Không được đổi trạng thái của phiếu xuất này');
        sessionStorage.removeItem('editTrangThaiPhieuXuat');
    }
}

function changeMoneyToNum(money) {
    var arr = money.split(".");
    var num = '';
    for (var i = 0; i < arr.length; i++) {
        num += arr[i];
    }
    return num;
}

function checkNumber(input) {
    var price = input.value;
    var request = "/HTTT-DN/pages/main/admin-sanpham-filter-checknumber.php?price=" + price;
    var xml = new XMLHttpRequest();
    xml.open("GET", request, true);
    xml.onload = function() {
        input.value = this.responseText;
    }
    xml.send();
}

// TEST ĐỪNG XÓA
// function deleteProduct(maSanPham) {
//     var xhr = new XMLHttpRequest();
//     xhr.open('POST', '/HTTT-DN/pages/main/sanpham-delete.php', true);
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === XMLHttpRequest.DONE) {
//             if (xhr.status === 200) {
//                 var response = xhr.responseText; // Nhận dữ liệu trả về
//                 //Xử lý dữ liệu HTML và đoạn mã JavaScript
//                 var response = JSON.parse(xhr.responseText);
//                 document.getElementById("productListBody").innerHTML = response.productTable;
//                 eval(response.script);
//             } else {
//                 console.error('Request failed: ' + xhr.status);
//             }
//         }
//     };
//     xhr.send('maSanPham=' + maSanPham);
// }

// function displayDelete(type, id) {
//     if (type == "product") { // Xóa product
//         var container = document.getElementById("confirm-container");
//         container.classList.add("active");
//         container.innerHTML = "\
//                 <div class=\"container\">\
//                     <form>\
//                         <div class=\"confirm-icon-container\">\
//                             <div class=\"alert-icon\">\
//                                 <i class=\"fa-solid fa-exclamation\" style=\"color: #F8BB86;\"></i>\
//                             </div>\
//                         </div>\
//                         <div class=\"message\">Bạn có chắc chắn muốn xóa sản phẩm này không?</div>\
//                         <div class=\"btn-container\">\
//                             <div class=\"left\">\
//                                 <input type=\"button\" name=\"delete-product-submit\" value=\"Xóa\" onclick=\"deleteProduct(" + id + ")\">\
//                             </div>\
//                             <div class=\"right\">\
//                                 <input type=\"button\" id=\"closeConfirmContainer\" onclick=\"closeConfirmContainer(event);\" value=\"Trở lại\">\
//                             </div>\
//                         </div>\
//                     </form>\
//                 </div>";
//     } else { // Xóa category
//         var container = document.getElementById("confirm-container");
//         container.classList.add("active");
//         container.innerHTML = "\
//             <div class=\"container\">\
//                 <form action=\"/faion/action/actionProduct.php\" method=\"post\">\
//                     <div class=\"confirm-icon-container\">\
//                         <div class=\"alert-icon\">\
//                             <i class=\"fa-solid fa-exclamation\" style=\"color: #F8BB86;\"></i>\
//                         </div>\
//                     </div>\
//                     <div class=\"message\">Bạn có chắc chắn muốn xóa thể loại này không?</div>\
//                     <div class=\"btn-container\">\
//                         <input type=\"text\" name=\"categoryId\" value=\"" + id + "\">\
//                         <div class=\"left\">\
//                             <input type=\"submit\" name=\"delete-category-submit\" value=\"Xóa\">\
//                         </div>\
//                         <div class=\"right\">\
//                             <input type=\"button\" onclick=\"closeConfirmContainer(event);\" value=\"Trở lại\">\
//                         </div>\
//                     </div>\
//                 </form>\
//             </div>";
//     }
// }