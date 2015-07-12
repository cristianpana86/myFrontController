<?php

namespace CPANA\myFrontController\login;

if(isset($_COOKIE['PageLogin'])) {
    if(LoginUser::validateCookie($_COOKIE['PageLogin'])) {
        echo "Pagina secretaaa";
        echo '<form method="POST" action="logout.php"><button type="submit">Log out!</button></form> ';
    }
}else{
        header('Location: index.php');
    die();
}


?>
