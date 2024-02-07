function togglePsw(pswInput, togglePswButton) {

    togglePswButton.addEventListener('click', function() {

        if(pswInput.type == 'password'){
            pswInput.type = 'text';
            togglePswButton.classList.remove('fa-eye-slash');
            togglePswButton.classList.add('fa-eye');

        }else if(pswInput.type == 'text'){
            pswInput.type = 'password';
            togglePswButton.classList.remove('fa-eye');
            togglePswButton.classList.add('fa-eye-slash');
        }
       
    });   
    
}

let pswinput = document.getElementById('password');
let togglePswButton = document.getElementById('tooglepsw-button');

togglePsw(pswinput, togglePswButton);

let confirmPswinput = document.getElementById('confirm_password');
let toggleConfirmPswButton = document.getElementById('toogle-confirm-psw-button');

togglePsw(confirmPswinput, toggleConfirmPswButton);