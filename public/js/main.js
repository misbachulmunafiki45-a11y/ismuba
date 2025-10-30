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

const HIGHLIGHT_MINUTES = 10; // durasi highlight setelah waktu masuk
const CHECK_INTERVAL_MS = 10000; // interval cek agar responsif

let lastActiveTime = null;
function parseTimeToToday(timeStr) {
  const [h, m] = timeStr.split(':').map(Number);
  const d = new Date();
  d.setHours(h, m, 0, 0);
  return d;
}

function isWithinHighlight(now, target, minutes) {
  const diff = now.getTime() - target.getTime();
  return diff >= 0 && diff <= minutes * 60 * 1000;
}

function checkPrayerTime() {
  const cards = document.querySelectorAll('#home .prayer-grid .prayer-card');
  const now = new Date();
  cards.forEach(card => {
    const time = card.getAttribute('data-time');
    if (!time) {
      card.classList.remove('active');
      return;
    }
    const target = parseTimeToToday(time);
    if (isWithinHighlight(now, target, HIGHLIGHT_MINUTES)) {
      card.classList.add('active');
      if (lastActiveTime !== time) {
        const name = (card.querySelector('.prayer-name')?.textContent || 'Sholat').trim();
        showNotification(`Waktu ${name} telah masuk.`);
        lastActiveTime = time;
      }
    } else {
      card.classList.remove('active');
    }
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
  checkPrayerTime();
  setInterval(checkPrayerTime, CHECK_INTERVAL_MS);
});