document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
    
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

   
    if (username !== "" && password !== "") {
        
        document.getElementById("loginMessage").innerText = "Inicio de sesión exitoso!";
        document.getElementById("loginMessage").style.color = "green";
        window.location.href = "usuarios.html";  
    } else {
        document.getElementById("loginMessage").innerText = "Por favor, ingresa tus credenciales.";
        document.getElementById("loginMessage").style.color = "red";
    }

    
    if (username === "tecnico" && password === "5678") {
        document.getElementById("loginMessage").innerText = "Inicio de sesión exitoso como Técnico!";
        document.getElementById("loginMessage").style.color = "green";
        window.location.href = "mantenimiento.html";  
        return; 
    } 
    if (username === "admin" && password === "1234") {
        document.getElementById("loginMessage").innerText = "Inicio de sesión exitoso como Admin!";
        document.getElementById("loginMessage").style.color = "green";
        window.location.href = "index.html";  
        return; 
    } 

   
    if (username === "" || password === "") {
        document.getElementById("loginMessage").innerText = "Por favor, completa ambos campos.";
        document.getElementById("loginMessage").style.color = "red";
    }
});
