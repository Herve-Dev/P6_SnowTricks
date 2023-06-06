//Vérification Front mot de passe
const inputPassRegister = document.getElementById('registration_form_plainPassword');
const btnRegister = document.querySelector('.btn-register');
btnRegister.disabled = true;
console.log(btnRegister);

inputPassRegister.addEventListener('change', () => {
    const password = inputPassRegister.value;
    const regex = /^(?=.*[A-Z])(?=.*\W).{8,}$/;

    if (!regex.test(password)) {
        UIkit.notification({
            message: 'Mot de passe invalide',
            status: 'danger',
            pos: 'top-right',
            timeout: 5000
        });
        inputPassRegister.classList.add('uk-animation-shake')
        inputPassRegister.style.border = '1px solid red';

    } else {
        btnRegister.disabled = false;
        inputPassRegister.style.border = '1px solid green';
    }
})