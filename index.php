<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ajax Add/Delete a Record with jQuery Fade In/Fade Out</title>
<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {

	
	$("#FormSubmit").click(function (e) {
			e.preventDefault();
			if($("#contentText").val()==='')
			{
				alert("Please enter some text!");
				return false;
			}
			
			$("#FormSubmit").hide(); 
			$("#LoadingImage").show(); 
			
		 	var myData = 'content_txt='+ $("#contentText").val(); 
			jQuery.ajax({
			type: "POST", 
			url: "response.php", 
			dataType:"text", 
			data:myData, 
			success:function(response){
				$("#responds").append(response);
				$("#contentText").val(''); 
				$("#FormSubmit").show(); 
				$("#LoadingImage").hide(); 

			},
			error:function (xhr, ajaxOptions, thrownError){
				$("#FormSubmit").show(); 
				$("#LoadingImage").hide(); 
				alert(thrownError);
			}
			});
	});

	
	$("body").on("click", "#responds .del_button", function(e) {
		 e.preventDefault();
		 var clickedID = this.id.split('-'); 
		 var DbNumberID = clickedID[1]; 
		 var myData = 'recordToDelete='+ DbNumberID; 
		 
		$('#item_'+DbNumberID).addClass( "sel" ); 
		$(this).hide(); 
		 
			jQuery.ajax({
			type: "POST", 
			url: "response.php", 
			dataType:"text", 
			data:myData,
			success:function(response){
				
				$('#item_'+DbNumberID).fadeOut();
			},
			error:function (xhr, ajaxOptions, thrownError){
				
				alert(thrownError);
			}
			});
	});

});
</script>
<link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="content_wrapper">
<ul id="responds">
<?php

include_once("config.php");


$results = $mysqli->query("SELECT id,content FROM add_delete_record");

while($row = $results->fetch_assoc())
{
  echo '<li id="item_'.$row["id"].'">';
  echo '<div class="del_wrapper"><a href="#" class="del_button" id="del-'.$row["id"].'">';
  echo '<img src="images/icon_del.gif" border="0" />';
  echo '</a></div>';
  echo $row["content"].'</li>';
}


$mysqli->close();
?>
</ul>
    <div class="form_style">
    <textarea name="content_txt" id="contentText" cols="45" rows="5" placeholder="Enter some text"></textarea>
    <button id="FormSubmit">Add record</button>
    <img src="images/loading.gif" id="LoadingImage" style="display:none" />
    </div>
</div>

</body>
</html>
