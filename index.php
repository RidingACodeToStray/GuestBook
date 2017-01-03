<?php 
$conn = mysqli_connect("localhost","root","","html5-8");
$conn->query("set names utf8");

$type = $_GET['type'];
switch ($type) {
	case 'add'://添加数据
		$name = $_GET['name'];
		$con = $_GET["con"];
		$sql = "INSERT INTO user (name,con) VALUES('{$name}','$con')";
		$conn->query($sql);
		if (mysqli_affected_rows($conn)>0) {
			echo '{"error":0,"id":'.mysqli_insert_id($conn).'}';
		}else{
			echo '{"error":1}';
		}
		break;
	case 'count'://获取总数
		$sql = "SELECT COUNT(id) AS count FROM user";
		$ret = $conn->query($sql);
		$count = $ret->fetch_assoc()['count'];
		echo '{"error":0,"count":'.$count.'}';
		break;
	case 'del'://删除
		$id = $_GET['id'];
		$sql = "DELETE FROM user WHERE id=".$id;
		$conn->query($sql);
		if (mysqli_affected_rows($conn)>0) {
			echo '{"error":0}';
		}else{
			echo '{"error":1}';
		}
		break;
	case 'get':
		$page = $_GET['page'];//获取第几页
		$num = $_GET['num'];//获取每一页多少条
		$p = ($page-1)*$num;//计算重哪一条开始获取

		$sql = "SELECT * FROM user ORDER BY id DESC LIMIT {$p},{$num}";

		$ret = $conn->query($sql);
		if (mysqli_affected_rows($conn)>0) {
			$error = 0;//0:代表的是获取数据成功
		}else{
			$error = 1;//1:代表的是没有获取的数据
		}

		$arr = array();
		while ($row = $ret->fetch_assoc()) {
			$arr[] = $row;
		}

		$str = json_encode($arr);
		echo '{"error":'.$error.',"data":'.$str.'}';
		break;	
}







?>





