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
document.addEventListener("DOMContentLoaded", function() {

    
    function podesiVisinuObjava() {

        const prikazaneObjave = document.querySelectorAll('.objava[style="display: block;"]');

        let ukupnaVisina = 0;

        prikazaneObjave.forEach(function(objava) {
            ukupnaVisina += objava.offsetHeight;
        });

        document.querySelector('.objave').style.height = ukupnaVisina + 'px';
    }


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
            console.log(podesiVisinuObjava());
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
            window.scrollTo(0, 0);
        });
    });
});
//refresha kad se stisne home i ime
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("home").addEventListener("click", function() {
        location.reload();
    });
});
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("logo").addEventListener("click", function() {
        location.reload();
    });
});
//SEARCH
function createSearchBar() {
    var searchBar = document.createElement('div');
    searchBar.id = 'searchBar';
    searchBar.style.display = 'none';

    var searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Pretraži...';
    searchInput.className = 'searchInput'; 

    var searchIcon = document.createElement('ion-icon');
    searchIcon.setAttribute('name', 'search-outline');

    searchBar.appendChild(searchInput);
    searchBar.appendChild(searchIcon);

    document.querySelector('header').appendChild(searchBar);

    document.getElementById('toggleSearch').addEventListener('click', function(event) {
        searchBar.style.display = (searchBar.style.display === 'none' || searchBar.style.display === '') ? 'block' : 'none';
        event.stopPropagation(); 
    });

    document.addEventListener('click', function(event) {
        var clickedElement = event.target;
        if (!searchBar.contains(clickedElement)) {
            searchBar.style.display = 'none';
            searchInput.value = ''; 
            clearHighlightedText(); 
        }
    });

    searchInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            search();
        }
    });
}

function clearHighlightedText() {
    var markedElements = document.querySelectorAll('mark');
    markedElements.forEach(function(element) {
        element.outerHTML = element.innerHTML;
    });
}

function search() {
    var searchTerm = document.querySelector('.searchInput').value.trim();
    var searchRegex = new RegExp(searchTerm, 'gi');
    var foundText = false;

    var allTextNodes = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, null, false);
    var currentNode;

    while (currentNode = allTextNodes.nextNode()) {
        if (currentNode.parentNode.nodeName !== 'SCRIPT' && currentNode.parentNode.nodeName !== 'STYLE') {
            var text = currentNode.nodeValue.trim();

            if (searchRegex.test(text)) {
                foundText = true;
                var range = document.createRange();
                range.setStart(currentNode, text.toLowerCase().indexOf(searchTerm.toLowerCase()));
                range.setEnd(currentNode, text.toLowerCase().indexOf(searchTerm.toLowerCase()) + searchTerm.length);
                var selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(range);
                currentNode.parentNode.scrollIntoView({ behavior: 'smooth', block: 'start' });
                break;
            }
        }
    }


    if (foundText && event.type === 'keypress' && event.key === 'Enter') {
        event.preventDefault();
    }
}

createSearchBar();
//NISAM imao vremena da zavrsim svoju "kreativnu zamisao" trebao sam da uradim da kada se stisne na objavu da prekrije ceo ekran i da naravno da se 
//to razradi jos malo i da se omoguci komentarisanje na objavu i odgovaranje na komentare kao i izmena same objave i komentara, ali nema veze


// document.addEventListener('DOMContentLoaded', function () {
//     const objave = document.querySelectorAll('.objava');

//     objave.forEach(objava => {
//         objava.addEventListener('click', function () {
//             const fullscreenOverlay = document.createElement('div');
//             fullscreenOverlay.classList.add('fullscreen-overlay');
//             const fullscreenContent = document.createElement('div');
//             fullscreenContent.classList.add('fullscreen-content');
//             const backgroundImage = window.getComputedStyle(this).getPropertyValue('background-image');
//             const backgroundImageUrl = backgroundImage.replace(/linear-gradient\(.*\),/g, '');
//             const imagePath = backgroundImageUrl.substring(backgroundImageUrl.indexOf('images/'));
//             const cleanedImagePath = imagePath.replace(/['"]+/g, '');
//             const img = document.createElement('img');
//             img.src = cleanedImagePath;

//             img.style.maxWidth = '100%';
//             img.style.maxHeight = '80vh';
//             img.style.marginBottom = '20px';

//             fullscreenContent.appendChild(img);

//             fullscreenContent.innerHTML += this.innerHTML;

//             fullscreenOverlay.appendChild(fullscreenContent);
//             document.body.appendChild(fullscreenOverlay);

//             fullscreenOverlay.addEventListener('click', function () {
//                 this.remove();
//             });
//             fullscreenContent.addEventListener('click', function (e) {
//                 e.stopPropagation();
//             });

//             fullscreenOverlay.style.display = 'block';
//         });
//     });
// });