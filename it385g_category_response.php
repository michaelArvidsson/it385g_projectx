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
        margin-top:30px;
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
      padding:5px;
      margin: 0px;
    }
    h3, h4,span {
      padding:5px;
    }
    #submit_button {
      margin: auto;
      padding: 3px;
      width: 70px;
      border-radius:5px;
    }
    #nav {
      background-color: #f8f9f5;
      position: relative;
      width: 100%;
      height:65px;
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
      <h1 id='head'>Bookservice / Categories</h1>
    </div>
  </div>

<?php

    if(isset($_POST['category']) && !empty($_POST['category'])){
      $categories=$_POST['category'];

    $xml = file_get_contents("https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/books/?titlesearch=".$categories);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);
    }
    if(!empty($xml)){

    $cat = $dom->getElementsByTagName('BOOK');
    echo "<table border='1'>";
    echo "<div id=form_body>";
    echo "<h3 style='width:500px; margin:auto; margin-bottom:10px; text-align:center;'>";
    echo "You searched for books within the category <span style='background-color:white; margin-left:5px; padding:5px; padding-left:15px; padding-right:15px; border:1px solid black;'>$categories</span></h3>";
    echo "<form method='POST' action='it385g_category_response.php'>";
    echo "<div style='width:500px; margin:auto;'>";
    echo "<label>Search another category </label>";
    echo "<input style='width:225px;' type='text' name='category' placeholder=' Search category'/>";
    echo "<input style='margin:10px; border-radius:5px;' type='submit' name='submitbutton' value='Search'>";
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
      echo "</table>";
    }else{
      echo "<div style='text-align:center;'id='form_body'>You have to make a selection or search<br>Please go back to the previous page";
      echo "<div style='margin-top:20px;'><button id='submit_button' onclick='goBack()'>Back</button></div></div>";
    }
       
?>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
