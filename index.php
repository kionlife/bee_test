<?php

$controller = "todo";
$function = "index";

require_once  'config/dbConfig.php';
if (isset($_GET['controller']) && !empty($_GET['controller'])) {
    $controller = $_GET['controller'];
}

if (isset($_GET['function']) && !empty($_GET['function'])) {
    $function = $_GET['function'];
}

if (file_exists('controller/'.$controller.'.php')) {
    include('controller/'.$controller.'.php');
    $class = $controller.'Controller';
    $obj = new $class();
    if (method_exists($class, $function)) {
        $obj->$function();
    } else {
        echo 'Function not found';
    }
} else {
    echo 'Controller not found';
}

?>