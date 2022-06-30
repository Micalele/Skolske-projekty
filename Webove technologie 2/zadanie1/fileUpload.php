<?php
if ($_FILES["file"]["error"]>0){
    echo "Error:" . $_FILES["file"]["error"] . "<br>";
}
else {
    if (file_exists("/home/xmichalem/public_html/files/" . $_FILES["file"]["name"])==true) {
        $name = date(DATE_ATOM) . $_FILES["file"]["name"];
        echo "Upload:" . $name . "<br>";
        echo "Type:" . $_FILES["file"]["type"] . "<br>";
        echo "Size:" . $_FILES["file"]["size"]/1024 . "Kb<br>";
        echo "Stored in:" . $_FILES["file"]["tmp_name"] . "<br><br>";
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "/home/xmichalem/public_html/files/" . $name))
            echo "File moved";
        if (file_exists("/home/xmichalem/public_html/files/" . $name) == false) echo "Something went wrong!!!";
        echo "<br><a href='mail.php'>Back to main page</a>";
    }
    else{
        echo "Upload:" . $_FILES["file"]["name"] . "<br>";
        echo "Type:" . $_FILES["file"]["type"] . "<br>";
        echo "Size:" . $_FILES["file"]["size"]/1024 . "Kb<br>";
        echo "Stored in:" . $_FILES["file"]["tmp_name"] . "<br><br>";
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "/home/xmichalem/public_html/files/" . $_FILES["file"]["name"]))
            echo "File moved";
        if (file_exists("/home/xmichalem/public_html/files/" . $_FILES["file"]["name"]) == false) echo "Something went wrong!!!";
        echo "<br><a href='mail.php'>Back to main page</a>";
    }
}