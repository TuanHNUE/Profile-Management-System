<?php  
    include "../../Nhom27_LapTrinhWeb/connectdb.php";
    include "../../Nhom27_LapTrinhWeb/function.php";
    session_start();
    if(!kiem_tra_dang_nhap()){
        header("location: dangnhap.php");
    }
?>
<?php
    global $conn;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Hồ Sơ</title>
    <link rel="icon" href="https://cdn.glitch.global/f019bcd3-abb6-43fe-bbcc-2654d25a9106/logo.png.png?v=1671271634762"/>
    <link rel="stylesheet" type="text/css" href="css/thongke.css">
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
    <div class="test"></div>
    <main>
    
    <?php 
        $a = $_SESSION['tk'];
        $user = lay_du_lieu($a);
        $loai_tai_khoan = $user['loaitaikhoan'];
        if($loai_tai_khoan == "giaovien" || $loai_tai_khoan == "hocsinh"){
            echo "<script>
                    alert('Bạn không có thẩm quyền để vào trang này!');
                    window.location.href = 'trangchu.php';
                  </script>";
            exit;
        }
        if($loai_tai_khoan == "admin"){
            $chuaduyet = "SELECT * FROM ho_so_thi_sinh WHERE trang_thai = 0";
            $duyet = "SELECT * FROM ho_so_thi_sinh WHERE trang_thai = 1";
            $khongduyet = "SELECT * FROM ho_so_thi_sinh WHERE trang_thai = -1";
            
            $resultchuaduyet = mysqli_query($conn, $chuaduyet);
            $resultduyet = mysqli_query($conn, $duyet);
            $resultkhongduyet = mysqli_query($conn, $khongduyet);

            $demduyet = "SELECT COUNT(*) AS count_duyet FROM ho_so_thi_sinh WHERE trang_thai = 1";
            $demchuaduyet = "SELECT COUNT(*) AS count_chuaduyet FROM ho_so_thi_sinh WHERE trang_thai = 0";
            $demkhongduyet = "SELECT COUNT(*) AS count_khongduyet FROM ho_so_thi_sinh WHERE trang_thai = -1";
            
            $result_duyet = mysqli_query($conn, $demduyet);
            $result_chuaduyet = mysqli_query($conn, $demchuaduyet);
            $result_khongduyet = mysqli_query($conn, $demkhongduyet);
            
            $sduyet = mysqli_fetch_assoc($result_duyet)['count_duyet'];
            $schuaduyet = mysqli_fetch_assoc($result_chuaduyet)['count_chuaduyet'];
            $skhongduyet = mysqli_fetch_assoc($result_khongduyet)['count_khongduyet'];

            $sql = "SELECT nganh_xet_tuyen, 
                       SUM(CASE WHEN trang_thai = 0 THEN 1 ELSE 0 END) AS chuaduyet,
                       SUM(CASE WHEN trang_thai = 1 THEN 1 ELSE 0 END) AS duyet,
                       SUM(CASE WHEN trang_thai = -1 THEN 1 ELSE 0 END) AS khongduyet
                    FROM ho_so_thi_sinh
                GROUP BY nganh_xet_tuyen";
            $result = mysqli_query($conn, $sql);
    ?>
    <h1 align="center">Thống kê hồ sơ</h1>  
    <div class="vien1">
        <div class="bang">
            <h3>Thống Kê Hồ Sơ Theo Ngành</h3>
            <table>
                <thead>
                    <tr>
                        <th>Ngành Xét Tuyển</th>
                        <th>Hồ Sơ Chưa Duyệt</th>
                        <th>Hồ Sơ Đã Duyệt</th>
                        <th>Hồ Sơ Không Duyệt</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['nganh_xet_tuyen']; ?></td>
                            <td><?php echo $row['chuaduyet']; ?> hồ sơ</td>
                            <td><?php echo $row['duyet']; ?> hồ sơ</td>
                            <td><?php echo $row['khongduyet']; ?> hồ sơ</td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="vien1">
        <div class="bang">
            <h3>Hồ Sơ Chưa Duyệt: <?php echo $schuaduyet; ?> hồ sơ</h3>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên học sinh</th>
                        <th>Ngành nộp hồ sơ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt = 1; while($row = mysqli_fetch_assoc($resultchuaduyet)): ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo $row['ho_ten']; ?></td>
                            <td><?php echo $row['nganh_xet_tuyen']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="bang">
            <h3>Hồ Sơ Đã Duyệt: <?php echo $sduyet; ?> hồ sơ</h3>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên học sinh</th>
                        <th>Ngành nộp hồ sơ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt = 1; while($row = mysqli_fetch_assoc($resultduyet)): ?>
                        <tr>
                            <td><?php echo $stt++; ?></td>
                            <td><?php echo $row['ho_ten']; ?></td>
                            <td><?php echo $row['nganh_xet_tuyen']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="bang">
            <h3>Hồ Sơ Không Duyệt: <?php echo $skhongduyet; ?> hồ sơ</h3>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ tên học sinh</th>
                        <th>Ngành nộp hồ sơ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt = 1; while($row = mysqli_fetch_assoc($resultkhongduyet)): ?>
                        <tr>
                            <td><?php echo  $stt++; ?></td>
                            <td><?php echo $row['ho_ten']; ?></td>
                            <td><?php echo $row['nganh_xet_tuyen']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>
    </main>
    <footer>
        <p>Bản quyền © 2024 TEXCLOTHING. Được thiết kế bởi NGUYỄN HỮU TRƯỜNG và PHÙNG ĐÌNH TUẤN.</p>
    </footer>
</body>
</html>
<?php
    mysqli_close($conn);
?>
