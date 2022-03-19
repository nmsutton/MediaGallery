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
</style>
<script>
    function set_del(tag_name) {
        document.getElementById('del_tag').value = tag_name;
        document.getElementById('set_tags').submit();
    }
</script>
</head>
<body>
<form name='set_tags' id='set_tags' action='tags.php' method='POST'>
<?php
    $url = '';
    if (isset($_REQUEST['url'])) {
        $url = $_REQUEST['url'];
        $url = str_replace('javascript:subform("', '', "$url");
        $url = str_replace('")', '', "$url");
        $url = str_replace('http://localhost/general/medialink/medialink/', '', "$url");
        $url = str_replace('file:///var/www/html/general/medialink/medialink/', '', "$url");
        $url = str_replace('/general/medialink/medialink/', '', "$url");
    }
?>
<center>Url: <input type='textarea' name='url' id='url' style='font-size:20px;background-color:black;color: #3a4472;' value='<?php echo $url ?>'></input><br>Tags: 
<?php
    if (isset($_REQUEST['new_tag']) && $_REQUEST['new_tag'] != '' && $url != '') {
        $url_mod = str_replace('http://localhost/general/medialink/medialink/', '', "$url");
        $sql = "INSERT INTO `mediagallery`.`tags` (`url`, `tag`) VALUES ('$url_mod', '".$_REQUEST['new_tag']."');";
        $result = $conn->query($sql);
    }

    if (isset($_REQUEST['del_tag']) && $_REQUEST['del_tag'] != '' && $url != '') {
        $sql = "DELETE FROM `mediagallery`.`tags` WHERE (`url` = '$url') AND (`tag` = '".$_REQUEST['del_tag']."');";
        $result = $conn->query($sql);
    }

    $sql = "SELECT tag FROM tags WHERE url='$url';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()) {
        $current_tag = $row['tag'];
        echo "&nbsp;".$current_tag;
        echo " <a href=\"javascript:set_del('".$current_tag."')\">[X]</a>";
      }
    }
?>
<br>
New tag: <input type='textarea' name='new_tag' id='new_tag' style='font-size:20px;background-color:black;color: #3a4472;'></input>
<br>
<input type='hidden' name='del_tag' id='del_tag' /></center>
<br><center><input type='submit' value='submit' style='font-size:20px' /></center>
</form>
</body>