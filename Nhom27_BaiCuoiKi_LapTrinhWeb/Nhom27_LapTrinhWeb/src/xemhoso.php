<?php  
    include "../../Nhom27_LapTrinhWeb/connectdb.php";
    include "../../Nhom27_LapTrinhWeb/function.php";
    session_start();
    if(!kiem_tra_dang_nhap()){
        header("location: dangnhap.php");
    }
    global $conn;
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
    <title>Xem Hồ Sơ</title>
    <link rel="icon" href="https://cdn.glitch.global/f019bcd3-abb6-43fe-bbcc-2654d25a9106/logo.png.png?v=1671271634762"/>
    <link rel="stylesheet" type="text/css" href="css/xemhoso.css">
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
    <a href="nophoso.php"><button class="maunut"><img width="25px" height="20px" src="picture/back.png"></button></a>
    <h2>Hồ sơ đã nộp</h2>
        <?php 
            $idchitiet = $_SESSION['idchitiet'];
            $sql = "SELECT * FROM `ho_so_thi_sinh` WHERE `id` = '$idchitiet'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='vien1'>";
                            echo "<div class='hocba'>";
                                echo "<div class='fileanh'>";
                                    echo "<img src='" . $row['file_hoc_ba'] . "' width='200px' height='300px'>";
                                    echo "<div class='taixuong'>";
                                        echo "<a href='" . $row['file_hoc_ba'] . "' download><button>Tải xuống</button></a>";
                                    echo "</div>";
                                echo "</div>";    
                                echo "<div>";
                                    echo "<h1>Họ và tên: ". $row['ho_ten'] ."</h1><br>";
                                    echo "<h1>Nghành xét tuyển: ". $row['nganh_xet_tuyen'] ."</h1><br>";
                                    echo "<h1>Khối xét tuyển: ". $row['khoi_xet_tuyen'] ."</h1><br>";
                                    if ($row['khoi_xet_tuyen'] == "A00") {
                                        echo "<h1>Điểm toán: " . $row['diem_toan'] . "</h1><br>";
                                        echo "<h1>Điểm lý: " . $row['diem_ly'] . "</h1><br>";
                                        echo "<h1>Điểm hóa: " . $row['diem_hoa']. "</h1><br>";                      
                                    }
                                    elseif ($row['khoi_xet_tuyen'] == "A01") {
                                        echo "<h1>Điểm toán: " . $row['diem_toan'] . "</h1><br>";
                                        echo "<h1>Điểm lý: " . $row['diem_ly'] . "</h1><br>";
                                        echo "<h1>Điểm anh: " . $row['diem_anh'] . "</h1><br>";                        
                                    }
                                    elseif ($row['khoi_xet_tuyen'] == "B00") {
                                        echo "<h1>Điểm toán: " . $row['diem_toan'] . "</h1><br>";
                                        echo "<h1>Điểm hóa: " . $row['diem_hoa'] . "</h1><br>";
                                        echo "<h1>Điểm sinh: " . $row['diem_sinh'] . "</h1><br>";                       
                                    }
                                    elseif ($row['khoi_xet_tuyen'] == "C00") {
                                        echo "<h1>Điểm văn: " . $row['diem_van'] . "</h1><br>";
                                        echo "<h1>Điểm sử: " . $row['diem_su'] . "</h1><br>";
                                        echo "<h1>Điểm địa: " . $row['diem_dia'] . "</h1><br>";                        
                                    }
                                    elseif ($row['khoi_xet_tuyen'] == "D01") {
                                        echo "<h1>Điểm toán: " . $row['diem_toan'] . "</h1><br>";
                                        echo "<h1>Điểm văn: " . $row['diem_van'] . "</h1><br>";
                                        echo "<h1>Điểm anh: " . $row['diem_anh'] . "</h1><br>";                      
                                    }
                                echo "</div>";  
                            echo "</div>";   
                        echo "</div>";
                    }
                }
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
