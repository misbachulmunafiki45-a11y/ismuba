// JS diambil dari test app.html (navigasi, jam, pengingat sholat)

function showSection(sectionId, el) {
  document.querySelectorAll('.section').forEach(section => section.classList.add('hidden'));
  const targetSection = document.getElementById(sectionId);
  if (targetSection) targetSection.classList.remove('hidden');

  // Set active pada item navigasi (desktop & bottom)
  document.querySelectorAll('.nav-item, .desktop-nav-item').forEach(item => item.classList.remove('active'));
  if (el) {
    const navItem = el.closest('.nav-item, .desktop-nav-item');
    if (navItem) navItem.classList.add('active');
  }
}

function updateTime() {
  const now = new Date();
  const hours = String(now.getHours()).padStart(2, '0');
  const minutes = String(now.getMinutes()).padStart(2, '0');
  const seconds = String(now.getSeconds()).padStart(2, '0');
  const timeString = `${hours}:${minutes}:${seconds}`;
  const el = document.getElementById('currentTime');
  if (el) el.textContent = timeString;
}

function checkPrayerTime() {
  const times = {
    fajr: '04:45',
    dhuhr: '12:00',
    asr: '15:30',
    maghrib: '18:00',
    isha: '19:30'
  };
  const now = new Date();
  const current = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;
  Object.entries(times).forEach(([name, time]) => {
    if (current === time) showNotification(`Waktu ${name} telah masuk.`);
  });
}

function showNotification(message) {
  const notification = document.createElement('div');
  notification.className = 'notification';
  notification.textContent = message;
  document.body.appendChild(notification);
  setTimeout(() => notification.remove(), 5000);
}

document.addEventListener('DOMContentLoaded', () => {
  showSection('home');
  updateTime();
  setInterval(updateTime, 1000);
  setInterval(checkPrayerTime, 60000);
});