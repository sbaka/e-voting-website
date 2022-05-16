const btn = document.querySelector(".continuer input[type=\"submit\"]")
const btn1 = document.querySelector(".validate input[type=\"submit\"]")
const loginScreen = document.querySelector(".login")
const loginForm = document.getElementById("indetification")
const voteForm = document.getElementById("vote")
const voteScreen = document.querySelector(".vote_page")
const checkbox = document.getElementById("candidat")
const votingDiv = document.querySelector(".container")
const waitingScreen = document.querySelector(".not_ready")
const waitingScreen_title = document.querySelector(".not_ready h2")
const nomCandidat = document.querySelectorAll(".candidat")
const textInput = document.querySelectorAll("form input[type=\"text\"]")
const rbs =document.querySelectorAll('input[name="choix"]')
const resultScreen = document.querySelector(".display_results")

 
//declaration des variable
let msgToDispolay =''
var candidatNum = 0
let candidatScore = Array()

disableAutocomplete()

//recevoir les données du serveur les traité puis les renvoyé // j'utilise ca pour l'affichage des messages et les animation
btn.addEventListener("click",()=>{
    loginForm.addEventListener('submit',e=>{
        e.preventDefault() //to prevent the page from refreshing and allow the transition
        const responseText = document.querySelector("#formDataDisplay");

        request = new XMLHttpRequest() //sending the actual data to the server
        request.open("post","server.php")
        request.onload = ()=>{
            msgToDispolay = request.responseText

            if(msgToDispolay.includes("1?")){ // j'ai fais en sorte que tout les message de success commence par 1? pour savoir quoi afficher
                loginScreen.classList.add("fadeOut")    
                if(msgToDispolay == "1? !!"){
                    voted(request.responseText,10)
                }else{
                    voteScreen.classList.add("fadeIn")
                }
                // setting the candidats in the votingScreen and the afterVoting screen
                getCandidats()

            }else if(msgToDispolay.includes("0?")){
                alert("Ce matricule est déjâ utilisé !")
            }
        }
        request.send(new FormData(loginForm))
    })
})


//recevoir le candidat selectioné puis appel la fcn voted pour afficher une confirmation et afficher les resultats
btn1.addEventListener("click",()=>{
    voteForm.addEventListener('submit',e=>{
        e.preventDefault() //to prevent the page from refreshing and allow the transition
        const responseText = document.querySelector(".voted h2");
        request = new XMLHttpRequest(); //sending the actual data to the server
         request.open("post","voting.php")
        request.onload = ()=>{
            if(selectedCandidat()){ // if there is a selected choice send data form to server !! 
            
                if(request.responseText.search("1?") != -1 ){ // if the message isnt an error
                    voted(request.responseText,2800)
                    getCandidats()
                }else{
                    alert("erreur" + request.responseText)
                }
            }
            else{
                if(confirm("Voulez-vous vraiment soumettre un vote blanc?")){
                    if(request.responseText.search("1? !!") != -1 ){ // if the message isnt an error
                        resultScreen.classList.add("fadeIn")
                        voteScreen.classList.remove("fadeIn")
                        getCandidats()
                    }else{
                        alert("erreur" + request.responseText)
                    }
                }
            }
        }
        request.send(new FormData(voteForm))
        
    })
})



//displaying a welcome message dans VotingScreen
function wlcmMsg(msgToDispolay){
    votingTitle = document.querySelector(".question");
    welcomeTitle =document.querySelector(".welcome");
    welcomeTitle.innerHTML = msgToDispolay.replace('1? ','');;
    setTimeout(()=>{
        votingTitle.classList.add("fadeIn");
        welcomeTitle.classList.add("fadeOut");
    }, 1800 );
}  

//activates when the vote is submitted 
function voted(msgToDispolay,timer){
    afterVoteScreen = document.querySelector(".container_afterVote")
    bfrVoteScreen = document.querySelector(".container")
    Confirmation = document.querySelector("#candidat")
    //afficher la confirmation du vote
    Confirmation.innerHTML = msgToDispolay.replace("1? ",'')//remove the 1
    afterVoteScreen.classList.add("fadeIn")
    bfrVoteScreen.classList.add("fadeOut")
    
    //afficher les scores 
    setTimeout(()=>{
        afterVoteScreen.classList.add("fadeOut")
        resultScreen.classList.add("fadeIn")
        voteScreen.classList.remove("fadeIn")
    }, timer)
} 

