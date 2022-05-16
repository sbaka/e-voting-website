<?php session_start();?>
<?php
    //connecting to database
    $conn = mysqli_connect('localhost', 'root', '', 'db_student') or die(" 0? cant connect");

    
    $matricule  = $_SESSION['actual']['matricule'];
    $nom = $_SESSION['actual']['nom'];
    $prenom = $_SESSION['actual']['prenom'];

    //setting a_voter a 1 value when vote is pressed and incrementing the score
    if(isset($_POST['choix'])){
        $candidat_choisis = $_POST['choix'] - 1;

        //fetching data to update score
        $request = "SELECT `matricule`,`nom`, `prenom`,`score` FROM `db_student` WHERE `matricule`=".$_SESSION['candidats']['candidat_matricule'][$candidat_choisis]."";
        $result = mysqli_query($conn,$request);
        if($result){
            //fetch sccore 
            $selectedCandidate = mysqli_fetch_assoc($result);
            $score = $selectedCandidate['score']; 
            $score = $score + 1 ;
            mysqli_free_result($result);
            //send an update query to db
            $request = "UPDATE `db_student` SET `score`= ".$score." WHERE `matricule` =".$selectedCandidate['matricule']."";
            $result = mysqli_query($conn,$request);
            if($result){
                // if score is udated add a_voter=1 to matricule
                $query = "UPDATE `db_student` SET `a_voter`= 1 WHERE `matricule` = '$matricule'";
                if(mysqli_query($conn,$query)){
                    //displaying a success message when voted
                    echo "1? ".$selectedCandidate['nom']." ".$selectedCandidate['prenom']."";
                }
            }
             
        }else{
            echo "0? ".mysqli_error($conn);
        }
    }else{
        
        // if score is udated add a_voter=1 to matricule
        $query = "UPDATE `db_student` SET `a_voter`= 1 WHERE `matricule` = '$matricule'";
        if(mysqli_query($conn,$query)){
            //displaying a success message when voted
            echo "1? !!";
        }
    }
    
    session_unset();
?>