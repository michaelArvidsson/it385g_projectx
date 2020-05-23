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
        margin-bottom:30px;
    }
    #form_body {
        Width:800px;
        background-color: #f8f9f5;
        margin:auto;
        font-weight:bold;
        font-size:15px;
        box-shadow: 2px 2px 4px 2px;
        padding: 20px;
        margin-bottom:40px;
        border-radius: 3px;
    }
    table {
      background-color: #f8f9f5;
      border-collapse: collapse;
      margin:auto;
      box-shadow: 2px 2px 4px 2px;
      border-radius: 3px;
    }
    td {
      padding:5px;
      margin: 0px;
    }
    h3, h4, a {
      padding:5px;
    }
  </style>
</head>
<body>
<h1 id='head'>Bookservice / Categories</h1>
<table border='1'>
<?php

    //Check POST if empty show nothing
    if(isset($_POST['category'])){
      $categories=$_POST['category'];
    }else
      $categories="";

 /*    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    echo "<pre>";
    print_r($categories);
    echo "</pre>"; */

    $xml = file_get_contents("https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/books/?titlesearch=".$categories);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);

    $cat = $dom->getElementsByTagName('BOOK');

    echo "<div id=form_body>";
    echo "<h3 style='width:500px; margin:auto; margin-bottom:10px; text-align:center;'>";
    echo "You searched for books within the category <span style='background-color:white; margin-left:5px; padding:5px; padding-left:15px; padding-right:15px; border:1px solid black;'>$categories</span></h3>";
    echo "<form method='POST' action='it385g_category_response.php'>";
    echo "<div style='width:500px; margin:auto;'>";
    echo "<label>Search another category </label>";
    echo "<input style='width:225px;' type='text' name='category' placeholder=' Search category'/>";
    echo "<input style='margin:10px;' type='submit' name='submitbutton' value='Show result'>";
    echo "</div>";
    echo "</form>";
    echo "<p style='text-align:center;'>Click on the ID below to show the book</p>";
    echo "</div>";
    echo "<th>Booktitle</th><th>ID</th><th>Author</th>";
      foreach ($cat as $category){
        echo "<tr>";
        echo "<td style='width:400px;'><div>";
        echo "<span>".$category->getAttribute("TITLE")."</span></td>";
        echo "<td><span><a href='it385g_id_response.php?id=".$category->getAttribute("ID")."'>".$category->getAttribute("ID")."</a></span>";
        echo "</td>";
        echo "<td>";
        foreach ($category->childNodes as $child){
          if($child->nodeName=='AUTHORS'){
            foreach($child->childNodes as $grandchild){        
              echo "<span>$grandchild->nodeValue</span>";
              echo "<br>";
            }
            echo "</td>";
          }  
        }  
        echo "</tr>";
      }     
?>
</table>
</body>
</html>
