

<!--
    /*****************************IMPORTANT*******************************/
    ->  Il n y a qu'une seule page dans tout le site les forms et tout seront afficher au bon moment grace
    a une transition d'opacité css et pointer-events: non et du js.
    -> J'utilise js (requete XMLHttp) pour traité les données avant de les afficher sur la page, tout cella pour evité le raffrechissement
    au moment de la submission des formulaire.
    -> TOUT EST COMMENTé si vous ne comprenez pas quelque chose priere de me contacter, merci.
-->



<?php   
    include('server.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <title>E-VOTE</title>
</head>

<body>

    <section class="login"><!--should be fadeIn-->
        <div class="center">  
            <h1>S'identifier</h1>
            <form method="post" action="index.php" id="indetification" > 
                <div class="text_field">        
                    <input type="text" name="matricule" onkeypress="javascript:return isNumber(event)" maxlength="12" minlength="12" required>
                    <label for="">Matricule</label>
                    <div class="underline"></div>
                    <div class="red_text"><?php echo $errors['matricule'] ?></div>
                </div>
    
                <div class="text_field">                
                    <input  type="text" name = "nom" onkeypress="javascript:return isLetter(event)" required>
                    <label for="">Nom</label>
                    <div class="underline"></div>
                    
                </div>
    
                <div class="text_field">                
                    <input type="text" name = "prenom" onkeypress="javascript:return isLetter(event)" required>
                    <label for="">Prénom</label>
                    <div class="underline"></div>
                    
                </div>
    
                <div class="candidate">
                    <input type="checkbox" id="checkB" name ="candidat" disabled> <label>Se presenter en tant que candidat.</label>
                        <?php
                            //getting the number of the current candidate
                            $query ="SELECT `nom`, `prenom` FROM `db_student` WHERE `est_candidat`=1";
                            $result = mysqli_query($conn,$query);
                            if($result){
                                $coordinates = array();
                                while($row = mysqli_fetch_assoc($result)){
                                    $coordinates[] = $row;
                                }
                                echo"<p>Il y a actuellement <u><b>".sizeof($coordinates)."</b></u> candidats (max 5)</p> ";
                                if(sizeof($coordinates)<5){
                                    echo"<script type=\"text/javascript\">
                                            document.getElementById(\"checkB\").disabled = false;
                                        </script>";
                                }
                            }
                        ?>  
                </div>
            <div class="continuer">
                <input type="submit" value="continuer" name="continuer">
            </div>
            </form>
            
        </div>
    </section>
    



    <section class="vote_page fadeOut"> <!--should be fadeOut--> 
        <h1>E-Voting</h1>
        
        <div class="container fadeOut"> <!--should be fadeOut--> 
            <h2 class="question fadeOut">Qui voulez-vous voter pour?</h2>
            <h2 class="welcome "></h2>
            <form action="" method="post" id="vote">
                <div class="voteSection ">
                    <div class="inputGroup">
                        <input type="radio" name="choix" id="premier" value="1">
                        <label for="premier" class="candidat"></label>
                    </div>

                    <div class="inputGroup">
                        <input type="radio" name="choix" id="deux" value="2">
                        <label for="deux"class="candidat"></label>
                    </div>
                    
                    <div class="inputGroup">
                        <input type="radio" name="choix" id="trois" value="3">
                        <label for="trois"class="candidat"></label>
                    </div>
                    
                    <div class="inputGroup">
                        <input type="radio" name="choix" id="quatre" value="4">
                        <label for="quatre"class="candidat"></label>
                    </div>

                    <div class="inputGroup">
                        <input type="radio" name="choix" id="cinq" value="5">
                        <label for="cinq" class="candidat"></label>
                    </div>

                </div>
                <div class="validate">
                    <input type="submit" value="vote" name="vote">
                    <!--<button type="submit" name="vote">Vote</button>-->
                    
                </div>
                
            </form>
            
        </div>

        <div class="container_afterVote fadeOut"> <!--should be fadeOut--> 
            <div class="voted">
                <h2>Merci pour votre vote! <br> Vous avez voter pour le candidat: </h2>
                <h2 id="candidat">Kebraoui Abdellatif</h2>
            </div>
        </div>

        <div class="not_ready"> <!--should be fadeIn--> 
            <h2></h2>
            <p>*Il faut 5 candidats pour commencer le vote.</p>
        </div>
    </section>




    <section class="display_results fadeOut"> <!--should be fadeOut-->
        <h1>E-Voting</h1>                    
        <div class="results_container">
            <h2>Les resultats du vote !</h2>                         
            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        </div>
    </section>
</body>
<script src="script.js"></script>
</html>