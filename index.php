<?php
include('config.php');

if(isset($_GET['p'])){
$page = $_GET['p'];
$page = "{$page}.honour.php";
if(file_exists($page)){
    include ($page);
}else{
    include ('404.php');
}
}else{
include 'index.honour.php';
}?>
<script src="//code.tidio.co/fzvphyhscbeq8gjee4rednwnabddp6ay.js" async></script>