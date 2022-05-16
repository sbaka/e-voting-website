<?php session_start();?>
<?php
    //including the table
    include('createTable.php');
    if($_POST){
        $_SESSION['actual']['matricule'] = $_POST['matricule'];
        $_SESSION['actual']['nom'] = $_POST['nom'];
        $_SESSION['actual']['prenom'] = $_POST['prenom'];
    }
    $myDb = 'db_student';
    $errors = array('matricule' => '', 'nom' => '', 'prenom'=> '');
    //connect To the database
    $conn = mysqli_connect('localhost', 'root', '', $myDb) or die("0? cant connect");
    if(!$conn){
        echo "0? couldnt connect";
    }
 
    //receiving data from js then storing into variables
    $matricule  = isset($_POST['matricule']) ? $_POST['matricule']:''; 
    $nom = isset($_POST['nom']) ? $_POST['nom']:'';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom']:'';
    $est_candidat = isset($_POST['candidat']) ? 1: 0;

    //COLLECTING THE CANDIDATES FROM DB to check for candidats 
    $query ="SELECT `matricule`,`nom`, `prenom` FROM `db_student` WHERE `est_candidat`=1";
    $result = mysqli_query($conn,$query);
    $coordinates = array();
    if($result){
        $candidat_nom = array();       // to store the name 
        $candidat_prenom = array();    // to store the lastname
        $candidat_matricule = array(); //to store the id
        $i=1;
        
        while($row = mysqli_fetch_assoc($result)){
            $coordinates[] = $row; // stores all the rows in an array 
        }
        foreach($coordinates as $coordinate){
            $candidat_nom[$i] = $coordinate['nom'];
            $candidat_prenom[$i] = $coordinate['prenom'];
            $candidat_matricule[$i] = $coordinate['matricule'];
            $i++;
        }
    }    
    
    if($matricule !=""){
        $query = "SELECT * FROM `db_student` WHERE matricule='$matricule' and nom='$nom' and prenom = '$prenom'";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $count = mysqli_num_rows($result);
        if ($count == 1){
            $current_Logged = mysqli_fetch_assoc($result);
            $voted = $current_Logged['a_voter'];
            if($voted == 0){
                echo "1? Bonjour ".$_SESSION['actual']['nom']." ".$_SESSION['actual']   ['prenom']."";  //To display the welcome message ALL SUCCESS MESSAGES START WITH 1?
            }else{
                echo"1? !!";
            }
            
        }else{//inserting the data to the db only when there is $matricule
            $sql = "INSERT INTO `db_student` (`matricule`, `nom`, `prenom`,`est_candidat`) VALUES ('$matricule', '$nom', '$prenom', '$est_candidat');";
            if(mysqli_query($conn, $sql)){
                echo "1? Bonjour ".$_SESSION['actual']['nom']." ".$_SESSION['actual']   ['prenom']."";  //To display the welcome message ALL SUCCESS MESSAGES START WITH 1?
            }else{
                $error = mysqli_error($conn);
                $duplicata = "Duplicata";
                $ignoredMsg = "Incorrect integer value: '' for column 'matricule' at row 1"; // there is an error at line 17 so i ignore it
                if(strstr($error,$ignoredMsg) != $ignoredMsg){// if its something else than that erro i display it 
                    echo  "0? ".$error.""; //ALL ERRORS START WITH 0?
                }
            }
        }
    }
    
?>