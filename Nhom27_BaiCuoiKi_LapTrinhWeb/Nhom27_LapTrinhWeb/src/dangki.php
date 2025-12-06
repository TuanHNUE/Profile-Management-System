<?php  
    include "../../Nhom27_LapTrinhWeb/connectdb.php";
    include "../../Nhom27_LapTrinhWeb/function.php";
?>
<?php
    global $conn;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Đăng ký</title>
        <link rel="icon" href="https://cdn.glitch.global/f019bcd3-abb6-43fe-bbcc-2654d25a9106/logo.png.png?v=1671271634762"/>
        <link rel="stylesheet" type="text/css" href="css/dangki.css">
    </head>
    <body>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h1>Đăng ký</h1>
            <input type="text" name="hovaten" placeholder="Họ và tên" required><br>
            <input type="text" name="taikhoan" placeholder="Tài khoản" required><br>
            <input type="text" name="matkhau" placeholder="Mật khẩu" required><br>
            <input type="text" name="nhaplaimatkhau" placeholder="Nhập lại mật khẩu" required><br>
            <div>
                <div>Bạn là </div>
                <select name="loaitaikhoan" class="loaitaikhoan">
                    <option value="hocsinh">Học sinh</option>
                    <option value="admin">Admin</option>
                    <option value="giaovien">Giáo viên</option>
                </select>
            </div>
            <a href="dangnhap.php">Đăng nhập</a>
            <button type="submit" name="submit">Đăng ký</button>
        </form>


        <?php 
            if (isset($_POST['submit'])) {
                $hovaten = $_POST['hovaten'];
                $taikhoan = $_POST['taikhoan'];
                $matkhau = $_POST['matkhau'];
                $matkhaumahoa = md5($matkhau);
                $_SESSION['taikhoan'] = $_POST['taikhoan'];
                $loaitaikhoan = $_POST['loaitaikhoan'];

                if ($_POST['matkhau'] != $_POST['nhaplaimatkhau']) {
                    echo "<script>alert('Mật khẩu nhập lại không giống nhau.');</script>";
                } elseif (check_exist_account($taikhoan)) {
                    echo "<script>alert('Tên tài khoản đã tồn tại.');</script>";
                } else{
                    $sql = "INSERT INTO `dulieutaikhoan`(`ho_ten_nguoi_dung`, `taikhoan`, `matkhau`, `loaitaikhoan`) 
                        VALUES ('$hovaten','$taikhoan','$matkhaumahoa','$loaitaikhoan')";
                    if (mysqli_query($conn, $sql)) {
                        echo "<script>alert('Đăng ký thành công.');</script>";
                    } else {
                        echo "<script>alert('Đăng ký thất bại.');</script>";
                    }
                }
            }
            mysqli_close($conn);
        ?>  
    </body>
</html>
