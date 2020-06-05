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
        Width:500px;
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
      border-radius: 5px;
    }
    td {
      padding: 0px;
      margin: 0px;
    }
    div {
      padding:5px;
      margin-bottom:5px;
    }
    h3, h4, span {
      padding-left:5px;
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
      padding:0px;
      transition: 0.2s;
      margin-bottom:30px;
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
      <h1 id='head'>Bookservice / Author details</h1>
    </div>
  </div>
<table border='1'>
<?php

    if(isset($_GET['firstname'])){
      $firstname=$_GET['firstname'];
    }
    if(isset($_GET['lastname'])){
      $lastname=$_GET['lastname'];
    }else
      $writer="ALL";

    $url="https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/authors/?firstname=".urlencode($firstname)."&lastname=".urlencode($lastname);
    $xml = file_get_contents($url);
    $dom = new DomDocument;
    $dom->preserveWhiteSpace = FALSE;
    $dom->loadXML($xml);

    $authors = $dom->getElementsByTagName('AUTHOR');

    echo "<th>Author</th><th>Image</th><th>About</th><th>Signature</th>";
    foreach ($authors as $author){
      echo "<tr>";
      foreach ($author->childNodes as $child){
        if($child->nodeName=='FIRSTNAME'){
          echo "<td><div style='width:150px; text-align: center;'>";
          echo $child->nodeValue;
          echo " ";
        }else if ($child->nodeName=='LASTNAME'){
          echo $child->nodeValue;
          echo "<br>";
          echo "<span>Role: ".$author->getAttribute("ROLE")."</span>";
          echo "</div></td>";

        }else if ($child->nodeName=='BIRTHYEAR'){
          $birth=$child->nodeValue;
        }else if ($child->nodeName=='DEATHYEAR'){
          $death=$child->nodeValue;

        }else if ($child->nodeName=='IMGURL'){
          echo "<td><div style='width:200px; height:200px; overflow:hidden;'>";
          echo "<a href='$child->nodeValue'>";
          echo "<img style='width:200px;' src='$child->nodeValue'alt=''>";
          echo "</a>";          
          echo "</div></td>";
        }else if ($child->nodeName=='ABOUT'){
          echo "<td><div style='Width:400px; padding:10px;'><p>";
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
    echo "</table>";
    echo "<div id=form_body>";
    echo "<h3 style='width:300px; margin:auto; margin-bottom:10px; text-align:center;'>The auhtor lived between</h3>";
    echo "<div class='graph'style='width:420px; margin:auto; position:relative;'>";
    echo "<div style='width:100px; text-align:center; padding:10px; margin:auto;'>".$birth. "  -  " .$death."</div>";
    $year = $death - $birth;
    $start = ($birth-1700)+110;
    $end = ($start + $year); 
    
    echo "<img style='width:410px;'src='flourish2.svg'>";
    echo "<svg style='position:absolute; left:0px; top:55px;'height='50' width='400'>";
    echo "<line x1='$start' y1='20' x2='$end' y2='20' style='stroke:rgb(255,0,0);stroke-width:3'/>";
    echo "<circle cx='$start' cy='20' r='3' style='stroke:red; stroke-width:2; fill:white; fill-opacity: 1.0;' />";
    echo "<circle cx='$end' cy='20' r='3' style='stroke:red; stroke-width:2; fill:white; fill-opacity: 1.0;' />";
    echo "</svg>";
    echo "</div>";
    echo "</div>";
?>
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
</body>
</html>
