<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Arapey&display=swap" rel="stylesheet">
  <title>Bookservice</title>
  <style>
    body{
      background-color:#00693e;
       font-family: 'Arapey', serif;
     }
     #head {
        background-color: #f8f9f5;
        color:darkslategrey;
        width:100%;
        font-size: 200%;
        font-weight: bold;
        letter-spacing: 5px;
        text-align: center;
        text-shadow: 2px 2px rgba(0, 0, 0, 0.1);
        padding:10px;
        margin-top:0px;
        margin-bottom:10px;
    }
    #form_body {
        Width:800px;
        background-color: #f8f9f5;
        margin:auto;
        font-weight:bold;
        font-size:15px;
        box-shadow: 2px 2px 4px 2px;
        padding: 20px;
        margin-bottom:30px;
        border-radius: 3px;
    }
    table {
      width:800px;
      background-color: #f8f9f5;
      border-collapse: collapse;
      margin:auto;
      box-shadow: 2px 2px 4px 2px;
      border-radius: 3px;
    }
    td {
      padding: 3px;
      margin: 0px;
    }
  </style>
</head>
<body>
<h1 id='head'>Bookservice / Author roles</h1>
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
      echo "You searched for <span style='background-color:white; margin-left:5px; padding:5px; padding-left:15px; padding-right:15px; border:1px solid black;'>$author_role</span></h3>";
      echo "<form method='POST' action='it385g_role_response.php'>";
      echo "<div style='width:480px; margin:auto;'>";
      echo "<label>Search another role </label>";
      echo "<input style='width:225px;' type='text' name='author_role' placeholder=' Author/Editor/Translator/Contributor'/>";
      echo "<input style='margin:10px;' type='submit' name='submitbutton' value='Show result'>";
      echo "</div>";
      echo "</form>";
      echo "<p style='text-align:center;'>Click on the Authors name below to show more info</p>";
      echo "</div>";
      echo "<th>Author</th><th>Lived between</th><th>Image</th>";
      foreach ($authors as $author){
        echo "<tr>";
        foreach ($author->childNodes as $child){

          if($child->nodeName=='FIRSTNAME'){
            echo "<td style='width:200px;'><div style='width:200px; text-align: center; white-space: nowrap;'>";
            $firstname=$child->nodeValue;
          }else if ($child->nodeName=='LASTNAME'){
            echo "<a href='it385g_author_get_response.php?firstname=".$firstname."&lastname=".$child->nodeValue."'>".$firstname." ".$child->nodeValue. "</a>";
            echo "</div></td>";
          }

          /* if($child->nodeName=='FIRSTNAME'){
            echo "<td style='width:200px;'><div style='width:200px; text-align: center; white-space: nowrap;'>";
            echo $child->nodeValue;
            echo " ";
          }
          else if ($child->nodeName=='LASTNAME'){
            echo $child->nodeValue;
            echo "</div></td>";
          } */else if ($child->nodeName=='BIRTHYEAR'){
            echo "<td><div style='Width:200px; margin:auto; text-align:center; white-space: nowrap;'>";
            echo $child->nodeValue;
            echo " - ";
          }else if ($child->nodeName=='DEATHYEAR'){
            echo $child->nodeValue;
            echo "</div></td>";
          }else if ($child->nodeName=='IMGURL'){
            echo "<td><div style='width:100px; height:100px; margin:auto; overflow:hidden;'>";
            echo "<a href='$child->nodeValue'>";
            echo "<img style='width:100px;' src='$child->nodeValue'alt=''>";
            echo "</a>";          
            echo "</div></td>";
          }/* else if ($child->nodeName=='ABOUT'){
            echo "<td><div style='Width:400px; padding:5px;'><p>";
            echo $child->nodeValue;
            echo "</p></div></td>";
          }else if ($child->nodeName=='SIGNATURE'){
            echo "<td><div style='width:200px; height:200px;padding:5px;'>";
            echo "<a href='$child->nodeValue'>";
            echo "<img style='width:200px; height:200px' src='$child->nodeValue'alt=''>";
            echo "</a>";          
            echo "</div></td>";
          } */
        }  
        echo "</tr>";
      }     
?>
</table>
</body>
</html>
