<?php  
    session_start();
    include "../../Nhom27_LapTrinhWeb/connectdb.php";
    include "../../Nhom27_LapTrinhWeb/function.php";
    if(!kiem_tra_dang_nhap()){
        header("location: dangnhap.php");
    }
?>
<?php
    global $conn;
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }


    // Lấy thông tin của hồ sơ cần sửa (nếu có)
    $edit_id = isset($_GET['edit_id']) ? $_GET['edit_id'] : null;
    $edit_data = null;
    if ($edit_id) {
        $edit_data = lay_ho_so_qua_id($edit_id);
    }

    // Thêm hoặc sửa hồ sơ
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
        $ten_nganh = $_POST['ten_nganh'];
        $thoi_gian_bat_dau = $_POST['thoi_gian_bat_dau'];
        $thoi_gian_ket_thuc = $_POST['thoi_gian_ket_thuc'];
        $khoi_xet_tuyen = $_POST['khoi_xet_tuyen'];
        // Kiểm tra trùng tên ngành
        $result_check = check_ten_nganh($ten_nganh);
        if ($result_check && (!$edit_id || ($edit_data['ten_nganh'] != $ten_nganh))) {
            echo "<script>alert('Tên ngành đã tồn tại. Vui lòng chọn tên ngành khác.');</script>";
        } else {
            if ($edit_id) {
                cap_nhat_ho_so($ten_nganh, $thoi_gian_bat_dau, $thoi_gian_ket_thuc, $khoi_xet_tuyen, $edit_id);
            } else {
                them_ho_so($ten_nganh, $thoi_gian_bat_dau, $thoi_gian_ket_thuc, $khoi_xet_tuyen);

            }
        }
    }

    // Xóa hồ sơ
    if (isset($_POST['xoa'])) {
        $id = $_POST['id'];
        xoa_trang_chu($id);
    }

    // hiện ẩn
    if (isset($_GET['hienan'])) {
        $id = $_GET['hienan'];
        hien_an($id);
        echo "<script> window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
    }

    $ArrayGiaoVienID = [];
    // Cập nhật phân quyền
    if (isset($_POST['phanquyen'])) {
        $ho_so_id = $_POST['ho_so_id']; 
        $giaovien_id = $_POST['giaovien_id'];
        $gv = lay_thong_tin_tk_qua_id($giaovien_id);
        $hs = lay_ho_so_qua_id($ho_so_id);
        $tenGV = $gv['ho_ten_nguoi_dung'];
        $tenNganh = $hs['ten_nganh'];
        // Lấy danh sách giáo viên hiện tại từ cơ sở dữ liệu
        $sqlGetGiaoVien = "SELECT giaovien_id FROM ho_so_xet_tuyen WHERE id = $ho_so_id";
        $result = mysqli_query($conn, $sqlGetGiaoVien);
        $row = mysqli_fetch_assoc($result);
        // Nếu có danh sách hiện tại, chuyển nó thành mảng
        if ($row && !empty($row['giaovien_id'])) {
            $ArrayGiaoVienID["$ho_so_id"] = explode(",", $row['giaovien_id']);
        } else {
            $ArrayGiaoVienID["$ho_so_id"] = []; // Nếu chưa có danh sách, khởi tạo mảng trống
        }
        // Kiểm tra và chỉ thêm nếu ID chưa tồn tại trong mảng
        if (!in_array($giaovien_id, $ArrayGiaoVienID["$ho_so_id"])) {
            $ArrayGiaoVienID["$ho_so_id"][] = $giaovien_id;
            // Chuyển danh sách thành chuỗi và lưu vào cơ sở dữ liệu
            $StringGiaoVienID = implode(",", $ArrayGiaoVienID["$ho_so_id"]);
            $sqlupdate = "UPDATE ho_so_xet_tuyen SET giaovien_id = '$StringGiaoVienID' WHERE id = $ho_so_id";
            if (mysqli_query($conn, $sqlupdate)) {
                echo "<script>alert('Phân quyền đã được cập nhật thành công.');</script>";
            } else {
                echo "<script>alert('Lỗi: Không thể cập nhật phân quyền.');</script>";
            }
        }
        else{
            echo "<script>alert('Giáo viên ". $tenGV ." đã được phân quyền vào ngành ". $tenNganh ." trước đó');</script>";
        }
        
    }
    // cập nhật xóa quyền
    if(isset($_POST['xoaquyen'])){
        $ho_so_id = $_POST['ho_so_id']; 
        $giaovien_id = $_POST['giaovien_id'];
        $gv = lay_thong_tin_tk_qua_id($giaovien_id);
        $hs = lay_ho_so_qua_id($ho_so_id);
        $tenGV = $gv['ho_ten_nguoi_dung'];
        $tenNganh = $hs['ten_nganh'];
        // Lấy danh sách giáo viên hiện tại từ cơ sở dữ liệu
        $sqlGetGiaoVien = "SELECT giaovien_id FROM ho_so_xet_tuyen WHERE id = $ho_so_id";
        $result = mysqli_query($conn, $sqlGetGiaoVien);
        $row = mysqli_fetch_assoc($result);
        // Nếu có danh sách hiện tại, chuyển nó thành mảng
        if ($row && !empty($row['giaovien_id'])) {
            $ArrayGiaoVienID["$ho_so_id"] = explode(",", $row['giaovien_id']);
        } else {
            $ArrayGiaoVienID["$ho_so_id"] = []; // Nếu chưa có danh sách, khởi tạo mảng trống
        }
        // Kiểm tra và chỉ thêm nếu ID chưa tồn tại trong mảng
        if (in_array($giaovien_id, $ArrayGiaoVienID["$ho_so_id"])) {
            $id = array_search($giaovien_id, $ArrayGiaoVienID["$ho_so_id"]);
            unset($ArrayGiaoVienID["$ho_so_id"][$id]);
            // $ArrayGiaoVienID["$ho_so_id"][] = $giaovien_id;
            // Chuyển danh sách thành chuỗi và lưu vào cơ sở dữ liệu
            $StringGiaoVienID = implode(",", $ArrayGiaoVienID["$ho_so_id"]);
            $sqlupdate = "UPDATE ho_so_xet_tuyen SET giaovien_id = '$StringGiaoVienID' WHERE id = $ho_so_id";
            if (mysqli_query($conn, $sqlupdate)) {
                echo "<script>alert('Giáo viên ". $tenGV ." đã bị xóa quyền trong ngành ". $tenNganh .".');</script>";
            } else {
                echo "<script>alert('Lỗi: Không thể xóa quyền.');</script>";
            }
        }
        else{
            echo "<script>alert('Giáo viên ". $tenGV ." chưa được phân quyền vào ngành ". $tenNganh ."');</script>";
        }
    }
    // Lấy danh sách giáo viên
    $sql_giaovien = "SELECT id, ho_ten_nguoi_dung FROM dulieutaikhoan WHERE loaitaikhoan = 'giaovien'";
    $result_giaovien = mysqli_query($conn, $sql_giaovien);

    // Truy vấn dữ liệu
    $loai_tai_khoan = lay_du_lieu($_SESSION['tk'])['loaitaikhoan'];
    if ($loai_tai_khoan == "admin") {
        $sql = "SELECT * FROM ho_so_xet_tuyen";
    } else {
        $sql = "SELECT * FROM ho_so_xet_tuyen WHERE trang_thai = 'hiện'";
    }
    $result = mysqli_query($conn, $sql);
