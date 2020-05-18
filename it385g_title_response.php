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
    p {
      margin:5px;
    }
    div {
      padding:5px;
    }
    h3, h4, span{
      padding-left:5px;
    }
    #box2 {
      background-color: green;
    }
  </style>
</head>
<body>
<h1 id='head'>Bookservice</h1>
<table border='1'>
<?php

    //Check POST if empty show nothing
    if(isset($_POST['title'])){
      $titles=$_POST['title'];
    }else
      $titles="ALL";
/* 
    echo "<pre>";
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
    foreach ($books as $book){
      echo "<tr>";
      echo "<td style='width:700px;'><div>";
      echo "<h3>".$book->getAttribute("TITLE")."</h3>";
      echo "<div>";
      echo "<span><b>ID: </b>".$book->getAttribute("ID")."</span>";
      
      
      echo "<h4 style='margin-top:5px;margin-bottom:5px;'>Author</h4>";
        foreach ($book->childNodes as $child){
          if($child->nodeName=='AUTHORS'){
            foreach($child->childNodes as $grandchild){        
              echo "<span>$grandchild->nodeValue</span>";
              echo "<br>";
            }
            
            echo "<h4 style='margin-top:5px;margin-bottom:5px;'>Category</h4>";
          }else if($child->nodeName=='CATEGORIES'){
            foreach($child->childNodes as $grandchild){
              echo "<span>$grandchild->nodeValue</span>";
              echo "<br>";
            }
           
          }else if ($child->nodeName=='URL'){
            
            echo "<a href='$child->nodeValue'>$child->nodeValue</a>"; 
            echo "</div>"; 
          }
          
        
          echo "<div id='box2'>";
          if ($child->nodeName=='PREFACE'){
            echo "<h3 style='margin-top:5px;margin-bottom:5px;'>Preface</h3>";
            foreach($child->childNodes as $grandchild){
              echo "<p>";
              echo $grandchild->nodeValue;
              echo "</p>";
            }
            echo "</div>";
            echo "</td>";  
          }
          echo "</div>";
        }  
        
        echo "</td>";
    }
    echo "</tr>";     
?>
</table>
</body>
</html>
