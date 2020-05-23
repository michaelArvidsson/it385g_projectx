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
        Width:400px;
        background-color: #f8f9f5;
        margin:auto;
        font-weight:bold;
        font-size:15px;
        box-shadow: 2px 2px 4px 2px;
        padding: 10px;
        margin-bottom:30px;
        margin-top:30px;
        border-radius:5px;
    }
    table {
      background-color: #f8f9f5;
      border-collapse: collapse;
      margin:auto;
      box-shadow: 2px 2px 4px 2px;
      border-radius: 3px;
      margin-top:30px;
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
    #submit_button {
      margin: auto;
      padding: 3px;
      width: 70px;
      border-radius:5px;
    }

  </style>
</head>
<body>
<h1 id='head'>Bookservice / Book details</h1>
<table border='1'>
<?php

    //Check POST if empty show nothing
    if(isset($_GET['id'])){
      $titles=$_GET['id'];
    }else
      $titles="";

    /* echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    echo "<pre>";
    print_r($titles);
    echo "</pre>"; */

    $xml = file_get_contents("https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/books/?id=".$titles);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);

    $books = $dom->getElementsByTagName('BOOK');

    /* echo "<th>Booktitle</th><th>ID</th><th>Author(s)</th><th>Category</th><th>Link</th><th>Preface</th>"; */
    
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
<div id=form_body>
    <h3 style='width:300px; margin:auto; margin-bottom:10px; text-align:center;'>click on the button to get back to the previous page</h3>
    <div style='width:80px; margin:auto;'>
    <button id="submit_button" onclick="goBack()">Back</button>

      <script>
          function goBack() {
            window.history.back();
          }
      </script>
    </div>
    
  </div>";
</body>
</html>
