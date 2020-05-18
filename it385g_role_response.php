<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bookservice</title>
  <style>
    #head {
        background-color: #fdf3ea;
        color:darkslategrey;
        width:100%;
        font-size: 200%;
        font-weight: bold;
        letter-spacing: 5px;
        text-align: center;
        text-shadow: 2px 2px rgba(0, 0, 0, 0.1);
        padding:10px;
        margin-top:0px;
        margin-bottom:30px;
    }
    #form_body {
        Width:800px;
        background-color: #fdf3ea;
        margin:auto;
        margin-bottom: 30px;
        font-weight:bold;
        font-size:15px;
        box-shadow: 2px 2px 4px 2px;
        padding: 20px;
    }
    table {
      background-color: #fdf3ea;
      border-collapse: collapse;
      margin:auto;
      box-shadow: 2px 2px 4px 2px;
    }
    td {
      padding: 0px;
      margin: 0px;
    }
  </style>
</head>
<body>
<h1 id='head'>Bookservice</h1>
<table border='1'>
<?php

    //Check POST if empty show nothing
    if(isset($_POST['author_role'])){
      $author_role=$_POST['author_role'];
    }else
    $author_role="ALL";

    $xml = file_get_contents("https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/authors/?role=".$author_role);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);

    $authors = $dom->getElementsByTagName('AUTHOR');
    
      echo "<div id=form_body>";
      echo "<h3 style='width:500px; margin:auto; margin-bottom:10px; text-align:center;'>";
      echo "You searched for <span style='background-color:white; margin-left:5px; padding:5px; padding-left:15px; padding-right:15px; border:1px solid black;'>$author_roles</span></h3>";
      echo "<form method='POST' action='it385g_role_response.php'>";
      echo "<div style='width:480px; margin:auto;'>";
      echo "<label>Search another role </label>";
      echo "<input style='width:225px;' type='text' name='author_role' placeholder=' Author/Editor/Translator/Contributor'/>";
      echo "<input style='margin:10px;' type='submit' name='submitbutton' value='Show result'>";
      echo "</div>";
      echo "</form>";
      echo "</div>";
      echo "<th>Author</th><th>Lived</th><th>Image</th><th>About</th><th>Signature</th>";
      foreach ($authors as $author){
        echo "<tr>";
        foreach ($author->childNodes as $child){
          if($child->nodeName=='FIRSTNAME'){
            echo "<td><div style='width:150px; text-align: center;'>";
            echo $child->nodeValue;
            echo " ";
          }else if ($child->nodeName=='LASTNAME'){
            echo $child->nodeValue;
            echo "</div></td>";
          }else if ($child->nodeName=='BIRTHYEAR'){
            echo "<td><span style='Width:100px; white-space: nowrap;'>";
            echo $child->nodeValue;
            echo " - ";
          }else if ($child->nodeName=='DEATHYEAR'){
            echo $child->nodeValue;
            echo "</span></td>";
          }else if ($child->nodeName=='IMGURL'){
            echo "<td><div style='width:200px; height:200px; overflow:hidden;'>";
            echo "<a href='$child->nodeValue'>";
            echo "<img style='width:200px;' src='$child->nodeValue'alt=''>";
            echo "</a>";          
            echo "</div></td>";
          }else if ($child->nodeName=='ABOUT'){
            echo "<td><div style='Width:400px; padding:5px;'><p>";
            echo $child->nodeValue;
            echo "</p></div></td>";
          }else if ($child->nodeName=='SIGNATURE'){
            echo "<td><div style='width:200px; height:200px;padding:5px;'>";
            echo "<a href='$child->nodeValue'>";
            echo "<img style='width:200px; height:200px' src='$child->nodeValue'alt=''>";
            echo "</a>";          
            echo "</div></td>";
          }
        }  
        echo "</tr>";
      }     
?>
</table>
</body>
</html>
