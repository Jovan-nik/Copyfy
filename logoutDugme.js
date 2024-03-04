    var dugmeLogout=document.getElementById('dugmeLogout');
    dugmeLogout.addEventListener('click',()=>{
        function createLogoutDiv() {
            var logoutContainer = document.createElement("div");
            logoutContainer.className = "odjava";
            
            var logoutButton = document.createElement("button");
            logoutButton.className = "dugmeLogout";
            logoutButton.textContent = "Odjavi se";
            logoutButton.onclick = function() {
                // Ovde dodajemo AJAX zahtev za logout.php
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "logout.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Stranica je uspešno odjavila korisnika, sada osvežavamo stranicu
                        location.reload(); // Ovo osvežava stranicu
                    }
                };
                xhr.send();
                event.stopPropagation();
            };
            
            logoutContainer.appendChild(logoutButton);
            document.body.appendChild(logoutContainer);
            // Dodajemo event listener na celo telo dokumenta kako bismo pratili klikove van diva "odjava"
            document.addEventListener('click', function (event) {
                if (!logoutContainer.contains(event.target) && event.target !== dugmeLogout) {
                    // Ako je kliknuto van diva "odjava" i nije kliknuto dugme za logout, sklanjamo div
                    logoutContainer.remove();
                }
            });
        }
        
        createLogoutDiv();
    })