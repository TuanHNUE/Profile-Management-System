<?php  
    include "../../Nhom27_LapTrinhWeb/connectdb.php";
    include "../../Nhom27_LapTrinhWeb/function.php";
    session_start();
    if(!kiem_tra_dang_nhap()){
        header("location: dangnhap.php");
    }

    global $conn;
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM `ho_so_thi_sinh` WHERE 1";
    $result = mysqli_query($conn, $sql);
    
    // lấy dữ liệu nghành và khối
    $nganh = isset($_GET['nganh']) ? $_GET['nganh'] : '';
    $khoi = isset($_GET['khoi']) ? $_GET['khoi'] : '';
?>
<?php
    // xem hồ sơ chi tiết
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['xemhoso'])) {
        $_SESSION['idchitiet'] = $_POST['id'];
        header("location: xemhoso.php");
        exit();
    }
    // xóa
    if (isset($_POST['xoa'])) {
        $id = $_POST['id'];
        xoa_nop_ho_so($id);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nộp hồ sơ</title>
    <link rel="icon" href="https://cdn.glitch.global/f019bcd3-abb6-43fe-bbcc-2654d25a9106/logo.png.png?v=1671271634762"/>
    <link rel="stylesheet" type="text/css" href="css/nophoso.css">
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
                <img class="bagach" src="picture/bagach.png" alt="Menu">
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
    
    <main>
        <a href="trangchu.php"><button class="maunut"><img width="25px" height="20px" src="picture/back.png"></button></a>
        <?php 
            $a = $_SESSION['tk'];
            $user = lay_du_lieu($a);
            $loai_tai_khoan = $user['loaitaikhoan'];
            $tentk = $user['taikhoan'];
            $hoten = $user['ho_ten_nguoi_dung'];
            $id_tai_khoan = $user['id'];
            // tk hoc sinh
            if($loai_tai_khoan == "hocsinh"){ ?>
                <div class="vien">
                    <h2>Nộp Hồ Sơ</h2>
                    <form action="" method="post" enctype="multipart/form-data">
                        <?php if ($khoi == 'A00'): ?>
                            <input type="hidden" name="khoi" value="<?php echo htmlspecialchars($khoi); ?>">
                            <label>Họ và tên: <?php echo $hoten; ?></label>
                            <br>
                            <?php 
                                echo "Nghành xét tuyển: ".$nganh."<br>"; 
                                echo "Khối xét tuyển: ".$khoi."<br>"; 
                            ?>
                            <label>Điểm Toán:</label><br>
                            <input type="number" name="diem_toan" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <label>Điểm Lý:</label><br>
                            <input type="number" name="diem_ly" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <label>Điểm Hóa:</label><br>
                            <input type="number" name="diem_hoa" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <br>
                            <label>Ảnh học bạ:</label><br>
                            <input type="file" name="upfile">
                            <button type="submit" name="submit">Nộp Hồ Sơ</button>
                        
                        <?php elseif ($khoi == 'A01'): ?>
                            <input type="hidden" name="khoi" value="<?php echo htmlspecialchars($khoi); ?>">
                            <label>Họ và tên: <?php echo $hoten; ?></label>
                            <br>
                            <?php 
                                echo "Nghành xét tuyển: ".$nganh."<br>"; 
                                echo "Khối xét tuyển: ".$khoi."<br>"; 
                            ?>
                            <label>Điểm Toán:</label><br>
                            <input type="number" name="diem_toan" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <label>Điểm Lý:</label><br>
                            <input type="number" name="diem_ly" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <label>Điểm Tiếng Anh:</label><br>
                            <input type="number" name="diem_anh" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <br>
                            <label>Ảnh học bạ:</label><br>
                            <input type="file" name="upfile">
                            <button type="submit" name="submit">Nộp Hồ Sơ</button>

                        <?php elseif ($khoi == 'B00'): ?>
                            <input type="hidden" name="khoi" value="<?php echo htmlspecialchars($khoi); ?>">
                            <label>Họ và tên: <?php echo $hoten; ?></label>
                            <br>
                            <?php 
                                echo "Nghành xét tuyển: ".$nganh."<br>"; 
                                echo "Khối xét tuyển: ".$khoi."<br>"; 
                            ?>
                            <label>Điểm Toán:</label><br>
                            <input type="number" name="diem_toan" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <label>Điểm Hóa:</label><br>
                            <input type="number" name="diem_hoa" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <label>Điểm Sinh:</label><br>
                            <input type="number" name="diem_sinh" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <br>
                            <label>Ảnh học bạ:</label><br>
                            <input type="file" name="upfile">
                            <button type="submit" name="submit">Nộp Hồ Sơ</button>
                
                            
                        <?php elseif ($khoi == 'C00'): ?>
                            <input type="hidden" name="khoi" value="<?php echo htmlspecialchars($khoi); ?>">
                            <label>Họ và tên: <?php echo $hoten; ?></label>
                            <br>
                            <?php 
                                echo "Nghành xét tuyển: ".$nganh."<br>"; 
                                echo "Khối xét tuyển: ".$khoi."<br>"; 
                            ?>
                            <label>Điểm Văn:</label><br>
                            <input type="number" name="diem_van" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <label>Điểm Sử:</label><br>
                            <input type="number" name="diem_su" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <label>Điểm Địa:</label><br>
                            <input type="number" name="diem_dia" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <br>
                            <label>Ảnh học bạ:</label><br>
                            <input type="file" name="upfile">
                            <button type="submit" name="submit">Nộp Hồ Sơ</button>

                        <?php elseif ($khoi == 'D01'): ?>
                            <input type="hidden" name="khoi" value="<?php echo htmlspecialchars($khoi); ?>">
                            <label>Họ và tên: <?php echo $hoten; ?></label>
                            <br>
                            <?php 
                                echo "Nghành xét tuyển: ".$nganh."<br>"; 
                                echo "Khối xét tuyển: ".$khoi."<br>"; 
                            ?>
                            <label>Điểm Toán:</label><br>
                            <input type="number" name="diem_toan" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <label>Điểm Văn:</label><br>
                            <input type="number" name="diem_van" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <label>Điểm Tiếng Anh:</label><br>
                            <input type="number" name="diem_anh" step="0.01" min="0" max="10" class="inputdiem" required><br>
                            <br>
                            <label>Ảnh học bạ:</label><br>
                            <input type="file" name="upfile">
                            <button type="submit" name="submit">Nộp Hồ Sơ</button>
                        
                        <?php else: ?>
                            <p>Không có thông tin về khối xét tuyển này.</p>
                        <?php endif; ?>
                        
                    </form>
                </div>
                <br>
                <?php
                    $diaChiLuuTruFile = 'uploadFile/';
                    $diem_toan = isset($_POST['diem_toan']) ? $_POST['diem_toan'] : 0;
                    $diem_ly = isset($_POST['diem_ly']) ? $_POST['diem_ly'] : 0;
                    $diem_hoa = isset($_POST['diem_hoa']) ? $_POST['diem_hoa'] : 0;
                    $diem_anh = isset($_POST['diem_anh']) ? $_POST['diem_anh'] : 0;
                    $diem_sinh = isset($_POST['diem_sinh']) ? $_POST['diem_sinh'] : 0;
                    $diem_van = isset($_POST['diem_van']) ? $_POST['diem_van'] : 0;
                    $diem_su = isset($_POST['diem_su']) ? $_POST['diem_su'] : 0;
                    $diem_dia = isset($_POST['diem_dia']) ? $_POST['diem_dia'] : 0;
                    if (isset($_POST['submit'])) {
                        $nganh = $_GET['nganh'];
                        $sql_check = "SELECT * FROM `ho_so_thi_sinh` WHERE `tentk` = '$tentk' AND `nganh_xet_tuyen` = '$nganh'";
                        $result_check = mysqli_query($conn, $sql_check);
                        if (mysqli_num_rows($result_check) > 0) {
                            echo "<script>alert('Bạn đã nộp hồ sơ cho ngành này rồi!');</script>";
                        } else {
                            $tenFile = $_FILES['upfile']['name'];
                            $fileTam = $_FILES['upfile']['tmp_name'];
                            $loi = $_FILES['upfile']['error'];
                            $dungluong = $_FILES['upfile']['size'];
                            $dinhDangFile = strtolower(pathinfo($tenFile, PATHINFO_EXTENSION));
                            $tenFileGoc = (pathinfo($tenFile, PATHINFO_FILENAME));
                            if ($loi == false) {
                                if ($dinhDangFile == "jpg" || $dinhDangFile == "png") {
                                    if ($dungluong < 100 * 1024 * 1024) {
                                        $dem = 1;
                                        while (file_exists($diaChiLuuTruFile . $tenFile) == true) {
                                            $tenFile = $tenFileGoc . '(' . $dem . ')' . '.' . $dinhDangFile;
                                            $dem++;
                                        }
                                        if (move_uploaded_file($fileTam, $diaChiLuuTruFile . $tenFile)) {
                                            $test = $diaChiLuuTruFile.$tenFile;
                                            $nguoiduyetbandau = "Chưa có ai duyệt";
                                            $trangthaibandau = 0;                              
                                            $sql = "INSERT INTO `ho_so_thi_sinh`(`id`, `tentk`, `ho_ten`, `nganh_xet_tuyen`, `khoi_xet_tuyen`, `ten_nguuoi_duyet`, `trang_thai`, `file_hoc_ba`, `diem_toan`, `diem_ly`, `diem_hoa`, `diem_anh`, `diem_sinh`, `diem_van`, `diem_su`, `diem_dia`) 
                                                    VALUES ('null','$tentk','$hoten','$nganh','$khoi','$nguoiduyetbandau','$trangthaibandau', '$test', '$diem_toan', '$diem_ly', '$diem_hoa', '$diem_anh', '$diem_sinh', '$diem_van', '$diem_su', '$diem_dia')";
                                            if (mysqli_query($conn, $sql)) {
                                                echo "<script>alert('Nộp hồ sơ thành công!');</script>";
                                            } else {
                                                echo "<script>alert('Nộp hồ sơ thất bại!');</script>";
                                            }
                                        } else {
                                            echo "<script>alert('Lưu hồ sơ thất bại!');</script>";
                                        }
                                    } else {
                                        echo "<script>alert('Quá dung lượng!');</script>";
                                    }
                                } else {
                                    echo "<script>alert('Chỉ được upload file JPG và PNG!');</script>";
                                }
                            } else {
                                echo "<script>alert('Bạn chưa đăng tải ảnh!');</script>";
                            }
                        }                        
                    }
                ?>
            <?php }
        ?>
        <h2>Danh sách hồ sơ đã nộp</h2>
        <table>
            <?php
                if ($loai_tai_khoan == "hocsinh" ) {
                    $sql = "SELECT * FROM `ho_so_thi_sinh` WHERE `tentk` = '$tentk'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        echo "  <tr>
                                    <th>STT</th>
                                    <th>Họ tên học sinh</th>
                                    <th>Ngành nộp hồ sơ</th>
                                    <th>Khối xét hồ sơ</th>
                                    <th>Tên người duyệt hồ sơ</th>
                                    <th>Trạng thái hồ sơ</th>
                                    <th>Hành động</th>
                                </tr>";
                        $stt = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr class='maunenbang'>";
                            echo "<td>" . $stt++ . "</td>";
                            echo "<td>" . $row['ho_ten'] . "</td>";
                            echo "<td>" . $row['nganh_xet_tuyen'] . "</td>";
                            echo "<td>" . $row['khoi_xet_tuyen'] . "</td>";
                            echo "<td>" . ($row['ten_nguuoi_duyet'] == NULL ? 'Chưa có người duyệt' : $row['ten_nguuoi_duyet']) . "</td>";
                            echo "<td>" . ($row['trang_thai'] == 0 ? 'Chưa duyệt' : ($row['trang_thai'] == 1 ? 'Đã duyệt' : 'Không duyệt')) . "</td>";
                            echo "<td><form method='POST' action=''>";
                                echo "<input type='hidden' name='id' value='".$row['id']."'>";
                                echo "<button type=\"submit\" name=\"xemhoso\">Xem Hồ Sơ</button>";
                            echo "</form></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo '<tr><td colspan="7" align="center">Không có hồ sơ nào hiện có.</td></tr>';
                    }
                }
            ?>
            <?php
                if ($loai_tai_khoan == "giaovien") {
                    echo "<h3>Ngành nộp hồ sơ: ".$_SESSION['nganh']."</h3>";
                    $nganh = $_SESSION['nganh'];
                    $sql = "SELECT * FROM `ho_so_thi_sinh` WHERE `nganh_xet_tuyen` = '$nganh'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        echo "  <tr>
                                    <th>STT</th>
                                    <th>Họ tên học sinh</th>
                                    <th>Ngành nộp hồ sơ</th>
                                    <th>Khối xét hồ sơ</th>
                                    <th>Tên người duyệt hồ sơ</th>
                                    <th>Trạng thái hồ sơ</th> 
                                    <th>Duyệt</th>
                                    <th>Không duyệt</th>
                                    <th>Hành động</th>
                                </tr>";
                        $stt = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr class='maunenbang'>";
                            echo "<td>" . $stt++ . "</td>";
                            echo "<td>" . $row['ho_ten'] . "</td>";
                            echo "<td>" . $row['nganh_xet_tuyen'] . "</td>";
                            echo "<td>" . $row['khoi_xet_tuyen'] . "</td>";
                            echo "<td>" . ($row['ten_nguuoi_duyet'] == NULL ? 'Chưa có người duyệt' : $row['ten_nguuoi_duyet']) . "</td>";
                            echo "<td>" . ($row['trang_thai'] == 0 ? 'Chưa duyệt' : ($row['trang_thai'] == 1 ? 'Đã duyệt' : 'Không duyệt')) . "</td>";
                            echo "  <td><form action='' method='POST'>
                                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                                            <input type='hidden' name='hanhdong' value='duyet'>
                                            <button type='submit' onclick='return confirm(\"Bạn có chắc muốn duyệt hồ sơ này không?\")'>Duyệt</button>
                                        </form></td>";
                            echo "  <td><form action='' method='POST'>
                                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                                            <input type='hidden' name='hanhdong' value='khongduyet'>
                                            <button type='submit' onclick='return confirm(\"Bạn có chắc muốn không duyệt hồ sơ này không?\")'>Không duyệt</button>
                                        </form></td>";
                            echo "  <td><form method='POST' action=''>
                                            <input type='hidden' name='id' value='".$row['id']."'>
                                            <button type=\"submit\" name=\"xemhoso\">Xem Hồ Sơ</button>
                                        </form></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo '<tr><td colspan="7" align="center">Không có hồ sơ nào hiện có.</td></tr>';
                    }
                }
            ?>
            <?php
                if ($loai_tai_khoan == "admin") {
                    echo "<h3>Ngành nộp hồ sơ: ".$_SESSION['nganh']."</h3>";
                    $nganh = $_SESSION['nganh'];
                    $sql = "SELECT * FROM `ho_so_thi_sinh` WHERE `nganh_xet_tuyen` = '$nganh'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        echo "  <tr>
                                    <th>STT</th>
                                    <th>Họ tên học sinh</th>
                                    <th>Ngành nộp hồ sơ</th>
                                    <th>Khối xét hồ sơ</th>
                                    <th>Tên người duyệt hồ sơ</th>
                                    <th>Trạng thái hồ sơ</th>
                                    <th>Hành động</th>
                                    <th>Xóa</th>
                                </tr>";
                        $stt = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr class='maunenbang'>";
                            echo "<td>" . $stt++ . "</td>";
                            echo "<td>" . $row['ho_ten'] . "</td>";
                            echo "<td>" . $row['nganh_xet_tuyen'] . "</td>";
                            echo "<td>" . $row['khoi_xet_tuyen'] . "</td>";
                            echo "<td>" . ($row['ten_nguuoi_duyet'] == NULL ? 'Chưa có người duyệt' : $row['ten_nguuoi_duyet']) . "</td>";
                            echo "<td>" . ($row['trang_thai'] == 0 ? 'Chưa duyệt' : ($row['trang_thai'] == 1 ? 'Đã duyệt' : 'Không duyệt')) . "</td>";
                            echo "<form method='POST' action=''>";
                                echo "<input type='hidden' name='id' value='".$row['id']."'>";
                                echo "<td><button type=\"submit\" name=\"xemhoso\">Xem Hồ Sơ</button></td>";
                                echo "<td><button type=\"submit\" name=\"xoa\" value='".$row['id']."' onclick='return confirm(\"Bạn có chắc muốn xóa hồ sơ này không?\")'>Xóa</button></td>";
                            echo "</form>";
                            echo "</tr>";
                        }
                    } else {
                        echo '<tr><td colspan="7" align="center">Không có hồ sơ nào hiện có.</td></tr>';
                    }
                }
            ?>
            <?php 
                if (isset($_POST['hanhdong'])) {
                    $id = $_POST['id'];
                    $hanhdong = $_POST['hanhdong'];
                    $nguuoi_duyet = $hoten; 
                    if ($hanhdong == 'duyet') {
                        $capnhat = "UPDATE ho_so_thi_sinh SET ten_nguuoi_duyet = '$nguuoi_duyet', trang_thai = 1 WHERE id = $id";
                        if (mysqli_query($conn, $capnhat)) {
                            echo "<script>alert('Duyệt hồ sơ thành công!'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
                            exit;
                        } else {
                            echo "<script>alert('Duyệt hồ sơ thất bại!');</script>";
                        }
                    }
                    if ($hanhdong == 'khongduyet') {
                        $capnhat = "UPDATE ho_so_thi_sinh SET ten_nguuoi_duyet = '$nguuoi_duyet', trang_thai = -1 WHERE id = $id";
                        if (mysqli_query($conn, $capnhat)) {
                            echo "<script>alert('Duyệt hồ sơ không thành công!'); window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
                            exit;
                        } else {
                            echo "<script>alert('Không duyệt hồ sơ thất bại!');</script>";
                        }
                    }
                }
            ?>
        </table>
    </main>
    <footer>
        <p>Bản quyền © 2024 TEXCLOTHING. Được thiết kế bởi NGUYỄN HỮU TRƯỜNG và PHÙNG ĐÌNH TUẤN.</p>
    </footer>
</body>
</html>
<?php 
    mysqli_close($conn);
?>
