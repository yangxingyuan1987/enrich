<?php
session_start();
include_once "settings.php";
include_once "functions.php";
/*$x = 6;

$rates = flexLevelUp(0.1, 0.3, 0.6, $x);
print_r($rates);
echo "<br><br>";
$cost =1000.0;
$fixed = 0.01;
$n=4;
$step =4;
$t =0.0;
$t1 =0.0;
$lt = 0.0;
for ($i = 1; $i <=$x; $i++)
{
    echo "Level $i: $n --- ". $rates[$i-1] . " --- ".$cost*$rates[$i-1] ." --- ". $n*$cost*$rates[$i-1];
    $t += $n*$cost*$rates[$i-1];
    echo " --- $t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "$i: $n --- ". $fixed . " --- ".$cost*$fixed ." --- ". $n*$cost*$fixed;
    $t1 += $n*$cost*$fixed;
    echo " --- $t1<br>";
    $n *= $step;
}*/
$users = init(4, 2);
$user = new user('u1','u0');
echo toJSON($users);
?>
