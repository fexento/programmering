<?php  /* registrer-student */
/*
/*  Programmet lager et html-skjema for å registrere en student
/*  Programmet registrerer data (studentkode og student) i databasen
*/
?>

<h3>Registrer student </h3>

<form method="post" action="" id="registrerstudentSkjema" name="registrerstudentSkjema">
  Fornavn <input type="text" id="fornavn" name="fornavn" required /> <br/>
  Etternavn <input type="text" id="etternavn" name="etternavn" required /> <br/>
  Brukernavn <input type="text" id="brukernavn" name="brukernavn" required /> <br/>
  Klasskode <input type="text" id="klassekode" name="klassekode" required /> <br/>
  <input type="submit" value="Registrer Student" id="registrerStudentkodeKnapp" name="registrerStudentkodeKnapp" />
  <input type="reset" value="Nullstill" id="nullstill" name="nullstill" /> <br />
</form>

<?php
  if (isset($_POST ["registrerStudentkodeKnapp"]))
    {
      $fornavn=$_POST ["fornavn"];
      $etternavn=$_POST ["etternavn"];
      $brukernavn=$_POST ["brukernavn"];
      $klassekode=$_POST ["klassekode"];

      if (!$klassekode || !$etternavn || !$brukernavn || !$fornavn)
        {
          print ("B&aring;de fornavn etternavn brukernavn og Klassekode m&aring; fylles ut");
        }
      else
        {
          include("db-tilkobling.php");  /* tilkobling til database-serveren utført og valg av database foretatt */

          $sqlSetning="SELECT * FROM student WHERE brukernavn='$brukernavn';";
          $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");
          $antallRader=mysqli_num_rows($sqlResultat);

          if ($antallRader!=0)  /* klasse er registrert fra før */
            {
              print ("Navnet er registrert fra f&oslashr");
            }
          else
            {
              $sqlSetning="INSERT INTO student VALUES('$fornavn','$etternavn', '$brukernavn', '$klassekode');";
              mysqli_query($db, $sqlSetning) or die ("ikke mulig &aring; registrere data i databasen");
                /* SQL-setning sendt til database-serveren */

              print ("F&oslash;lgende student er n&aring; registrert: $fornavn $etternavn $brukernavn $klassekode");
            }
        }
    }
?>