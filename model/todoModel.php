<?php
class homeModel extends dbConnect
{
    public function __construct() {
        parent::__construct();
    }
	
	/*
		Adding item	
	*/
    public function addTodo($todo, $email, $name) {
        $conn = $this->db_conn;
        $todoSql = 'INSERT INTO todos(todo,email,name,status) VALUES ("'.$todo.'","'.$email.'","'.$name.'","0")';
        $data = mysqli_query($conn, $todoSql) or mysqli_error($conn);
        return $data;
    }
	
	/*
		Get item by id	
	*/
    public function getTodoById($id) {
        $conn = $this->db_conn;
        $query = 'SELECT * FROM todos WHERE id="'.$id.'"';
        $res = mysqli_query($conn, $query) or mysqli_error($conn);
        return  mysqli_fetch_assoc( $res );
    }
	
	/*
		Update function for editing item
	*/
    public function updateTodoById($id, $todo, $status) {
        $conn = $this->db_conn;
        $sql = 'UPDATE todos SET todo ="'.$todo.'", status = "'.$status.'" WHERE id ="'.$id.'"';
        $data = mysqli_query($conn, $sql) or mysqli_error($conn);
		if ($data['todo'] != $todo) {
			$sql = 'UPDATE todos SET changed="1" WHERE id ="'.$id.'"';
			mysqli_query($conn, $sql) or mysqli_error($conn);
		}
        return $data;
    }
	
	/*
		Add information about editing by admin	
	*/
    public function updateAdminChanged($id) {
        $conn = $this->db_conn;
        $sql = 'UPDATE todos SET changed ="1" WHERE id ="'.$id.'"';
        $data = mysqli_query($conn, $sql) or mysqli_error($conn);
        return $data;
    }
	
	/*
		Deleting item	
	*/
    public function delTodoById($id) {
        $conn = $this->db_conn;
        $query = 'DELETE FROM todos WHERE id= "'.$id.'"';
        $todo = mysqli_query($conn, $query) or mysqli_error($conn);
        return $todo;
    }
	
	/*
		Authorization	
	*/
    public function auth($login, $pass) {
        $conn = $this->db_conn;
		$password = md5($pass);
        $query = 'SELECT id,password FROM users WHERE name="'.$login.'"';
        $todo = mysqli_query($conn, $query) or mysqli_error($conn);
		$res = mysqli_fetch_assoc($todo);
		
		if ($res['password'] == $password) {
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
			$code = "";
			$clen = strlen($chars) - 1;
			while (strlen($code) < 12) {
				$code .= $chars[mt_rand(0,$clen)];
			}
			$todoSql = 'UPDATE users SET hash="'.$code.'" WHERE id="'.$res['id'].'"';
			$data = mysqli_query($conn, $todoSql) or mysqli_error($conn);
			echo $code;
			setcookie("user_id", $res['id'], time()+60*60*24*30, "/", null, null, true);
			setcookie("hash", $code, time()+60*60*24*30, "/", null, null, true);
			header('Location: /');
		} else {
			return 'failed';
		}
    }
	
	/*
		Check if user logged
	*/
	public function check() {
		if (isset($_COOKIE['user_id']) && isset($_COOKIE['hash'])) {
			$conn = $this->db_conn;
			$query = 'SELECT * FROM users WHERE id="'.$_COOKIE['user_id'].'" AND hash="'.$_COOKIE['hash'].'"';
			$todo = mysqli_query($conn, $query) or mysqli_error($conn);
			$res = mysqli_fetch_assoc($todo);
			if ($res['name']) {
				return 1;
			} else {
				$error = 'error';
				return $error;
			}
		} else {
			$error = 'error';
			return $error;
		}
		
	}
	
	/*
		Get all ToDo items with pagination and ordering
	*/
	public function pagination($offset, $records_per_page, $order, $sort, $page) {
		$todos = [];
		$conn = $this->db_conn;
		$total_pages_query = "SELECT COUNT(*) FROM todos";
        $result = mysqli_query($conn, $total_pages_query);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $records_per_page);
		$data['total_pages'] = $total_pages;
		$sql = "SELECT * FROM todos order by ".$order." ".$sort." LIMIT $offset, $records_per_page";
        $res_data = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_array($res_data)){
            array_push( $todos, $row );
        }
		
		$data['todos'] = $todos;
		$data['order'] = $order;
		$data['sort'] = $sort;
		$data['page'] = $page;
		
		return $data;
	}
}