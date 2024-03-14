var dugmeLogout = document.getElementById('dugmeLogout');
dugmeLogout.addEventListener('click', () => {
    function createLogoutDiv() {
        var logoutContainer = document.createElement("div");
        logoutContainer.className = "odjava";

        var logoutButton = document.createElement("button");
        logoutButton.className = "dugmeLogout";
        logoutButton.textContent = "Odjavi se";
        logoutButton.onclick = function() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../handlers/logout.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    location.reload();
                }
            };
            xhr.send();
            event.stopPropagation();
        };

        var selectObjava = document.createElement("select");
        selectObjava.name = "objava";
        selectObjava.style.width = "80%";
        selectObjava.id = "objava";

        var optionDefault = document.createElement("option");
        optionDefault.value = "";
        optionDefault.textContent = "Izaberite objavu";
        selectObjava.appendChild(optionDefault);

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../handlers/get_user_posts.php", true); // Promenjena putanja

        xhr.onreadystatechange = function() {
            
            if (xhr.readyState == 4 && xhr.status == 200) {
                var objave = JSON.parse(xhr.responseText);
                objave.forEach(function(objava) {
                    var option = document.createElement("option");
                    option.value = objava.ID_objave;
                    option.textContent = objava.naslov;
                    selectObjava.appendChild(option);
                });
            }
        };
        xhr.send();

        var obrisiButton = document.createElement("button");
        obrisiButton.className = "dugmeLogout";
        obrisiButton.textContent = "Obriši objavu";
        obrisiButton.onclick = function() {
            var selectedObjava = selectObjava.value;
            if (selectedObjava) {
               var xhrDelete = new XMLHttpRequest();
                xhrDelete.open("GET", "../handlers/delete_user_posts.php?id_objave=" + selectedObjava, true); // poziva skriptu za brisanje i dodaje jos i id objave koji nosi tamo kao parametar
                xhrDelete.onreadystatechange = function() {
                    if (xhrDelete.readyState == 4 && xhrDelete.status == 200) {
                        console.log(xhrDelete.responseText);
                        location.reload();
                    }
                };
                xhrDelete.send();
            } else {
                alert("Molimo vas izaberite objavu koju želite da obrišete.");
            }
        };
        
        logoutContainer.appendChild(logoutButton);
        logoutContainer.appendChild(obrisiButton);
        logoutContainer.appendChild(selectObjava);
        document.body.appendChild(logoutContainer);
        document.addEventListener('click', function(event) {
            if (!logoutContainer.contains(event.target) && event.target !== dugmeLogout) {
                logoutContainer.remove();
            }
        });
    }

    createLogoutDiv();
});
