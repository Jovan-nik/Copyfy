document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.upvote').forEach(item => {
        item.addEventListener('click', event => {
            const currentState = item.getAttribute('data-state');
            const objavaId = item.getAttribute('id-objave');
            var tvoje_objave_link = document.getElementById("tvoje_objave");
            var ulogovani_korisnik_id = tvoje_objave_link.getAttribute("data-ulogovani-korisnik-id");

            if (currentState === 'outline') {
                // Slanje AJAX zahteva za upvoting objave
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '../handlers/upvote.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {

                        item.setAttribute('name', 'chevron-up-circle');
                        item.setAttribute('data-state', 'filled');
                    } else {

                        console.error('Došlo je do greške prilikom upvotinga.');
                    }
                };
                xhr.send('korisnik_id=' + ulogovani_korisnik_id + '&objava_id=' + objavaId);

            } else {

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '../handlers/delete_upvote.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {

                        item.setAttribute('name', 'chevron-up-circle-outline');
                        item.setAttribute('data-state', 'outline');
                    } else {

                        console.error('Došlo je do greške prilikom brisanja upvote-a.');
                    }
                };
                xhr.send('korisnik_id=' + ulogovani_korisnik_id + '&objava_id=' + objavaId);
            }
            item.classList.add('clicked');
            setTimeout(() => {
                item.classList.remove('clicked');
            }, 200);
        });
    });
});