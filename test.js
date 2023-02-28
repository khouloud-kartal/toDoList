function createToDoTaskLine() {

    /********** Créer une div pour chaque tache (pour CSS) **********/
    const oneTaskDiv = document.createElement("div");
    oneTaskDiv.setAttribute("class", "uneTacheLigne");

    const toDoDiv = document.createElement("div");
    oneTaskDiv.setAttribute("id", "toDoDiv");

    const compteToDo = 0;
    const checkboxId = i;
    
    if(element['isChecked'] == 0) {

        toDoDiv.appendChild(oneTaskDiv);

        /**************** Create the checkbox ****************/
        const checkboxVide = document.createElement("input");
        checkboxVide.setAttribute("type", "checkbox");
        checkboxVide.setAttribute("name", element['id']);
        checkboxVide.setAttribute("id", checkboxId);
        //checkboxVide.setAttribute("class", 'checkbox');
        oneTaskDiv.appendChild(checkboxVide);

        /****************** Create the title ******************/
        const titreTacheListe = document.createElement("p");
        titreTacheListe.innerHTML = element['content'];
        oneTaskDiv.appendChild(titreTacheListe);

        /**************** Create suppr button ****************/
        const supprButton = document.createElement("button");
        supprButton.setAttribute("name", element['id']);
        supprButton.setAttribute("id", "suppr");
        supprButton.innerText = "Supprimer";
        oneTaskDiv.appendChild(supprButton);

        compteToDo++;
    }

    return toDoDiv;
}

function createCompletedTaskLine() {

    /*********** Create a div to put each task ************/
    const oneTaskDivCompl = document.createElement("div");
    oneTaskDivCompl.setAttribute("class", "uneTacheLigne");

    const compteCompleted = 0;
    const checkboxId = i;

    if(element['isChecked'] == 1) {

        completedTasks.appendChild(oneTaskDivCompl);

        /**************** Create the checkbox *****************/
        const checkboxChecked = document.createElement("input");
        checkboxChecked.setAttribute("type", "checkbox");
        checkboxChecked.setAttribute("name", element['id']);
        checkboxChecked.setAttribute("class", 'checkboxChecked');
        checkboxChecked.setAttribute("id", checkboxId);
        checkboxChecked.checked = true;
        //checkboxVide.setAttribute("class", 'checkbox');
        oneTaskDivCompl.appendChild(checkboxChecked);

        /****************** Create the title ******************/
        const titreTacheListe = document.createElement("p");
        titreTacheListe.innerHTML = element['content'];
        oneTaskDivCompl.appendChild(titreTacheListe);

        /***************** Create suppr button ****************/
        const supprButton = document.createElement("button");
        supprButton.setAttribute("name", element['id']);
        supprButton.setAttribute("id", "suppr");
        supprButton.innerText = "Supprimer";
        oneTaskDivCompl.appendChild(supprButton);

        compteCompleted++;
    }

    return compteCompleted;
}

async function getAllTasks() {

    // Fetch all tasks from the database
    const response = await fetch('back/taskRecupBack.php');
    const jsonTaches = await response.json();

    return jsonTaches;
    
}

async function addTask(formData) {

    // Add the task to the database
    const response = await fetch("back/taskAddBack.php", {method: "POST", body: formData,});
    const result = await response.text();

    return result;

}

async function displayTask() {

    jsonTaches = getAllTasks();          // Get the tasks from the database

    toDoTasks.innerHTML = "";

    for (let i = 0; i < jsonTaches.length; i++) {       // Parcourir le tableau des taches
        const element = jsonTaches[i];      // Cibler chaque element du tableau

        createToDoTaskLine();

        createCompletedTaskLine();
    }

}

const toDoTasks = document.getElementById('toDoTasks');
const completedTasks = document.getElementById('completedTasks');
const formAddTask = document.getElementById('formAddTask');
const checkboxChecked = document.getElementsByClassName('checkboxChecked');
const checkboxVide = document.getElementsByClassName('checkboxVide');

const toDoDiv = displayTask();
toDoTasks.appendChild(toDoDiv);

formAddTask.addEventListener('submit', (e) => {

    e.preventDefault();

    const formData = new FormData(formAddTask);
    formData.forEach((value, key) => {
        console.log(key + ':' + value);
    });

    addTask();

});


// ajouter addEventListener sur chaque checkbox (childNode?)
const idCheckbox = document.getElementById(checkboxId);

idCheckbox.addEventListener('click', () => {
    const idTemp = idCheckbox.parentNode;
    const idParent = idTemp.parentNode.id;
    const name = idCheckbox.name;

    if(idParent === "toDoTasks") {

        fetch("back/taskCheckBack.php", {
            method: "POST",
            body: name,
        })
        .then(response => {
            console.log(response.text());
    
            displayTask();
    
        });
    }
})