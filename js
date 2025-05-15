// Halaman aktif yang tampil
function showPage(pageId) {
  document.querySelectorAll('.page').forEach(div => {
    div.style.display = 'none';
  });
  document.getElementById(pageId).style.display = 'block';
}

// Popup login/register
function showLogin() {
  document.getElementById('login-register-popup').style.display = 'flex';
  document.querySelector('.form-box.login').style.display = 'block';
  document.querySelector('.form-box.register
