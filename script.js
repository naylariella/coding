const coverBox = document.querySelector('.cover_box');
const loginForm = document.querySelector('.form-box.login');
const registerForm = document.querySelector('.form-box.register');
const loginBtn = document.querySelector('.btnLogin-popup');
const closeBtn = document.getElementById('closeBtn');
const registerLink = document.getElementById('toRegister');
const loginLink = document.getElementById('toLogin');

loginBtn.addEventListener('click', () => {
    coverBox.classList.add('active-popup'); 
    coverBox.classList.remove('active');
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
});

registerLink.addEventListener('click', (e) => {
  e.preventDefault();
  coverBox.classList.add('active-popup', 'active')
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';
});

loginLink.addEventListener('click', (e) => {
    e.preventDefault();
    coverBox.classList.remove('active')
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
});

closeBtn.addEventListener('click', () => {
    coverBox.classList.remove('active-popup');
    coverBox.classList.remove('active');
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
});

window.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  if (params.get('popup') === 'login') {
    coverBox.classList.add('active-popup');
    coverBox.classList.remove('active');
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
  }
});
