<?php 
 // Menjalankan perintah dir
$hasil = shell_exec('dir');
//echo $hasil;
?> 

<?php
//$perintah = "C:\\Users\\dedyr\\AppData\\Local\\Programs\\Python\\Python312\\python.exe C:\\xampp\\htdocs\\machine_learning\\tes_python.py";
$perintah = "C:\\Users\\ASUS\\AppData\\Local\\Programs\\Python\\Python312\\python.exe C:\\xampp\\htdocs\\urban-traffic\\urban_traffic.py";
$output = shell_exec($perintah); 
echo "hasil: <pre>$output</pre>"; 
?>