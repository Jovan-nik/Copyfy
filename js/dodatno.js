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
//JS ZA OBJAVU PREKO CELE STRANE
// window.addEventListener('load', function() {
//     // Pronađite sve elemente sa klasom 'objava'
//     var objave = document.querySelectorAll('.objava');

//     // Iterirajte kroz svaku objavu
//     objave.forEach(function(objava) {
        
//         // Dodajte event listener za klik na svaku objavu
//         objava.addEventListener('click', function() {

//             // Postavite stil diva objave da zauzima celu visinu ekrana
//             objava.style.height = '100vh'; // 100% visine ekrana
//             objava.style.position = 'fixed'; // Postavite poziciju na fiksnu kako bi pokrili celu stranicu
//             objava.style.top = '0'; // Postavite gornji rub na 0
//             objava.style.left = '0'; // Postavite levi rub na 0
//             objava.style.width = '100%'; // Postavite širinu na 100%
//             objava.style.zIndex = '9999'; // Postavite z-indeks na visok broj kako bi bila iznad ostalog sadržaja
//             objava.style.overflowY = 'auto'; // Omogućite skrolovanje ako je sadržaj prevelik za visinu ekrana
//         });
//     });
// });
//Kod koji podesava visinu diva sa objavama da odgovara ukupnom broju objava i plus filtrira objave preko tema
document.addEventListener("DOMContentLoaded", function() {
    
    function podesiVisinuObjava() {

        const prikazaneObjave = document.querySelectorAll('.objava[style="display: block;"]');

        let ukupnaVisina = 0;

        prikazaneObjave.forEach(function(objava) {
            ukupnaVisina += objava.offsetHeight;
        });

        document.querySelector('.objave').style.height = ukupnaVisina + 'px';
    }

    window.addEventListener('load', podesiVisinuObjava);

    const teme = document.querySelectorAll(".meni p");
    teme.forEach(tema => {
        tema.addEventListener("click", function() {
            const temaId = this.getAttribute("id");

            const sveObjave = document.querySelectorAll(".objava");
            sveObjave.forEach(objava => {
                objava.style.display = "none";
            });

            const odabraneObjave = document.querySelectorAll(`.objava[id-tema='${temaId}']`);
            odabraneObjave.forEach(objava => {
                objava.style.display = "block";
            });

            const temaElement = document.getElementById(temaId);
            const aktivanElement = document.querySelector('.meni p.active');
            if (aktivanElement) {
                aktivanElement.classList.remove('active');
            }
            temaElement.classList.add('active');

            podesiVisinuObjava();
        });
    });
});
document.addEventListener("DOMContentLoaded", function() {
    var tvoje_objave_link = document.getElementById("tvoje_objave");
    var ulogovani_korisnik_id = tvoje_objave_link.getAttribute("data-ulogovani-korisnik-id");


    tvoje_objave_link.addEventListener("click", function(event) {
        event.preventDefault();

        var objave = document.querySelectorAll(".objava");

        objave.forEach(function(objava) {
            var id_korisnika_objave = objava.getAttribute("id-korisnika");
            if (ulogovani_korisnik_id !== null && id_korisnika_objave !== ulogovani_korisnik_id.toString()) {
                objava.style.display = "none";
            } else {
                objava.style.display = "block";
            }
        });
    });
});