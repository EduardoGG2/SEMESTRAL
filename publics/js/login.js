document.getElementById("formLogin").addEventListener("submit", function(e) {
    e.preventDefault();

    let usuario = document.getElementById("usuario").value;
    let password = document.getElementById("password").value;

    let datos = new FormData();
    datos.append("usuario", usuario);
    datos.append("password", password);

    fetch("backend/login.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.text())
    .then(res => {
        if (res === "OK") {
            window.location.href = "dashboard.html";
        } else {
            document.getElementById("msg").innerHTML = "Usuario o contraseña incorrectos";
        }
    });
});
