var vise = document.getElementById("vise");
var dodatno = document.getElementById("dodatno");
var prikazano = false;

    vise.addEventListener("click", function() {
        if (!prikazano) {
            dodatno.style.display = "block";
            prikazano = true;
        } else {
            dodatno.style.display = "none";
            prikazano = false;
        }
    });

