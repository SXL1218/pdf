<?php

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



?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title>pdf 在线预览</title>
 
 <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">  
    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
	 body{
		 background-color: black;
	 }
.container{
	background-color: ghostwhite;
}	
h5{
	text-align: center;
}
   #box{
        width: 380px;
        margin: 30px auto;
        font-family: 'Microsoft YaHei';
        font-size: 14px;
    }

    input{
        width: 260px;
        border: 1px solid #e2e2e2;
        height: 30px;
        float: left;
        background-image: url(image/search.png);
        background-repeat: no-repeat;
        background-size: 25px;
        background-position:5px center;
        padding:0 0 0 40px;
    }
    #search{
        width: 78px;
        height: 32px;
        float: right;
        background: black;
        color: white;
        text-align: center;
        line-height: 32px;
        cursor: pointer;

    }
    .red{
        color: red;
    }
   
</style>
</head>
<body>

<div class="container"> 
<div class="row">
<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 left">
	<h3 style="text-align: center;color: coral;">书架列表</h3>
	<div id="box" class="col-lg-12">
	        <input type="search" name="search"  placeholder="请输入关键字">
	        <div id="search" >搜索</div> 
	         
	    </div>
	    
		<div  class="sear">
		
		</div>
		<h1></h1>
		<p></p>
	<div class="row">
	   
		<?php
		
		foreach ($pdf_list as $k=>&$val){

   echo '
		    
		 <div class="book col-lg-12 col-md-4 col-sm-4 col-xs-4 ">
		
		<a onclick=first("'. $pdf_list[$k] .'")>
		
		<p>'.($k+1).': '. $pdf_list[$k] .'</p>
		
		</a>
		
	</div>
	
		    
		    ';
		    
		}
		
	?>

</div>

</div>

<div class="pdf col-lg-8 col-md-12  col-sm-12  col-xs-12" >
	<h3 class="text-center bookname" style="color: red;"></h3>
<iframe  id ="pdf_page"  name ="pdf_page" width="100%" height="680px"  >
</iframe>
</div>

</div>
</div>

<script type="text/javascript">

var first = function(key){
	var url = "./pdf/"+key+""
	$(window.parent.document).find("#pdf_page").attr("src",url);
	$('.bookname').html(key)
	
} 
$(document).ready(function(key){
	var url = "./pdf/w.pdf";
	$(window.parent.document).find("#pdf_page").attr("src",url);
	$('.bookname').html("w.pdf")
 
});
   
		$("#search").click(function() {
		var s=($("input").val());			
		$.ajax({
		    type: "POST",
		    url: "search.php",
		    data: {S:s},
		    success: function(msg){
							// alert( "Data Saved: " + msg );
						  var data='';
				          if(msg!=''){
				            data = eval("("+msg+")");    //将返回的json数据进行解析，并赋给data
				            if(data.length<=0){
				                 alert( "没有查询到相关书籍")
				            }
				           
				          }
						  else {
							  alert( "没有查询到相关书籍")
							}
							$(".sear").find("*").remove();
							for(let i=0;i<data.length;i++){
								//alert( "Data" + data )
								
								 $('.sear').append('<a class="red" onclick=first("'+data[i]+'")><p>'+data[i]+'</p></a>')
								//$('.span').html(data[i]);
											
												
							}
							
						
								}
				});
		                });
</script>
</body>
</html>