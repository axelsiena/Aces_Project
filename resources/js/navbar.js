document.addEventListener('DOMContentLoaded', function() {
    let modal = document.getElementById('loginregistermodal');
    let navbar = document.querySelector('.modalnav');
    let main = document.querySelector('main');

    // Quando il modale si apre
    modal.addEventListener('show.bs.modal', function() {
        
        navbar.classList.remove('fixed-top');
        main.classList.remove('my-5');
        main.classList.add('position-main');
    });

    
    modal.addEventListener('hide.bs.modal', function() {
       
        navbar.classList.add('fixed-top');
        main.classList.add('my-5');
        main.classList.remove('position-main');
    });
});
