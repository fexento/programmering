<?php
include("db-tilkobling.php"); // må være før skjemaet

// Hent alle registrerte studenter
$sqlStudenter = "SELECT brukernavn, fornavn, etternavn FROM student ORDER BY brukernavn;";
$resultatStudenter = mysqli_query($db, $sqlStudenter);
?>

<script src="funksjoner.js"> </script>

<h3>Slett student</h3>

<form method="post" action="" id="slettStudentSkjema" name="slettStudentSkjema" onSubmit="return bekreft()">
  Brukernavn 
  <select id="brukernavn" name="brukernavn" required>
    <option value="">Velg student</option>
    <?php
      while ($rad = mysqli_fetch_array($resultatStudenter)) {
        $brukernavn = $rad["brukernavn"];
        $fornavn = $rad["fornavn"];
        $etternavn = $rad["etternavn"];
        echo "<option value='$brukernavn'>$brukernavn – $fornavn $etternavn</option>";
      }
    ?>
  </select> <br/>

  <input type="submit" value="Slett student" name="slettStudentKnapp" id="slettStudentKnapp" /> 
</form>

<?php
if (isset($_POST["slettStudentKnapp"])) {
  $brukernavn = $_POST["brukernavn"];

  if (!$brukernavn) {
    print("Brukernavn må fylles ut");
  } else {
    include("db-tilkobling.php");

    $sqlSetning = "SELECT * FROM student WHERE brukernavn='$brukernavn';";
    $sqlResultat = mysqli_query($db, $sqlSetning) or die("Ikke mulig å hente data fra databasen");
    $antallRader = mysqli_num_rows($sqlResultat);

    if ($antallRader == 0) {
      print("Studenten finnes ikke");
    } else {
      $sqlSetning = "DELETE FROM student WHERE brukernavn='$brukernavn';";
      mysqli_query($db, $sqlSetning) or die("Ikke mulig å slette data i databasen");

      print("Følgende student er nå slettet: $brukernavn <br />");
    }
  }
}
?>