<!DOCTYPE html>
<html lang="sk">
    <head>
        <link rel="stylesheet" type="text/css" href="css.css">
        <script src="sortName.js"></script>
        <script src="sortSize.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Zadanie1</title>
    </head>
    <body>
        <?php
            $path = "/home/xmichalem/public_html/files" . $_GET["loc"];
            echo "<header><div id='home'><a href=\"mail.php\">HOME</a></div>Directory listing of <b>$path</b><div id='upload'><a href=\"upload.php\">UPLOAD</a></div></header>";
            $dirHandle = @opendir($path);

            $nameArray = array();
            while ($file = @readdir($dirHandle)){
                if($file!=".."){
                    if ($file=="." and $path == "/home/xmichalem/public_html/files");
                    else array_push($nameArray, $file);
                }
            }

            sort($nameArray);
            echo "<table class='table' id='table'><tr><th id='name' onclick='sortName();'>Name▼</th><th id='size' onclick='sortSize();'>Size(Kb)</th><th id='upload'>Uploaded</th></tr>";
            $pc = 0;
            foreach ($nameArray as $item) {
                $pc = $pc + 1;
                $size = round(filesize($path . "/" . $item)/1024, 2);
                $inside =$_GET["loc"] . "/" . $item;
                if (is_dir($path."/".$item)) {
                    if ($item=="." and $path != "/home/xmichalem/public_html/files"){
                        $inside = substr($inside, 0, -1);
                        $inside = substr($inside, 0, -1);
                        do{
                            $inside = substr($inside, 0, -1);
                        } while ($inside[strlen($inside)-1] != "/");
                        $inside = substr($inside, 0, -1);
                        echo "<tr id='r$pc'><td><a id='name$pc' href=\"mail.php?loc=$inside\">$item</a></td><td id='size$pc'></td><td id='update$pc'></td></tr>";
                    }
                    else if ($item!=".") {
                        echo "<tr id='r$pc'><td><a id='name$pc' href=\"mail.php?loc=$inside\">$item</a></td><td id='size$pc'></td><td id='update$pc'></td></tr>";
                    }
                }
                else {
                    $fileModified = date (DATE_ATOM, filemtime($path . "/" . $item));
                    echo "<tr id='r$pc'><td id='name$pc'>$item</td><td id='size$pc'>$size</td><td id='update$pc'>$fileModified</td></tr>";
                }
            }
            echo "</table>";
            closedir($dirHandle);
        ?>
    </body>
</html>