//checks if there is enough candidats
function getCandidats(){
    array = Array.from(nomCandidat)
    //CandidatsNameForStats = Array.from(nomCandidatStat)
    request = new XMLHttpRequest()
    request.open("get","getCandidat.php")
    var myObj = new Object();
    
    // on load set the names of the candidats in all pages
    request.onload = function setCandidats(){
        winnerName = document.querySelector("#first p")
        secondName = document.querySelector("#second p")
        //get the candidats from getCandidat.php and parse them into json then display them
        
        myObj = JSON.parse(request.responseText)
        let candidat =''
        for (const i in myObj.candidat_nom) {
            if (myObj.candidat_nom.hasOwnProperty(i)) {
                //concat firstname and lastname of a candidat
                candidat = myObj.candidat_nom[i].concat(" ".concat(myObj.candidat_prenom[i]))

                array[i].innerHTML = candidat
                //CandidatsNameForStats[i].innerHTML = candidat
            }
        }

        if(myObj.nbCandidats== 5){ // si il ya assez de candidat
            votingDiv.classList.add("fadeIn")
            waitingScreen.classList.add("fadeOut")
            wlcmMsg(msgToDispolay) //msgtodisplay is set in the btn eventlistener
        }else{
            waitingScreen_title.innerHTML = "En Attente de candidats*, il y en a couramment " + myObj.nbCandidats+ "."
        }
        console.log(myObj)
        //setting the winners
        setScore(myObj)
    }
    request.send()
}

//update les scores et les affiches
function setScore(obj){
    //outils canvasJS pour le graphe
    var chart = new CanvasJS.Chart("chartContainer", {
        theme:"dark2",
        animationEnabled: true,
        height: 300,
        backgroundColor:"transparent",
        animationDuration: 2300,
        data: [{
            type: "doughnut",
            startAngle: 60,
            innerRadius: 100,
            indexLabelFontSize: 17,
            indexLabelFontFamily: "Montserrat",
            indexLabelFontWeight: "bold",
            indexLabelFontColor: "#3d3d3d",
            indexLabel: "{label} - #percent%",
            toolTipContent: "<b>{label}:</b> {y} (#percent%)",
            dataPoints: [
                { y: parseInt(obj.candidat_score[0]), label: obj.candidat_nom[0].concat(" ".concat(obj.candidat_prenom[0])) },
                { y: parseInt(obj.candidat_score[1]), label: obj.candidat_nom[1].concat(" ".concat(obj.candidat_prenom[1])) },
                { y: parseInt(obj.candidat_score[2]), label: obj.candidat_nom[2].concat(" ".concat(obj.candidat_prenom[2])) },
                { y: parseInt(obj.candidat_score[3]), label: obj.candidat_nom[3].concat(" ".concat(obj.candidat_prenom[3]))},
                { y: parseInt(obj.candidat_score[4]), label: obj.candidat_nom[4].concat(" ".concat(obj.candidat_prenom[4]))},
            ]
        }]
    })
    chart.render()
}

    

//stops any other entry then numbers in the textfield MATRICULE
function isNumber(evt) { 
    var iKeyCode = (evt.which) ? evt.which : evt.keyCode
    if (iKeyCode < 48 || iKeyCode > 57)
        return false

    return true
}

//stops any other entry then letters in the text field  PRENOM NOM 
function isLetter(evt) {    
    var iKeyCode = (evt.which) ? evt.which : evt.keyCode
    if (iKeyCode!=32 && (iKeyCode < 97 || iKeyCode > 122)&& (iKeyCode < 65 || iKeyCode > 90))
        return false

    return true
}

// returns the selected candidat from the radio btn
function selectedCandidat(){ 
    let selectedValue
    for (const rb of rbs) {
        if (rb.checked) {
            selectedValue = rb.value
            break
        }
    }
    return selectedValue
}

//prevents autocompletion dans le formulaire
function disableAutocomplete(){
    array = Array.from(textInput)
    for (let i = 0; i < array.length; i++) {
        array[i].setAttribute("autocomplete","off")
    }
}