?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $_SESSION['nganh'] = $_POST['nganh'];
        header("location: nophoso.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link rel="icon" href="https://cdn.glitch.global/f019bcd3-abb6-43fe-bbcc-2654d25a9106/logo.png.png?v=1671271634762"/>
    <link rel="stylesheet" type="text/css" href="css/trangchu.css">
</head>
<body>
    <header>
        <div class="dautrang">
            <div class="tabinlogo">
                <img class="logo" src="picture/logosupham.png">
                <div class="tentruong">Trường Đại học sư phạm Hà Nội</div>
            </div>

            <div class="space"></div>
            <div class="tabtrangchu">
                <a class="trangchu" href="trangchu.php">Trang Chủ</a>
            </div>
            
            <div class="tabthongke">
                <a class="thongke" href="thongke.php">Thống Kê</a>
            </div>
            <div class="tabbagach">
                <img class="bagach" src="picture/bagach.png">
                <div class="tabmore">
                    <div class="ab1">
                        <a id="fontchu" href="trangchu.php">Trang Chủ</a>
                    </div>
                    <div class="ab2">
                        <a id="fontchu" href="dang_xuat.php">Đăng Xuất</a>
                    </div>
                </div>
            </div>
        </div>  
    </header>
    <main class="test">
        <?php 
            $a = $_SESSION['tk'];
            $user = lay_du_lieu($a);
            $loai_tai_khoan = $user['loaitaikhoan'];
            $id_tai_khoan = $user['id'];
            // admin
            if($loai_tai_khoan == "admin"){
        ?>
            <h1><?php echo $edit_id ? "Sửa hồ sơ xét tuyển học bạ" : "Thêm hồ sơ xét tuyển học bạ"; ?></h1>
            <form method="POST" action="">
                <input type="text" name="ten_nganh" placeholder="Tên ngành" value="<?php echo $edit_data['ten_nganh'] ?? ''; ?>" required>
                <div class="ngaythang">
                    <input type="date" name="thoi_gian_bat_dau" placeholder="Thời gian bắt đầu" value="<?php echo $edit_data['thoi_gian_bat_dau'] ?? ''; ?>" required>
                    <div>   Đến   </div>
                    <input type="date" name="thoi_gian_ket_thuc" placeholder="Thời gian kết thúc" value="<?php echo $edit_data['thoi_gian_ket_thuc'] ?? ''; ?>" required>
                </div>
                <div>
                    <select name="khoi_xet_tuyen" class="khoi_xet_tuyen">
                        <option value="A00" <?php echo (isset($edit_data['khoi_xet_tuyen']) && $edit_data['khoi_xet_tuyen'] == 'A00') ? 'selected' : ''; ?>>A00(Toán, Lý, Hóa)</option>
                        <option value="A01" <?php echo (isset($edit_data['khoi_xet_tuyen']) && $edit_data['khoi_xet_tuyen'] == 'A01') ? 'selected' : ''; ?>>A01(Toán, Lý, Anh)</option>
                        <option value="B00" <?php echo (isset($edit_data['khoi_xet_tuyen']) && $edit_data['khoi_xet_tuyen'] == 'B00') ? 'selected' : ''; ?>>B00(Toán, Hóa, Sinh)</option>
                        <option value="C00" <?php echo (isset($edit_data['khoi_xet_tuyen']) && $edit_data['khoi_xet_tuyen'] == 'C00') ? 'selected' : ''; ?>>C00(Văn, Sử, Địa)</option>
                        <option value="D01" <?php echo (isset($edit_data['khoi_xet_tuyen']) && $edit_data['khoi_xet_tuyen'] == 'D01') ? 'selected' : ''; ?>>D01(Toán, Văn, Anh)</option>
                    </select>
                </div>
                <button type="submit" name="add"><?php echo $edit_id ? "Cập nhật hồ sơ" : "Thêm hồ sơ"; ?></button>
            </form>
            <h1>Danh sách hồ sơ xét tuyển học bạ</h1>
            <table>
                <tr>
                    <th>Tên ngành</th>
                    <th>Khối xét tuyển</th>
                    <th>Thời gian nộp hồ sơ</th>
                    <th>Trạng thái</th>
                    <th>Phân quyền</th>
                    <th>Hành động</th>
                    <th>Nộp hồ sơ</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['ten_nganh']; ?></td>
                    <td><?php echo $row['khoi_xet_tuyen']; ?></td>
                    <td><?php echo $row['thoi_gian_bat_dau'] . ' đến ' . $row['thoi_gian_ket_thuc']; ?></td>
                    <td><?php echo $row['trang_thai']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="ho_so_id" value="<?php echo $row['id']; ?>">
                            <select name="giaovien_id">
                                <?php 
                                mysqli_data_seek($result_giaovien, 0);
                                while ($giaovien = mysqli_fetch_assoc($result_giaovien)) {
                                    $selected = ($giaovien['id'] == $row['giaovien_id']) ? "selected" : "";
                                    echo '<option value="' . $giaovien['id'] . '" ' . $selected . '>' . $giaovien['ho_ten_nguoi_dung'] . '</option>';
                                }
                                ?>
                            </select>
                            <button type="submit" name="phanquyen">Cập nhật</button>
                            <button type="submit" name="xoaquyen">Xóa quyền</button>
                            <?php
                                if (!empty($row['giaovien_id'])) {
                                    $dsgiaovien = explode(",", $row['giaovien_id']);
                                    $sqlgiaovien = "SELECT ho_ten_nguoi_dung FROM dulieutaikhoan WHERE id IN (" . implode(",", $dsgiaovien) . ")";
                                    $resultgiaovien = mysqli_query($conn, $sqlgiaovien);
                                    while ($teacher = mysqli_fetch_assoc($resultgiaovien)) {
                                        echo "<div class='khunggiaovien'>" . htmlspecialchars($teacher['ho_ten_nguoi_dung']) . "</div>";
                                    }
                                } else {
                                    echo "<p>Chưa phân quyền giáo viên.</p>";
                                }
                            ?>
                        </form>
                    </td>
                    <td>
                        <div class="cacnut">
                        <button><a href="?edit_id=<?php echo $row['id']; ?>">Sửa</a></button>
                        <button><a href="?hienan=<?php echo $row['id']; ?>">Ẩn/Hiện</a></button>
                        
                        <?php echo "<form action=\"\" method=\"POST\">
                                        <input type=\"hidden\" name=\"id\" value='".$row['id']."'>
                                        <button class=\"xoa\" type=\"submit\" name=\"xoa\" value='".$row['id']."' onclick='return confirm(\"Bạn có chắc muốn xóa hồ sơ này không?\")'>Xóa</button>
                                     </form>"; ?>
                        </div>
                    </td>
                    <?php echo '<td align="center">
                                    <form action="" method="POST">
                                        <input type="hidden" name="nganh" value="' . htmlspecialchars($row['ten_nganh']) . '">
                                        <button type="submit" name="submit" class="nop">Nộp</button>
                                     </form>
                                </td>'; ?>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php }
        // giao vien
            if($loai_tai_khoan == "giaovien"){ ?>
                <div class="vien1">
                    <h2 align="center">Danh sách các ngành xét tuyển hồ sơ học bạ</h2>
                    <table>
                        <tr>
                            <th align="center" width="200px">Tên ngành</th>
                            <th align="center" width="50px">Khối xét</th>
                            <th align="center" width="200px">Thời gian</th>
                            <th align="center" width="50px">Nộp hồ sơ</th>
                        </tr>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>
                                    <td>' . htmlspecialchars($row['ten_nganh']) . '</td>
                                    <td align="center">' . htmlspecialchars($row['khoi_xet_tuyen']) . '</td>
                                    <td>' . htmlspecialchars($row['thoi_gian_bat_dau']) . ' đến ' . htmlspecialchars($row['thoi_gian_ket_thuc']) . '</td>';
                                if (in_array($id_tai_khoan ,explode(",", $row['giaovien_id']))) {
                                    echo '  <td align="center">
                                                <form action="" method="POST">
                                                    <input type="hidden" name="nganh" value="' . htmlspecialchars($row['ten_nganh']) . '">
                                                    <button type="submit" name="submit" class="nop">Nộp</button>
                                                </form>
                                            </td>';    
                                }
                                else {
                                    echo '  <td align="center">
                                                <form action="" method="get">
                                                    <button type="submit">Không có quyền</button>
                                                </form>
                                            </td>';
                                }
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="4" align="center">Không có ngành nào hiện có.</td></tr>';
                        }
                        ?>
                        
                    </table>
                </div>
            <?php }
                if($loai_tai_khoan == "hocsinh"){ ?>
                    <div class="vien1">
                        <h2 align = "center">Danh sách các ngành xét tuyển hồ sơ học bạ</h2>
                        <table>
                            <tr>
                                <th align="center" width="200px">Tên ngành</th>
                                <th align="center" width="50px">Khối xét</th>
                                <th align="center" width="200px">Thời gian</th>
                                <th align="center" width="50px">Nộp hồ sơ</th>
                            </tr>
                            <?php
                            date_default_timezone_set('Asia/Ho_Chi_Minh');
                            $thoi_gian_hien_tai = date("Y-m-d");
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $thoi_gian_ket_thuc = $row['thoi_gian_ket_thuc'];
                                    $kiem_tra_thoi_gian = ($thoi_gian_hien_tai > $thoi_gian_ket_thuc);
                                    echo '<tr>
                                        <td>' . htmlspecialchars($row['ten_nganh']) . '</td>
                                        <td align="center">' . htmlspecialchars($row['khoi_xet_tuyen']) . '</td>
                                        <td>' . htmlspecialchars($row['thoi_gian_bat_dau']) . ' đến ' . htmlspecialchars($row['thoi_gian_ket_thuc']) . '</td>
                                        <td align="center">';
                                    if ($kiem_tra_thoi_gian) {
                                        echo '<button disabled>Quá hạn nộp</button>';
                                    } else {
                                        echo '<form action="nophoso.php" method="get">
                                                <input type="hidden" name="nganh" value="' . htmlspecialchars($row['ten_nganh']) . '">
                                                <input type="hidden" name="khoi" value="' . htmlspecialchars($row['khoi_xet_tuyen']) . '">
                                                <button type="submit" class="nop">Nộp</button>
                                            </form>';
                                    }
                                    echo '</td></tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4" align="center">Không có ngành nào hiện có.</td></tr>';
                            }
                            ?>
                        </table>
                    </div>
            <?php }
        ?>

    </main>
    <footer>
        <p>Bản quyền © 2024 TEXCLOTHING. Được thiết kế bởi NGUYỄN HỮU TRƯỜNG và PHÙNG ĐÌNH TUẤN.</p>
    </footer>
</body>
</html>
<?php
    mysqli_close($conn);
?>
