<?php 
include "dbConnection.php"; 
if(isset($_POST["submit"]))
{

	if(isset($_FILES["choose_image"]) && $_FILES["choose_image"]["error"] == 0)
	{
		$allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
		$filename = $_FILES["choose_image"]["name"];
	    $filetype = $_FILES["choose_image"]["type"];
	    $filesize = $_FILES["choose_image"]["size"];

	    // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) 
        	die("Error: Please select a valid file format.");

        // Verify MYME type of the file
        if(in_array($filetype, $allowed))
        {
        	if(file_exists("images/" . $_FILES["choose_image"]["name"]))
        	{
                echo $_FILES["choose_image"]["name"] . " is already exists.";
            } 
            else
            {
            	$a=new dbConnection();
				$result=$a->insert(203, $_FILES["choose_image"]["name"]);
				

            	move_uploaded_file($_FILES["choose_image"]["tmp_name"], __DIR__."/images/" . $_FILES["choose_image"]["name"]);
                echo "Your file was uploaded successfully.";
                
            }
        }
        else
        {
        	echo "Error: There was a problem uploading your file. Please try again."; 
        }
	}
	else
        {
        	echo "Error: " . $_FILES["choose_image"]["error"];
        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
	<meta charset="UTF-8">
	<title>upload image</title>
</head>
<body>
	<center>
		<form action="hello.php" method="post" enctype="multipart/form-data">
			<input id="choose_image" type="file" name="choose_image" value="choose_image" onchange="readURL(this);"><br><br>
            <img id="blah" src="#" alt="your image" /><br>
			<input type="submit" value="OK" name="submit">
		</form>
	</center>
    <script>
        
        function readURL(input) {
        if (input.files && input.files[0]) 
        {
            var extension_ss = ["jpg", "jpeg", "gif", "png"];


            if(extension_ss.includes(input.value.split('.')[1]))
            {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);

            }
            else
            {
                alert("invalid file format");
                document.getElementById("choose_image").value = "";
            }
        }
    }

    function getFile(filePath) {
        return filePath.substr(filePath.lastIndexOf('\\') + 1).split('.')[0];
    }

    function getoutput() {
        outputfile.value = getFile(inputfile.value);
        extension.value = inputfile.value.split('.')[1];
    }
    </script>
</body>
</html>