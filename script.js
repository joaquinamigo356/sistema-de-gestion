document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
    // Obtén los valores ingresados
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    // Comprobar si username y password son diferentes de vacío
    if (username !== "" && password !== "") {
        // Redireccionar a 'usuarios.html' para cualquier combinación válida
        document.getElementById("loginMessage").innerText = "Inicio de sesión exitoso!";
        document.getElementById("loginMessage").style.color = "green";
        window.location.href = "usuarios.html";  // Redirige a 'usuarios.html'.
    } else {
        document.getElementById("loginMessage").innerText = "Por favor, ingresa tus credenciales.";
        document.getElementById("loginMessage").style.color = "red";
    }

    // Comprobaciones específicas para tecnico y admin
    if (username === "tecnico" && password === "5678") {
        document.getElementById("loginMessage").innerText = "Inicio de sesión exitoso como Técnico!";
        document.getElementById("loginMessage").style.color = "green";
        window.location.href = "mantenimiento.html";  // Redirige a 'mantenimiento.html'.
        return; // Detener ejecución para evitar redirección a 'usuarios.html'
    } 
    if (username === "admin" && password === "1234") {
        document.getElementById("loginMessage").innerText = "Inicio de sesión exitoso como Admin!";
        document.getElementById("loginMessage").style.color = "green";
        window.location.href = "index.html";  // Redirige a 'index.html'.
        return; // Detener ejecución para evitar redirección a 'usuarios.html'
    } 

    // Si el username y password no son válidos
    if (username === "" || password === "") {
        document.getElementById("loginMessage").innerText = "Por favor, completa ambos campos.";
        document.getElementById("loginMessage").style.color = "red";
    }
});
