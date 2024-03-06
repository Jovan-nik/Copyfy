document.getElementById("zaboraviliSteLozinku").addEventListener("click", function(event) {
    event.preventDefault(); 
    

    var loginEmail = document.getElementsByName("login_email")[0].value; 
    console.log(loginEmail);
    if (loginEmail === "") {
        document.getElementById("login_emailgreska").textContent = "Morate uneti email adresu.";
    } else {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../pages/novaLozinka.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById("login_emailgreska").textContent =xhr.responseText;

                } else {
                    document.getElementById("login_emailgreska").textContent = "Došlo je do greške prilikom slanja emaila.";
                }
            }
        };
        xhr.send("email=" + encodeURIComponent(loginEmail));
    }
});