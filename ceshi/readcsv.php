<?php 
function get_file_line($file_name, $line ){
  $n = 0;
  $handle = fopen($file_name,'r');
  if ($handle) {
    while (!feof($handle)) {
        ++$n;
        $out = fgets($handle, 4096);
        if($line==$n) break;
    }
    fclose($handle);
  }
  if( $line==$n) return $out;
  return false;
}

$result4[]=get_file_line("a.csv", 4);
$result5[]=get_file_line("a.csv", 5);

$str=substr($result4[0],7).substr($result5[0],12,-3);
echo $str;

?> 