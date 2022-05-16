<?php session_start()?>
<?php
    $conn = mysqli_connect('localhost', 'root', '', 'db_student') or die(" 0? cant connect");
    //COLLECTING THE CANDIDATES FROM DB to check for candidats 
    $query ="SELECT `matricule`,`nom`, `prenom` ,`score` FROM `db_student` WHERE `est_candidat`=1";
    $result = mysqli_query($conn,$query);
    $coordinates = array();
    if($result){
        $candidat_nom = array();       // to store the name 
        $candidat_prenom = array();    // to store the lastname
        $candidat_matricule = array(); //to store the id
        $candidat_score = array();     //to store the scores
        $i=0;
        
        while($row = mysqli_fetch_assoc($result)){
            $coordinates[] = $row; // stores all the rows in an array 
        }
        foreach($coordinates as $coordinate){
            $candidat_nom[$i] = $coordinate['nom'];
            $candidat_prenom[$i] = $coordinate['prenom'];
            $candidat_matricule[$i] = $coordinate['matricule'];
            $candidat_score[$i] = $coordinate['score'];
            $i++;
        }
        
        $_SESSION['candidats']['candidat_matricule'] = $candidat_matricule; //storing ids only 
        $_SESSION['candidats']['candidat_nom'] = $candidat_nom; //storing ids only 
        $_SESSION['candidats']['candidat_prenom'] = $candidat_prenom; //storing ids only 
        $_SESSION['candidats']['candidat_score'] = $candidat_score; //storing scores
        $_SESSION['candidats']['nbCandidats'] = $i; //storing the number of the current candidats

        //sending data to getCandidat in js 

    }else{
        echo"0?".mysqli_error($conn)."";
    }
    echo (json_encode($_SESSION['candidats']));    
    
?> 