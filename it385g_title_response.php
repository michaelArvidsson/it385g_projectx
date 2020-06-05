<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Arapey&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Bookservice</title>
  <style>
    body{
      background-color:#00693e;
      font-family: 'Arapey', serif;
      margin: 0px; 
     }
     #head {    
        color:darkslategrey;
        width:100%;
        font-size: 200%;
        font-weight: bold;
        letter-spacing: 5px;
        text-align: center;
        text-shadow: 2px 2px rgba(0, 0, 0, 0.1);
        padding:10px;
        margin-top:0px;
        margin-bottom:0px;
        margin-left:5px;
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
        margin-top:30px;
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
    h3, h4, span {
      padding-left:5px;
    }
    #nav {
      background-color: #f8f9f5;
      position: relative;
      width: 100%;
      padding:0px;
      transition: 0.2s;
    }
    .nav_button {
      color:darkslategrey;
      margin:5px;
      position:absolute;
      top: 10px;
      padding:2px;
      text-shadow: 2px 2px rgba(0, 0, 0, 0.1);
      transition: 0.2s;
    }
    .nav_button:hover {
      box-shadow: 0px 0px 2px 2px;
      border-radius:5px;
    }
  </style>
</head>
<body>
  <div style="padding-left: 5px;" id="nav">
    <span class="nav_button"><a href="it385g_project_form.php" target="_self"><i style=color:darkslategrey; class="fa fa-home fa-2x"></i></a></span>
    <div>
      <h1 id='head'>Bookservice / Booktitles</h1>
    </div>
  </div>
<table border='1'>
<?php

    if(isset($_POST['title'])){
      $titles=$_POST['title'];
    }else
      $titles="";

    $xml = file_get_contents("https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/books/?titlesearch=".$titles);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);

    $books = $dom->getElementsByTagName('BOOK');

    echo "<div id=form_body>";
    echo "<h3 style='width:500px; margin:auto; margin-bottom:10px; text-align:center;'>";
    echo "You searched for booktitles containing <span style='background-color:white; margin-left:5px; padding:5px; padding-left:15px; padding-right:15px; border:1px solid black;'>$titles</span></h3>";
    echo "<form method='POST' action='it385g_title_response.php'>";
    echo "<div style='width:480px; margin:auto;'>";
    echo "<label>Search another title </label>";
    echo "<input style='width:225px;' type='text' name='title' placeholder=' Search title'/>";
    echo "<input style='margin:10px; border-radius:5px;' type='submit' name='submitbutton' value='Search'>";
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
            echo "<div>";
            echo "<h4 style='margin-top:5px;margin-bottom:5px;'>Category: </h4>";
            foreach($child->childNodes as $grandchild){
              echo "<span>$grandchild->nodeValue</span>";
              echo "<br>";
            }
          echo "</div>";  
          }else if ($child->nodeName=='URL'){
            echo "<div>";
            echo "<h4 style='margin-top:5px;margin-bottom:5px;'>Link to e-book: </h4>";
            echo "<a href='$child->nodeValue'>$child->nodeValue</a>";  
          }
        }   
          echo "</div>"; 
          echo "</td>";
          echo "<td style='vertical-align: top;'>";
          if ($child->nodeName=='PREFACE'){
            echo "<div style='width:600px;'>";
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
