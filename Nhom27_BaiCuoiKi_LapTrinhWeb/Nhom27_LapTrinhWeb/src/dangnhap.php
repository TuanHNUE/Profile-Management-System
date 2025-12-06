<?php  
    include "../../Nhom27_LapTrinhWeb/connectdb.php";
    include "../../Nhom27_LapTrinhWeb/function.php";
    session_start();
?>
<?php
    global $conn;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="icon" href="https://cdn.glitch.global/f019bcd3-abb6-43fe-bbcc-2654d25a9106/logo.png.png?v=1671271634762"/>
    <link rel="stylesheet" type="text/css" href="css/dangnhap.css">
</head>
<body>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h1>Đăng nhập</h1>
        <input type="text" name="taikhoandangnhap" placeholder="Tài khoản" required><br>
        <input type="text" name="matkhaudangnhap" placeholder="Mật khẩu" required><br>
        <a href="dangki.php">Đăng kí</a>
        <button type="submit" name="submit">Đăng nhập</button>
    </form>
    <?php 
        if (isset($_POST['submit'])) {
            $taikhoandangnhap = $_POST['taikhoandangnhap'];
            $matkhaudangnhap = $_POST['matkhaudangnhap'];
            $matkhaudangnhapmahoa = md5($matkhaudangnhap);
            if(check_exist_account($taikhoandangnhap)){
                if(check_dang_nhap($taikhoandangnhap, $matkhaudangnhapmahoa)){
                    $a = lay_tai_khoan($taikhoandangnhap, $matkhaudangnhapmahoa);
                    $_SESSION['tk'] = $taikhoandangnhap;
                    header('Location: trangchu.php');
                }
                else{
                    echo "<script>alert('Bạn đã sai tên tài khoản hoặc mật khẩu.');</script>";
                }
            }else{
                echo "<script>alert('Tên tài khoản chưa được đăng kí.');</script>";
            }
        }
        mysqli_close($conn);
    ?>
</body>
</html>
