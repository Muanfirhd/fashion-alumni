// js/script.js — FAOSC
document.addEventListener('DOMContentLoaded', function () {
  // Toggle sidebar admin (mobile)
  var toggle = document.getElementById('sidebarToggle');
  var sidebar = document.getElementById('adminSidebar');
  if (toggle && sidebar) {
    toggle.addEventListener('click', function () {
      sidebar.classList.toggle('open');
    });
    document.addEventListener('click', function (e) {
      if (window.innerWidth < 992 && sidebar.classList.contains('open')
          && !sidebar.contains(e.target) && !toggle.contains(e.target)) {
        sidebar.classList.remove('open');
      }
    });
  }

  // Pengesahan padam (butang/link dengan class .confirm-delete)
  document.querySelectorAll('.confirm-delete').forEach(function (el) {
    el.addEventListener('click', function (e) {
      if (!confirm('Adakah anda pasti mahu memadam rekod ini? Tindakan ini tidak boleh diundur.')) {
        e.preventDefault();
      }
    });
  });

  // Auto-tutup mesej flash selepas 4 saat
  var alert = document.querySelector('.alert.auto-dismiss');
  if (alert) {
    setTimeout(function () {
      alert.classList.add('fade');
      setTimeout(function(){ alert.remove(); }, 500);
    }, 4000);
  }
});
