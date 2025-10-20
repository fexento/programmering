<?php  
  include("db-tilkobling.php");  

  $sqlSetning="SELECT * FROM klassekode;";
  
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("Ikke mulig å hente data fra databasen");
	
  $antallRader=mysqli_num_rows($sqlResultat);

  print ("<h3>Registrerte poststeder</h3>");
  print ("<table border=1>");  
  print ("<tr><th align=left>klassekode</th> <th align=left>klassenavn</th> <th align=left>studiumkode</th></tr>"); 

  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);  /* ny rad hentet fra sp�rringsresultatet */
      $klassekode=$rad["klassekode"];       
      $klassenavn=$rad["klassenavn"];
      $studiumkode=$rad["studiumkode"];    

      print "<tr> <td> $klassekode </td> <td> $klassenavn </td> <td> $studiumkode </td> </tr>";
    }
  print "</table>"; 
?>