listForm = document.getElementById('listForm');
formButton = document.getElementById('addTask');
showDiv = document.querySelector('.showToDoList');
completedTask = document.querySelector('.completedTask');
input = document.getElementById('title');

listForm.addEventListener('submit', function(e){
    e.preventDefault();

    const data = new FormData(listForm);
    //add a task 

    fetch('actions.php', {
        method: "POST",
        // headers: {
        //     "Content-Type": "application/json; charset=utf-8"
        // },
        body: data
    }).then(response=>{
        return response
    })

    getInfos();
    
})

getInfos();



function getInfos(){

    
    fetch('actions.php?select=ok', {
        method: "GET",
        headers: {
            "Content-Type": "application/json; charset=utf-8"
        },
        dataType: 'json',
    })
    .then(response=> response.json())
    .then(dataTask => {
        // console.log(dataTask);
        showDiv.innerHTML = "";
        for (const task of dataTask) {
            


            taskIds = task.id;
            console.log(task);
            //////if the task is not checked

                
                ///////////////////display results

                ////////////la div qui contien tout les elements
                const itemsDiv = document.createElement('div');
                showDiv.appendChild(itemsDiv);
                itemsDiv.setAttribute("class", "toDoItems");

                ///////////remove button
                const removeBtn = document.createElement('button');
                itemsDiv.appendChild(removeBtn);
                removeBtn.setAttribute("type", "button");
                removeBtn.setAttribute("class", "remove-to-do");
                removeBtn.setAttribute("id", taskIds);
                removeBtn.setAttribute("name", "delete");
                // removeBtn.setAttribute("name", "checkrmv");

                /////////le checkbox
                const checkbox = document.createElement('input');
                itemsDiv.appendChild(checkbox);
                checkbox.setAttribute("type", "checkbox");
                checkbox.setAttribute("class", "check-box");
                checkbox.setAttribute("id", taskIds);
                checkbox.setAttribute("name", "check")
            

                ////////////title
                const title = document.createElement('h2');
                itemsDiv.appendChild(title);
                title.innerText = task['title'];

                /////////date area
                const createDate = document.createElement('small');
                itemsDiv.appendChild(createDate);
                createDate.innerText = task['createDate'];

                // console.log(checkbox);

                checkbox.addEventListener("click", (e) =>{
                    e.preventDefault
                    let item = new FormData();
                    item.append("id", taskIds)

                    console.log(taskIds)
                    console.log(item)

                    fetch('actions.php?check=ok', {
                        method: "POST",
                        // headers: {
                        //     "Content-Type": "application/json; charset=utf-8"
                        // },
                        body: item
                        
                    }).then(response=>{
                        console.log(response)
                        return response
                    })
                    .then(items=>{
                        console.log(items)
                    })
                })



            ///les task finis



            
        };



    })
    


}
// getInfos();
function addTask(){

}

function checkTask(){

    check.addEventListener("click", (e) => {
        console.log(e);
        //e.preventDefault()
        let payload = new FormData(itemsDiv);
        payload.append("id", task.id)
        fetch('actions.php?update=ok', {
            method: "POST",
            body: payload
        })
            .then(response => {
                return response
            })

        fetch('actions.php?task=ok')
            .then(response => {
                return response.json()
            })
            .then(todo => {
                showDiv.innerHTML = ""
                for (const todos of showDiv) {
                    console.log(todos)
                    let place_todo = document.createElement("div")
                    place_todo.setAttribute("class", "place_todo")
                    todo.appendChild(place_todo)
                    place_todo.textContent = '-' + todos.tache + ' créée le ' + todos.date_creation
                    let check = document.createElement("button")
                    check.setAttribute("class", "check_id")
                    check.setAttribute('id', todos.id)
                    check.textContent = "✔"
                    place_todo.append(check)
                }
            })
            
        })

}

checkTask()
function deleteTask(){




}
deleteTask();