<html lang="sk">
<head>
    <title>Upload</title>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
<div id="uploadPage">
    <form action="fileUpload.php" method="post" enctype="multipart/form-data">
        <label class="inside">Filename:</label>
        <input class="inside" type="file" name="file" id="file">
        <input id="submit" class="inside" type="submit" name="submit" value="Submit">
    </form>
</div>
</body>
</html>