
<!DOCTYPE html>
<html lang="th">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Language" content="th" />
	<title></title>
</head>
<body>


<?php 

function file_get_contents_utf8($fn) { 
    $opts = array( 
        'http' => array( 
            'method'=>"GET", 
            'header'=>"Content-Type: text/html; charset=tis-620" 
        ) 
    ); 

    $context = stream_context_create($opts); 
    $result = file_get_contents($fn,false,$context);
    return $result; 
} 
$postdata = http_build_query(
            array(
                'op' => 'precourse',
                'precourse' => '204'
            )
        );
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        $context  = stream_context_create($opts);
        $semester=Session::get('semester');
        $year=substr(Session::get('year'),-2);
        $result = file_get_contents('https://www3.reg.cmu.ac.th/regist'.$semester.$year.'/public/search.php?act=search', false, $context);
//header("Content-Type: text/html; charset=tis-620"); 
//$tPath = "www3.reg.cmu.ac.th/regist257/public/stdtotal.php?var=maxregist&COURSENO=204101&SECLEC=002&SECLAB=000"; 
//$result = file_get_contents_utf8("https://".$tPath); 

/*if( $result == false){ 
    header("Location: https://".$tPath); // fallback 
    exit(); 
} 
else{ 
    echo mb_ereg_replace("http","https",$result); 
} 
*/
//$result = mb_convert_encoding($result, 'HTML-ENTITIES', "tis-620");
//echo $result;
//echo strlen($result);
//echo "sub".substr($result,100,6);

//echo "countline".$count = substr_count($result, "\n");;

$line=preg_split("/((\r?\n)|(\r\n?))/", $result);  
$count=count($line);
echo "line=".$count;
echo "line".$line[100];

for ($i=0; $i < $count; $i++) { 
	echo $line[$i];
}
/*
//echo $content[1];

for ($i=0; $i < $count; $i++) { 
	echo $content[$i];
}

for ($i=0; $i < $count; $i++) { 
	//$pattern = '<td width="22" height="4" align="center">';

//preg_match($pattern, substr($line[$i],3), $matches[$i], PREG_OFFSET_CAPTURE);
//print_r($matches[$i]);
$pattern='/<td width="22" height="4" align="center">(?P<digit>\d+)</td>/';
preg_match($pattern, $line[$i], $matches);
//preg_match('/(?P<name>\w+): (?P<digit>\d+)/', $str, $matches);

}
*/
//$pattern='<td width="22" height="4" align="center">/(?P<digit>\d+)/</td>';
//$pattern='/^[22]/';
//preg_match($pattern, $result, $matches);

//print_r($matches);

$a_cells = array_slice(preg_split('/(?:<\/td>\s*|)<td[^>]*>/', $result), 1);
$a_cells1 = array_slice(preg_split('/(?:<\/span>\s*|)<span[^>]*>/', $result), 1);
 
print_r($a_cells);
print_r($a_cells1);
//echo "tets=".$a_cells[10];
$n=count($a_cells1);
$i=2;
?>
<?php

?>
<table>
<tr>
    <th><?php echo "No";?></th>
    <th><?php echo "รหัสวิชา";?></th>
    <th><?php echo "ชื่อวิชา";?></th>
</tr>
<?php
while ($i<=$n) {
    
?>
<tr>
    <td><?php echo $i;?></td>
        <?php
        //$id = substr($a_cells1[$i], 1, 6);  // returns "abcde"
        $ex=explode( " ", $a_cells1[$i] )

        ?>
        <td><?php echo $ex[1];?></td>
        <?php $course = substr($a_cells1[$i], 12, -10);
                 $course = substr($course, 0, -14); ?>
    <td><?php echo $course;?></td>
    <?php $i=$i+3;?>
</tr>

<?php

}

?>
</table>
<table>
<tr>
    <th><?php echo "No";?></th>
    <th><?php echo "วิชา";?></th>
    <th><?php echo "ตอน";?></th>
    <th><?php echo "อาจารย์";?></th>
    <th><?php echo "fอาจารย์";?></th>
    <th><?php echo "lอาจารย์";?></th>

</tr>
<?php
$n=count($a_cells);
$i=2;
while ($i<=$n) {
    
?>
<tr>
    <td><?php echo $i;?></td>      
    <td><?php echo $a_cells[$i]; $i=$i+1;?></td>
    <td><?php echo $a_cells[$i]; $i=$i+7;?></td>
    <?php
    $ex=explode( " ", $a_cells[$i] );
    $f=$ex[0];
    $lname=$ex[1];

    ?>
    <td><?php echo $a_cells[$i]; $i=$i+12;?></td>
    <td><?php echo $f;?></td>
    <td><?php echo $lname;?></td>
    
</tr>

<?php

}

?>
</table>
</body>
</html>