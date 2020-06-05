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
     form {
       margin-bottom:5px;
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
        Width:550px;
        background-color: #f8f9f5;
        margin:auto;
        font-weight:bold;
        font-size:15px;
        box-shadow: 2px 2px 4px 2px;
        padding: 20px;
        margin-bottom:30px;
        margin-top:30px;
        border-radius: 5px;
    }
    fieldset {
      width: 460px;
      margin: auto;
      margin-bottom:20px;
      border-radius: 3px;
      border-radius: 5px;
    }
  
    h3, h4, a {
      padding-left:5px;
    }
    #nav {
      background-color: #f8f9f5;
      position: relative;
      width: 100%;
      padding:0px;
    }
    .nav_button {
      color:darkslategrey;
      margin:5px;
      position:absolute;
      top: 10px;
      padding:2px;
      text-shadow: 2px 2px rgba(0, 0, 0, 0.1);
    }
  
  </style>
</head>
<body>
<div style="padding:5px" id="nav">
    <span class="nav_button"><i style=color:darkslategrey; class="fa fa-home fa-2x"></i></span>
    <div>
      <h1 id='head'>Bookservice</h1>
    </div>
  </div>
    
    <div id=form_body>
      <fieldset>
      <legend>Select</legend>
<?php
 
      $xml = file_get_contents('https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/category/?categorysearch=ALL');
      $dom = new DomDocument;
      $dom->preserveWhiteSpace = FALSE;
      $dom->loadXML($xml);

      $xml = file_get_contents('https://wwwlab.iit.his.se/gush/XMLAPI/bookservice/authors?role=ALL');
      $dom2 = new DomDocument;
      $dom2->preserveWhiteSpace = FALSE;
      $dom2->loadXML($xml);

      echo "<form method='POST' action='it385g_category_response.php'>";
      echo "<label> Category </label>";
      echo "<div style='margin-top:10px; margin-bottom:10px;'><select name='category' style='width:370px;'>";
      echo "<option value=''>---</option>";
      $categories= $dom->getElementsByTagName('CATEGORY');
      foreach ($categories as $category){
        foreach ($category->childNodes as $child){
          $text=trim($child->nodeValue);
          if($text!=""){
            echo "<option value=$text>";
            echo $text;
            echo "</option>";
          }
        }
      }
      echo "<input style='margin-left:20px; border-radius:5px;' type='submit' name='submitbutton' value='Submit'>";
      echo "</select></div>";
      echo "</form>";

      echo "<form method='POST' action='it385g_author_response.php'>";
      echo "<label> Or Author </label>";
      echo "<div style='margin-top:10px;'><select name='author' style='width:370px;'>";
      echo "<option value=''>---</option>";
      $authors= $dom2->getElementsByTagName('AUTHOR');
      foreach ($authors as $author){
        foreach ($author->childNodes as $child){
          if($child->nodeName=="FIRSTNAME"){
            $first = $child->nodeValue;             
          }else if($child->nodeName=="LASTNAME"){
            $last = $child->nodeValue;                  
          }         
        }       
        echo "<option value='$first&$last'>";
        echo $first;
        echo " "; 
        echo $last;    
        echo "</option>";
      }
      echo "<input style='margin-left:20px; border-radius:5px;' type='submit' name='submitbutton' value='Submit'>";
      echo "</select></div>";
      echo "</form>";
      echo "</fieldset>";         
?>
    <div>
          <fieldset>
          <legend>search by</legend>
          <form method='POST' action='it385g_title_response.php'>
          <label>Booktitle</label>
          <div>
          <input style='width:370px;'type='text' name='title' placeholder=" Search booktitle"/>         
          <input style='margin:10px; border-radius:5px;' type='submit' name='submitbutton' value='Search'>
          </div>
          </form>  
          <form method='POST' action='it385g_role_response.php'>
          <label>Or Author role</label>
          <div>
          <input style='width:370px;' type='text' name='author_role' placeholder=" Author/Editor/Translator/Contributor/Ilustrator"/>
          <input style='margin:10px; border-radius:5px;' type='submit' name='submitbutton' value='Search'>
          </div>
          </form>  
          </fieldset>
      </div>

      
    </div>
    
    
</body>
</html>