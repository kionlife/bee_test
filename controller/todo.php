<?php
require_once 'baseController.php';
class todoController  extends BaseController {
	private $check; //User logged?
    public function __construct() {
        parent::__construct();
        include('model/todoModel.php');
        $this->obj = new homeModel();
		$this->check = $this->obj->check();
    }
    public function index() {
		if (isset($_GET['order'])) {
			$order = $_GET['order'];
		} else {
			$order = 'name';
		}
		

		if (isset($_GET['page'])) {
            $page = $_GET['page'];
        } else {
            $page = 1;
        }
		
		if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        } else {
            $sort = 'asc';
        }
		
		
		$records_per_page = 3;
        $offset = ($page - 1) * $records_per_page;
		
		
		$data = $this->check;
        $this->loadView('view/partials/header.php', $data);
		
		$data = $this->obj->pagination($offset, $records_per_page, $order, $sort, $page);	
        $this->loadView('view/partials/todo.php', $data);
        $this->loadView('view/partials/footer.php');
    }
	
    public function fetch() {
        $data = $this->obj->todo();
        exit();
    }
	
    public function create() {   
        if (isset($_POST) && !empty($_POST)) {
            $todo = $_POST['todo'];
            $email = $_POST['email'];
            $name = $_POST['name'];
            $data = $this->obj->addTodo($todo, $email, $name);
                    if ($todo) {
            $data = 'Todo is created';
        } else {
            $data = 'Todo is not created!';
        }
		$this->loadView('view/partials/header.php');
		$this->loadView('view/partials/success.php', $data);
		$this->loadView('view/partials/footer.php');

        }
    }
    public function delete() {
		if ($this->check == 1) {
        $id = $_GET['id'];
        $todo = $this->obj->delTodoById($id);
        if ($todo) {
            $data = 'Todo is successful deleted';
        } else {
            $data = 'Todo is not deleted!';
        }
		$this->loadView('view/partials/header.php');
		$this->loadView('view/partials/success.php', $data);
		$this->loadView('view/partials/footer.php');

		} else {
			$this->loadView('view/partials/login.php');
		}
		
    }
    public function edit() {
	  if ($this->check == 1) {
		  
        if (isset($_GET['id']) && !empty($_GET['id'])) {
			
            $id = $_GET['id'];
			
			$data = $this->check;
			$this->loadView('view/partials/header.php', $data);
            $data = $this->obj->getTodoById($id);
			$this->loadView('view/partials/edit.php', $data);
			$this->loadView('view/partials/footer.php');
            exit();
        }   
	  } else {
			$this->loadView('view/partials/login.php');
	  }      
    }
	
    public function update() {
	  if ($this->check == 1) {
        if (isset($_POST) && !empty($_POST)) {
            $id = $_POST['id'];
            $todo = $_POST['todo'];  
			if(isset($_POST['status']) &&  $_POST['status'] == 1) 
			{
				$status = $_POST['status'];  
			} else {
				$status = 0;  
			}

            $data = $this->obj->updateTodoById($id, $todo, $status);
           
		    if ($data) {
				$data = 'Todo is successful updated';
			} else {
				$data = 'Todo is not updated!';
			}
			$this->loadView('view/partials/header.php');
			$this->loadView('view/partials/success.php', $data);
			$this->loadView('view/partials/footer.php');
		   
            exit();
        }
	  }
    }

	public function auth() {
		$login = $_POST['login'];
        $pass = $_POST['pass']; 
		$data = $this->obj->auth($login, $pass);
		if ($data === 'failed') {
			$data = 'Login failed!';
			
			$this->loadView('view/partials/header.php');
			$this->loadView('view/partials/success.php', $data);
			$this->loadView('view/partials/footer.php');
		}
	}

	public function login() {
		$check = $this->obj->check();
		if ($check == 'error') {
			$this->loadView('view/partials/login.php');
		} else {
			header('Location: /');
		}
	}
	
	public function check() {
		$check = $this->obj->check();
	}
	
	public function logOut() {
		if ($this->check == 1) {
			if (isset($_COOKIE['hash']) && isset($_COOKIE['user_id'])) {
				unset($_COOKIE['hash']); 
				unset($_COOKIE['user_id']); 
				setcookie('hash', null, -1, '/'); 
				setcookie('user_id', null, -1, '/'); 
				return true;
				header('Location: /');
			}
		}
	}
}