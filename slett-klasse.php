<?php
include("db-tilkobling.php"); // må være før skjemaet

// Hent alle gyldige klassekoder
$sqlKlasser = "SELECT klassekode FROM klassekode ORDER BY klassekode;";
$resultatKlasser = mysqli_query($db, $sqlKlasser);
?>

<script src="funksjoner.js"> </script>

<h3>Slett klasse</h3>

<form method="post" action="" id="slettKlasseSkjema" name="slettKlasseSkjema" onSubmit="return bekreft()">
  Klassekode 
  <select id="klassekode" name="klassekode" required>
    <option value="">Velg klassekode</option>
    <?php
      while ($rad = mysqli_fetch_array($resultatKlasser)) {
        $kode = $rad["klassekode"];
        echo "<option value='$kode'>$kode</option>";
      }
    ?>
  </select> <br/>

  <input type="submit" value="Slett klasse" name="slettKlasseKnapp" id="slettKlasseKnapp" /> 
</form>

<?php
if (isset($_POST["slettKlasseKnapp"])) {
  $klassekode = $_POST["klassekode"];

  if (!$klassekode) {
    print("Klassekode må fylles ut.");
  } else {
    include("db-tilkobling.php");

    $sqlSetning = "SELECT * FROM klassekode WHERE klassekode='$klassekode';";
    $sqlResultat = mysqli_query($db, $sqlSetning) or die("Ikke mulig å hente data fra databasen");
    $antallRader = mysqli_num_rows($sqlResultat);

    if ($antallRader == 0) {
      print("Klassekoden finnes ikke");
    } else {
      // Sjekk om det finnes studenter i klassen
      $sqlSjekkStudenter = "SELECT brukernavn, fornavn, etternavn FROM student WHERE klassekode='$klassekode';";
      $resultatStudenter = mysqli_query($db, $sqlSjekkStudenter) or die("Ikke mulig å hente studentdata");
      $antallStudenter = mysqli_num_rows($resultatStudenter);

      if ($antallStudenter > 0) {
        print("<strong>Kan ikke slette klassen '$klassekode' fordi følgende studenter er registrert:</strong><br/><ul>");
        while ($rad = mysqli_fetch_array($resultatStudenter)) {
          $brukernavn = $rad["brukernavn"];
          $fornavn = $rad["fornavn"];
          $etternavn = $rad["etternavn"];
          print("<li>$brukernavn – $fornavn $etternavn</li>");
        }
        print("</ul>");
        print("Slett studentene først via slett student-siden.");
      } else {
        // Klassen har ingen studenter, trygt å slette
        $sqlSlettKlasse = "DELETE FROM klassekode WHERE klassekode='$klassekode';";
        mysqli_query($db, $sqlSlettKlasse) or die("Ikke mulig å slette klassen");
        print("Klassen '$klassekode' er nå slettet.");
      }
    }
  }
}
?>