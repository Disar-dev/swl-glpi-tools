document.addEventListener("DOMContentLoaded", function () {
   const loginForm = document.querySelector("form[action*='login']");

   if (loginForm) {
        const divTitle = document.createElement("div");

        divTitle.classList.add("content-login-title");

        divTitle.innerHTML = "<h1>BIENVENIDO A LA MESA DE AYUDA DE SWISSLUB S.A.S</h1>";

      loginForm.parentNode.insertBefore(divTitle, loginForm);
   }
});

console.log("Custom JS cargado");