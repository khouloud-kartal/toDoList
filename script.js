///////////////the transition between the register form and the login form


let loginBtn = document.getElementById('login-btn');
let registerBtn = document.getElementById('register-btn');

let loginForm = document.getElementById('login');
let registerForm = document.getElementById('register');

let button = document.getElementById('btn');

loginBtn.addEventListener("click",()=>{
    loginForm.style.left = "50px";
    registerForm.style.left = "450px";
    button.style.left = "0px";

})

registerBtn.addEventListener("click",()=>{
    loginForm.style.left = "-400px";
    registerForm.style.left = "50px";
    button.style.left = "110px";
})







