document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.upvote').forEach(item => {
        item.addEventListener('click', event => {
            const currentState = item.getAttribute('data-state');
            const objavaId = item.getAttribute('data-objava-id'); // Dobijanje ID-ja objave iz data atributa
            var tvoje_objave_link = document.getElementById("tvoje_objave");
            var ulogovani_korisnik_id = tvoje_objave_link.getAttribute("data-ulogovani-korisnik-id");
            // Ako korisnik nije upvotovao objavu
            if (currentState === 'outline') {
                // Slanje AJAX zahteva za upvoting objave
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '../handlers/upvote.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Ažuriranje UI-a ako je upvoting uspešno završen
                        item.setAttribute('name', 'chevron-up-circle');
                        item.setAttribute('data-state', 'filled');
                    } else {
                        // Ukoliko dođe do greške prilikom upvotinga, ispišite poruku ili obavestite korisnika
                        console.error('Došlo je do greške prilikom upvotinga.');
                    }
                };
                xhr.send('korisnik_id=' + ulogovani_korisnik_id + '&objava_id=' + objavaId);

            } else {
                // Slanje AJAX zahteva za brisanje upvote-a iz baze
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '../handlers/delete_upvote.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Ažuriranje UI-a ako je brisanje upvote-a uspešno završeno
                        item.setAttribute('name', 'chevron-up-circle-outline');
                        item.setAttribute('data-state', 'outline');
                    } else {
                        // Ukoliko dođe do greške prilikom brisanja upvote-a, ispišite poruku ili obavestite korisnika
                        console.error('Došlo je do greške prilikom brisanja upvote-a.');
                    }
                };
                xhr.send('korisnik_id=' + ulogovani_korisnik_id + '&objava_id=' + objavaId);
            }

            // Ostatak koda ostaje isti
            item.classList.add('clicked');
            setTimeout(() => {
                item.classList.remove('clicked');
            }, 200);
        });
    });
});