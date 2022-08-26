<?php
//首先是获取到了数据
$string=$_POST['S'];
function scandirFolder($path)
{
    $list     = [];
    $temp_list = scandir($path);
    foreach ($temp_list as $file)
    {
        //排除根目录
        if ($file != ".." && $file != ".")
        {
            if (is_dir($path . "/" . $file))
            {
                //子文件夹，进行递归
                $list[$file] = scandirFolder($path . "/" . $file);
            }
            else
            {
                //根目录下的文件
                $list[] = $file;
            }
        }
    }
    return $list;
}


$pdf_list = scandirFolder('./pdf');
$img_list = scandirFolder('./img');
$result=Array();
foreach ($pdf_list as $k=>&$val){
	
	if (strpos($pdf_list[$k], $string) !== false) {
	  
		array_push($result,$pdf_list[$k]);
	}else{
	    continue;
	}
	
}
echo json_encode($result);

?>