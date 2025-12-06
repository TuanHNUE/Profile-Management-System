<?php  
	include "connectdb.php";
?>
<?php  
	function danh_sach_tai_khoan(){
		global $conn;
		$ds = [];
		$sql = "SELECT * FROM `dulieutaikhoan` WHERE 1";
		$kq = mysqli_query($conn, $sql);
		if (mysqli_num_rows($kq) > 0) {
			while($row = mysqli_fetch_array($kq)){
				$ds[] = $row;
			}
			return $ds;
		}
		else{
			return 0;
		}
	}
	function lay_thong_tin_tk_qua_id($id){
		global $conn;
		$ds = [];
		$sql = "SELECT * FROM `dulieutaikhoan` WHERE `id` = '$id'";
		$kq = mysqli_query($conn,$sql);
		if(mysqli_num_rows($kq) > 0){
			$row = mysqli_fetch_array($kq);
			return $row;
		}
		else{
			return 0;
		}
	}
	function check_exist_account($username){
		global $conn;
		$sql = "SELECT * FROM `dulieutaikhoan` WHERE `taikhoan` = '$username'";
		$kq = mysqli_query($conn,$sql);
		if(mysqli_num_rows($kq) > 0){
			return 1;
		}
		else{
			return 0;
		}
	}
	function check_dang_nhap($username, $password){
		global $conn;
		$sql = "SELECT * FROM `dulieutaikhoan` WHERE `taikhoan` = '$username' and `matkhau` = '$password'";
		$kq = mysqli_query($conn,$sql);
		if(mysqli_num_rows($kq) > 0){
			return 1;
		}
		else{
			return 0;
		}
	}
	function lay_tai_khoan($tk, $mk){
		global $conn;
		$sql = "SELECT * FROM `dulieutaikhoan` WHERE `taikhoan` = '$tk' and `matkhau` = '$mk'";
		$kq = mysqli_query($conn,$sql);
		if(mysqli_num_rows($kq) > 0){
			$row = mysqli_fetch_array($kq);
			return $row;
		}
		else{
			return 0;
		}
	}
	function lay_du_lieu($tk){
		global $conn;
		$sql = "SELECT * FROM `dulieutaikhoan` WHERE `taikhoan` = '$tk'";
		$kq = mysqli_query($conn,$sql);
		if(mysqli_num_rows($kq) > 0){
			$row = mysqli_fetch_array($kq);
			return $row;
		}
		else{
			return 0;
		}
	}
	function kiem_tra_dang_nhap(){
		if(isset($_SESSION['tk'])){
			return 1;
		}
		else{
			return 0;
		}
	}
	function lay_ho_so_thi_sinh_qua_id($id){
		global $conn;
		$sql = "SELECT * FROM ho_so_thi_sinh WHERE id = $id";
		$kq = mysqli_query($conn,$sql);
		if(mysqli_num_rows($kq) > 0){
			$row = mysqli_fetch_array($kq);
			return $row;
		}
		else{
			return 0;
		}
	}
	function lay_ho_so_qua_id($id){
		global $conn;
		$sql = "SELECT * FROM ho_so_xet_tuyen WHERE id = $id";
		$kq = mysqli_query($conn,$sql);
		if(mysqli_num_rows($kq) > 0){
			$row = mysqli_fetch_array($kq);
			return $row;
		}
		else{
			return 0;
		}
	}
	function check_ten_nganh($ten_nganh){
		global $conn;
		$sql = "SELECT * FROM ho_so_xet_tuyen WHERE ten_nganh = '$ten_nganh'";
		$kq = mysqli_query($conn,$sql);
		if(mysqli_num_rows($kq) > 0){
			return 1;
		}
		else{
			return 0;
		}
	}
	function cap_nhat_ho_so($ten_nganh, $thoi_gian_bat_dau, $thoi_gian_ket_thuc, $khoi_xet_tuyen,$edit_id){
		global $conn;
		$sql_update = "UPDATE ho_so_xet_tuyen SET ten_nganh = '$ten_nganh', thoi_gian_bat_dau = '$thoi_gian_bat_dau', thoi_gian_ket_thuc = '$thoi_gian_ket_thuc', khoi_xet_tuyen = '$khoi_xet_tuyen' WHERE id = '$edit_id'";
            if (mysqli_query($conn, $sql_update)) {
                echo "<script>alert('Hồ sơ đã được cập nhật thành công.');</script>";
            } else {
                echo "<script>alert('Lỗi cập nhật hồ sơ');</script>";
            }
	}
	function them_ho_so($ten_nganh, $thoi_gian_bat_dau, $thoi_gian_ket_thuc, $khoi_xet_tuyen){
		global $conn;
		$sql_insert = "INSERT INTO ho_so_xet_tuyen (ten_nganh, thoi_gian_bat_dau, thoi_gian_ket_thuc, khoi_xet_tuyen) VALUES ('$ten_nganh', '$thoi_gian_bat_dau', '$thoi_gian_ket_thuc', '$khoi_xet_tuyen')";
            if (mysqli_query($conn, $sql_insert)) {
                echo "<script>alert('Hồ sơ đã được thêm thành công.');</script>";
            } else {
                echo "<script>alert('Lỗi thêm hồ sơ');</script>";
            }
	}
	function hien_an($id){
		global $conn;
		$sqlhienan = "SELECT trang_thai FROM ho_so_xet_tuyen WHERE id=$id";
        $resulthienan = mysqli_query($conn, $sqlhienan);
        if ($resulthienan && mysqli_num_rows($resulthienan) > 0) {
            $row = mysqli_fetch_assoc($resulthienan);
            $trangthaimoi = ($row['trang_thai'] == 'hiện') ? 'ẩn' : 'hiện';
            $sqlupdate = "UPDATE ho_so_xet_tuyen SET trang_thai='$trangthaimoi' WHERE id=$id";
            if (mysqli_query($conn, $sqlupdate)) {
                echo "<script>alert('Trạng thái hồ sơ đã được cập nhật.');</script>";
            } else {
                echo "<script>alert('Lỗi: Không thể cập nhật trạng thái.');</script>";
            }
        } else {
            echo "<script>alert('Lỗi: Không tìm thấy hồ sơ.');</script>";
        }
	}
	function xoa_nop_ho_so($id){
		global $conn;
		$sql_delete = "DELETE FROM `ho_so_thi_sinh` WHERE `id` = '$id'";
        if (mysqli_query($conn, $sql_delete)) {
            echo "<script>alert('Xóa hồ sơ thành công!');</script>";
        } else {
            echo "<script>alert('Xóa hồ sơ thất bại!');</script>";
        }
	}
	function xoa_trang_chu($id){
		global $conn;
		$sqlxoa = "DELETE FROM `ho_so_xet_tuyen` WHERE `id` = '$id'";
        if (mysqli_query($conn, $sqlxoa)) {
            echo "<script>alert('Xóa hồ sơ thành công!');</script>";
        } else {
            echo "<script>alert('Xóa hồ sơ thất bại!');</script>";
        }
	}
?>