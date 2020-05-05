<?php 
if ($data == 1) { 
	$logged = '<a class="nav-link" href="index.php?function=logOut">Log Out</a>';
} else {
	$logged = '<a class="nav-link" href="index.php?function=login">Login</a>';
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/ff3984ad36.js" crossorigin="anonymous"></script>   
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="public/css/style1.css">
    <title>Todo List</title>
</head>
<body>

    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container">

            <a class="navbar-brand text-danger font-weight-bold " href="/">ToDo List</a>
            

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-pills ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home </a>
                    </li>
                    <li class="nav-item">
                        <?=$logged;?>
                    </li>
					
                </ul>
            </div>
        </div>
    </nav>