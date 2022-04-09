<html>
<head>
    <?php include ("dbaccess.php"); ?>
    <style>
    body {
        background-color: black;
        color: #3a4472;
        font-size: 20px;
        font-family: arial;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
    textarea {
        background-color: black;
        color: #3a4472;
        font-size: 20px;
        font-family: arial;
        overflow:hidden;
        border: 3px rgb(55,55,55) solid;
        word-wrap: break-word;
    }
    input[type='button'] {
        background-color: rgb(25,25,25);
        color: #3a4472;
        font-size: 20px;
        font-family: arial;
        border: 3px rgb(55,55,55) solid;
        word-wrap: break-word;
        width:10%;
        height:16%;
    }
    input[type=submit] {
        padding: 2px 4px;
        background-color: rgb(25,25,25);
        color: #3a4472;
        font-size: 20px;
        font-family: arial;
        border: 3px rgb(55,55,55) solid;
    }
    input[type=password] {
        padding: 2px 4px;
        background-color: rgb(25,25,25);
        color: #3a4472;
        font-size: 20px;
        font-family: arial;
    }
    .closebutton {
        position:absolute;position:fixed;bottom:0%;right:0px;font-size:36px;opacity:0.95;
    }
    .tag_button {
        border-radius: 15px 15px;
        background: #132339;
        color:#4a6591;
        padding: 5px;
        line-height: 35px;
        margin:0px;
        text-align: center;
        width: 100px;
        height: 50px;
        text-decoration: none;
    }
    a.tag_button:link {color:#4a6591}
    a.tag_button:visited {color:#4a6591}
    a.tag_button:hover {color:#4a6591}
    a.tag_button:active {color:#4a6591}
    .formatting_1 {
        line-height: 40px;
    }
</style>
<script>
    this.name = "tags_window";
    function set_tag(tag_name) {
        document.getElementById('new_tag').value = tag_name;
        document.getElementById('set_tags').submit();
    }
    function set_del(tag_name) {
        document.getElementById('del_tag').value = tag_name;
        document.getElementById('set_tags').submit();
    }
    function closewindow() {
        window.close();
    }
</script>
</head>
<body>
<span class="formatting_1">
<form name='set_tags' id='set_tags' action='tags.php' method='POST'>
<?php
    $url = '';
    if (isset($_REQUEST['url'])) {
        $url = $_REQUEST['url'];
        $url = str_replace('javascript:subform("', '', "$url");
        $url = str_replace('")', '', "$url");
        $url = str_replace('/var/www/html/general/medialink/medialink/', '', "$url");
        $url = str_replace('http://localhost/general/medialink/medialink/', '', "$url");
        $url = str_replace('file:///var/www/html/general/medialink/medialink/', '', "$url");
        $url = str_replace('/general/medialink/medialink/', '', "$url");
        $url = str_replace('file://', '', "$url");
    }
?>
<center>Url: <input type='textarea' name='url' id='url' style='font-size:20px;background-color:black;color: #3a4472;width:1200px' value='<?php echo $url ?>'></input><br>Tags: 
<?php
    if (isset($_REQUEST['new_tag']) && $_REQUEST['new_tag'] != '' && $url != '') {
        $tag = $_REQUEST['new_tag'];
        $url_mod = str_replace('http://localhost/general/medialink/medialink/', '', "$url");

        $sql = "CREATE TABLE `mediagallery`.`$tag` (`id` INT NOT NULL AUTO_INCREMENT,
        `url` VARCHAR(500) NULL, PRIMARY KEY (`id`));";
        $result = $conn->query($sql);

        $sql = "INSERT INTO `mediagallery`.`$tag` (`url`) VALUES ('$url_mod');";
        $result = $conn->query($sql);
    }

    if (isset($_REQUEST['del_tag']) && $_REQUEST['del_tag'] != '' && $url != '') {
        $tag = $_REQUEST['del_tag'];
        $sql = "DELETE FROM `mediagallery`.`$tag` WHERE (`url` = '$url');";
        $result = $conn->query($sql);
    }

    $sql = "SHOW TABLES;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) {
            $table = $row['Tables_in_mediagallery'];
            $sql2 = "SELECT * FROM ".$table." WHERE url='$url'";
            $result2 = $conn->query($sql2);

            if ($result2->num_rows > 0) { 
                while($row2 = $result2->fetch_assoc()) {        
                    echo "&nbsp;<span class='tag_button'>".$table;
                    echo " <a href=\"javascript:set_del('".$table."')\" class='tag_button'>[X]</a></span>";
                }
            }
        }
    }    
?>
<br>
New tag: <input type='textarea' name='new_tag' id='new_tag' style='font-size:20px;background-color:black;color: #3a4472;'></input>
</span>
<br>
<input type='hidden' name='del_tag' id='del_tag' />
<br><input type='submit' value='submit' style='font-size:20px' /><br><br>
<?php
    $sql = "SHOW TABLES;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()) {
        $current_tag = $row['Tables_in_mediagallery'];
        if ($current_tag != "access" && $current_tag != "tags") {
            echo " <a href=\"javascript:set_tag('".$current_tag."')\" class='tag_button'>$current_tag</a>";
        }
      }
    }  
?>
</center>
</form>
</body>