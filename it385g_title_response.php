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
      background-color: #f8f9f5;
      border-collapse: collapse;
      margin:auto;
      box-shadow: 2px 2px 4px 2px;
      border-radius: 3px;
    }
    td {
      padding: 0px;
      margin: 0px;
    }
    p {
      margin:5px;
      margin-bottom:10px;
    }
    div {
      padding:5px;
    }
    h3, h4, span, a {
      padding-left:5px;
    }
  /*   #box {
      background-color: yellow;
    }
    #box1 {
      background-color: pink;
    }
    #box2 {
      background-color: green;
    } */
  </style>
</head>
<body>
<h1 id='head'>Bookservice / Booktitles</h1>
<table border='1'>
<?php

    //Check POST if empty show nothing
    if(isset($_POST['title'])){
      $titles=$_POST['title'];
    }else
      $titles="";

    /* echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    echo "<pre>";
    print_r($titles);
    echo "</pre>"; */

    $xml = file_get_contents("https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/books/?titlesearch=".$titles);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);

    $books = $dom->getElementsByTagName('BOOK');

    /* echo "<th>Booktitle</th><th>ID</th><th>Author(s)</th><th>Category</th><th>Link</th><th>Preface</th>"; */
    echo "<div id=form_body>";
    echo "<h3 style='width:500px; margin:auto; margin-bottom:10px; text-align:center;'>";
    echo "You searched for booktitles containing <span style='background-color:white; margin-left:5px; padding:5px; padding-left:15px; padding-right:15px; border:1px solid black;'>$titles</span></h3>";
    echo "<form method='POST' action='it385g_title_response.php'>";
    echo "<div style='width:480px; margin:auto;'>";
    echo "<label>Search another title </label>";
    echo "<input style='width:225px;' type='text' name='title' placeholder=' Search title'/>";
    echo "<input style='margin:10px;' type='submit' name='submitbutton' value='Show result'>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
    foreach ($books as $book){
      echo "<tr>";
      echo "<td style='width:400px;'><div>";
      echo "<h3 style='text-decoration:underline; text-align:center;'>Book title</h3>";
      echo "<h4>".$book->getAttribute("TITLE")."</h4>";
      echo "<div>";
      echo "<span><b>ID: </b>".$book->getAttribute("ID")."</span>";
      
      
      
        foreach ($book->childNodes as $child){
          if($child->nodeName=='AUTHORS'){
            echo "<h4 style='margin-top:5px;margin-bottom:5px;'>Author: </h4>";
            foreach($child->childNodes as $grandchild){        
              echo "<span>$grandchild->nodeValue</span>";
              echo "<br>";
            }
            echo "</div>";  
            
          }else if($child->nodeName=='CATEGORIES'){
            echo "<div id='box'>";
            echo "<h4 style='margin-top:5px;margin-bottom:5px;'>Category: </h4>";
            foreach($child->childNodes as $grandchild){
              echo "<span>$grandchild->nodeValue</span>";
              echo "<br>";
            }
          echo "</div>";  
          }else if ($child->nodeName=='URL'){
            echo "<div id='box1'>";
            echo "<h4 style='margin-top:5px;margin-bottom:5px;'>Link to e-book: </h4>";
            echo "<a href='$child->nodeValue'>$child->nodeValue</a>"; 
            
          }
        }   
          echo "</div>"; 
          echo "</td>";
           echo "<td style='vertical-align: top;'>";
          
          if ($child->nodeName=='PREFACE'){
            echo "<div id='box2'style='width:600px;'>";
            echo "<h3 style='text-decoration:underline; text-align:center;'>Preface</h3>";
            foreach($child->childNodes as $grandchild){
              echo "<p>";
              echo $grandchild->nodeValue;
              echo "</p>";
            }
            echo "</div>";
            echo "</td>";  
          }
          
         
       
    }
    echo "</tr>";     
?>
</table>
</body>
</html>
