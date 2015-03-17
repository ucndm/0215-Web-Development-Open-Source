<?php
header('Content-type: text/plain');

$var1 = 'test';
$var2 = 0;
$var3 = 2.34;
$var4 = array();
$var5 = false;
$var6 = '';
$var7;

echo("Testing variables\n");
echo($var1." is a ".gettype($var1)."\n");
echo($var2." is a ".gettype($var2)."\n");
echo($var3." is a ".gettype($var3)."\n");
echo($var4." is a ".gettype($var4)."\n");
echo(var_dump($var5)." is a ".gettype($var5)."\n");

?>

Array from string:
<?php echo($var1[2]);?>


Adding
<?php echo($var2 + $var3);?>

Adding 2
<?php echo($var1 + $var2);?>


Boolean
1:<?php echo ($var1 == true) ? "True" : "False";?>

2:<?php echo ($var2 == true) ? "True" : "False";?>

3:<?php echo ($var3 == true) ? "True" : "False";?>

4:<?php echo ($var4 == true) ? "True" : "False";?>

5:<?php echo ($var5 == true) ? "True" : "False";?>

6:<?php echo ($var6 == true) ? "True" : "False";?>

7:<?php echo ($var7 == true) ? "True" : "False";?>













