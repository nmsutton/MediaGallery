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
  .videoicon {
    position:relative;
    display:inline-block;
    width: auto;  
    height: 246px;
    min-width: 100px;
    background-color: black;
    word-wrap: break-word;
    overflow-wrap: break-word;
    border:2px solid lightblue;
    max-width: 400px;
  }
  .foldericongeneric {
    position:relative;
    width: 160px;  
    height: 220px;
    background-color: black;
    word-wrap: break-word;
    overflow-wrap: break-word;
    font-size: 26px;
    /*border:2px solid darkgrey;*/
    text-align:center;
  }
  .videoicon {
    position:relative;
    display:inline-block;
    width: auto;  
    height: 246px;
    min-width: 100px;
    background-color: black;
    word-wrap: break-word;
    overflow-wrap: break-word;
    border:2px solid lightblue;
    max-width: 400px;
  }
  .foldercontainer {
    position:relative;
    display:inline-block;
    width: auto;    
    height: 246px;
    max-width: 600px;
    min-width: 100px;
    background-color: black;
    word-wrap: break-word;
    overflow-wrap: break-word;
    font-size: 26px;
    text-align: center;
  }
  .foldericon {
    position:relative;
    display:inline-block;
    width: auto;  
    height: 246px;
    max-width: 600px;
    /*min-width: 150px;*/
    background-color: black;
    word-wrap: break-word;
    overflow-wrap: break-word;
    font-size: 26px;
    /*line-height: 250px;*/
    border:2px solid darkgrey;
    text-align:center;
  }
  .linktext {
    position:relative;
    top:-4px;
  }
</style>
<script>
    this.name = "tags_coll_window";
    function set_tag(tag_name) {
        document.getElementById('new_tag').value = tag_name;
        document.getElementById('set_tags').submit();
    }
    function set_del(tag_name) {
        document.getElementById('del_tag').value = tag_name;
        document.getElementById('set_tags').submit();
    }
    function sub_form(query) {
      document.forms["setlink"].submit();
    }
</script>
</head>
<body>
<form target="_blank" name='setlink' action='http://localhost/general/mediagallery/mediagallery.php' method='POST'>
<center>
<?php
    include("comb_tags.php");

    function find_thumb($tag) {
      $tag_thumb_name = "/general/medialink/media/".$tag.".jpg";
      $image_path = "/var/www/html".$tag_thumb_name;
      if (!file_exists($image_path)) {
        $tag_thumb_name = "/general/mediagallery/media/folder.jpg";
      }
      return $tag_thumb_name;
    }

    echo "<span style='font-size:30px;'>Enter tags: </span><input type='textarea' name='tags_query' id='tags_query' style='font-size:20px;background-color:black;color: #3a4472;'></input>&nbsp;<input type='button' value='Submit' style='width:125px;height:40px;font-size:30px;' onclick=\"javascript:sub_form()\" /><br>";

    for ($i = 0; $i < count($comb_tags); $i++) {
      echo " <span class='foldercontainer videoicon'><a href='http://localhost/general/mediagallery/mediagallery.php?tags_query=".$comb_tags[$i]."' target='_blank'><img src='".find_thumb($comb_tags[$i])."' class='foldericon' /><br><span class='linktext'>".$comb_tags[$i]."</span></a><br></span>";
    }

    $sql = "SHOW TABLES;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { 
      while($row = $result->fetch_assoc()) {
        $current_tag = $row['Tables_in_mediagallery'];
        if ($current_tag != "access" && $current_tag != "tags") {
            echo " <span class='foldercontainer videoicon'><a href='http://localhost/general/mediagallery/mediagallery.php?tags_query=$current_tag' target='_blank'><img src='".find_thumb($current_tag)."' class='foldericon' /><br><span class='linktext'>$current_tag</span></a><br></span>";
        }
      }
    }  
?>
</center>
</form>
</body>
</html>