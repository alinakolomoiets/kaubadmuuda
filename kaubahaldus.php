<?php
  require("abifunktsioonid.php");
$sorttulp="nimetus";
$otsisona="";
if(isset($_REQUEST['$sorttulp'])){
    $sorttulp=$_REQUEST['$sorttulp'];
}


  if(isSet($_REQUEST["grupilisamine"]) && !empty ($_REQUEST['uuegrupinimi'])){
    lisaGrupp($_REQUEST["uuegrupinimi"]);
    header("Location: kaubahaldus.php");
    exit();
  }
  if(isSet($_REQUEST["kaubalisamine"]) && !empty ($_REQUEST['nimetus'])){
    lisaKaup($_REQUEST["nimetus"], $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);
    header("Location: kaubahaldus.php");
    exit();
  }
  if(isSet($_REQUEST["kustutusid"])){
     kustutaKaup($_REQUEST["kustutusid"]);
  }
  if(isSet($_REQUEST["muutmine"])){
     muudaKaup($_REQUEST["muudetudid"], $_REQUEST["nimetus"],
                              $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);
  }
  $kaubad=kysiKaupadeAndmed();
?>
<!DOCTYPE html >
  <head>
      <title>Kaupade leht</title>
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  </head>
  <body>    
   <form action="kaubahaldus.php">
       <div id="menu2">
     <h2>Kauba lisamine</h2>
       <link rel="stylesheet" type="text/css"  href="style_kauba.css">
     <dl>
       <dt>Nimetus:</dt>
       <dd><input type="text" name="nimetus" /></dd>
       <dt>Kaubagrupp:</dt>
       <dd>
           <?php
         echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid", 
                           "kaubagrupi_id");
       ?>
       </dd>
       <dt>Hind:</dt>
       <dd><input type="text" name="hind" /></dd>
     </dl>
     <input type="submit" name="kaubalisamine" value="Lisa kaup" />
       </div>
       <div id="menu1">
     <h2>Grupi lisamine</h2>
     <input type="text" name="uuegrupinimi" />
     <input type="submit" name="grupilisamine" value="Lisa grupp" />
       </div>
   </form>
   <form action="kaubahaldus.php">
       <div id="menu">
     <h2>Kaupade tabel</h2>
     <table id="table">
       <tr >
         <th>Haldus</th>
         <th><a href="kaubahaldus.php?sorttylup=nimetus">Nimetus</th>
         <th><a href="kaubahaldus.php?sorttulp=grupinimi">Kaubagrupp</th>
         <th><a href="kaubahaldus.php?sorttulp=hind">Hind</th>
       </tr>
       <?php foreach($kaubad as $kaup): ?>
         <tr>
          <?php if(isSet($_REQUEST["muutmisid"]) &&
                            intval($_REQUEST["muutmisid"])==$kaup->id): ?>
           <td>
             <input type="submit" name="muutmine" value="Muuda" />
             <input type="submit" name="katkestus" value="Katkesta" />
             <input type="hidden" name="muudetudid" value="<?=$kaup->id ?>" />
           </td>
           <td><input type="text" name="nimetus" value="<?=$kaup->nimetus ?>" /></td>
           <td><?php
             echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid", 
                                        "kaubagrupi_id", $kaup->kaubagrupi_id);
           ?></td>
           <td><input type="text" name="hind" value="<?=$kaup->hind ?>" /></td>
          <?php else: ?>          
           <td><a href="kaubahaldus.php?kustutusid=<?=$kaup->id ?>"
                  onclick="return confirm('Kas ikka soovid kustutada?')">x</a>
               <a href="kaubahaldus.php?muutmisid=<?=$kaup->id ?>">m</a>
           </td>
           <td><?=$kaup->nimetus ?></td>
           <td><?=$kaup->grupinimi ?></td>
           <td><?=$kaup->hind ?></td>
          <?php endif ?>
         </tr>
       <?php endforeach; ?>
     </table>
       </div>
   </form>
  </body>
</html>
