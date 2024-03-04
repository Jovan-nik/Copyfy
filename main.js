
const wrapper=document.querySelector('.wrapper');
const loginLink=document.querySelector('.login-link');
const regLink=document.querySelector('.register-link');
const dugmeLogin=document.querySelector('.dugmeLogin');
const iks=document.querySelector('.iks');


regLink.addEventListener('click',()=>{
    wrapper.classList.add('active');
});
loginLink.addEventListener('click',()=>{
    wrapper.classList.remove('active');
})

dugmeLogin.addEventListener('click',()=>{
    wrapper.classList.add('active-iskoci');
})

iks.addEventListener('click',()=>{
    wrapper.classList.remove('active-iskoci');
});
