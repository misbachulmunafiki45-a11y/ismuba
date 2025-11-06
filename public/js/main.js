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
  } else {
    document.querySelectorAll(
      `.nav-item[data-section="${sectionId}"], .desktop-nav-item[data-section="${sectionId}"]`
    ).forEach(item => item.classList.add('active'));
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

  // UI clock flip now handled by startTime(); keep text update for compatibility
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
  function getInitialSectionFromPath() {
    const path = (window.location.pathname || '/').replace(/\/+$/, '');
    const seg = path.split('/')[1] || '';
    const allowed = ['wudhu','sholat','doa','kaifiyah','materi','foto'];
    if (allowed.includes(seg)) return seg;
    return 'home';
  }

  const initialSection = getInitialSectionFromPath();
  showSection(initialSection);
  updateTime();
  setInterval(updateTime, 1000);
  checkPrayerTime();
  setInterval(checkPrayerTime, CHECK_INTERVAL_MS);


  // Analog clock handled by window.onload per latest specification

  // Radio button audio player dinonaktifkan untuk mencegah error audio eksternal

  // Kaifiyah: tile expandable - tampilkan konten di dalam tile yang diklik
  const tiles = Array.from(document.querySelectorAll('.kaifiyah-tile'));
  if (tiles.length) {
    function closeAllTiles() {
      tiles.forEach(t => {
        const section = t.getAttribute('data-section');
        const content = document.getElementById('kaifiyah-content-' + section);
        const btn = t.querySelector('.kaifiyah-menu-item');
        if (content) content.setAttribute('hidden', 'hidden');
        if (btn) btn.classList.remove('active');
      });
  }

  // Materi: tile expandable per subject
  const materiTiles = Array.from(document.querySelectorAll('.materi-tile'));
  if (materiTiles.length) {
    function closeAllMateriTiles() {
      materiTiles.forEach(t => {
        const section = t.getAttribute('data-section');
        const content = document.getElementById('materi-content-' + section);
        const btn = t.querySelector('.materi-menu-item');
        if (content) content.setAttribute('hidden', 'hidden');
        if (btn) btn.classList.remove('active');
      });
    }

    function openMateriTile(section) {
      const tile = document.querySelector('.materi-tile[data-section="' + section + '"]');
      if (!tile) return;
      const content = document.getElementById('materi-content-' + section);
      const btn = tile.querySelector('.materi-menu-item');
      closeAllMateriTiles();
      if (content) content.removeAttribute('hidden');
      if (btn) btn.classList.add('active');
      tile.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    materiTiles.forEach(t => {
      const section = t.getAttribute('data-section');
      const content = document.getElementById('materi-content-' + section);
      const btn = t.querySelector('.materi-menu-item');
      if (!btn) return;
      btn.addEventListener('click', (e) => {
        // Jika href tetap di /materi dengan hash, biarkan default berjalan,
        // tapi juga buka tile agar UX terasa responsif.
        const isOpen = content && !content.hasAttribute('hidden');
        closeAllMateriTiles();
        if (!isOpen && content) {
          content.removeAttribute('hidden');
          btn.classList.add('active');
          t.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });

    const initialHashMateri = window.location.hash;
    if (initialHashMateri && initialHashMateri.startsWith('#materi-')) {
      const targetSection = initialHashMateri.replace('#materi-', '');
      openMateriTile(targetSection);
    }
  }
    function openTile(section) {
      const tile = document.querySelector('.kaifiyah-tile[data-section="' + section + '"]');
      if (!tile) return;
      const content = document.getElementById('kaifiyah-content-' + section);
      const btn = tile.querySelector('.kaifiyah-menu-item');
      closeAllTiles();
      if (content) {
        content.removeAttribute('hidden');
      }
      if (btn) {
        btn.classList.add('active');
      }
      tile.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    tiles.forEach(t => {
      const section = t.getAttribute('data-section');
      const content = document.getElementById('kaifiyah-content-' + section);
      const btn = t.querySelector('.kaifiyah-menu-item');
      if (!btn) return;
      btn.addEventListener('click', () => {
        const isOpen = content && !content.hasAttribute('hidden');
        closeAllTiles();
        if (!isOpen && content) {
          content.removeAttribute('hidden');
          btn.classList.add('active');
          t.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });

    // Buka tile berdasarkan hash jika tersedia
    const initialHash = window.location.hash;
    if (initialHash && initialHash.startsWith('#kaifiyah-')) {
      const targetSection = initialHash.replace('#kaifiyah-', '');
      openTile(targetSection);
    }
  }

  // Animasi sentuh/klik untuk kontainer gambar di halaman Materi (Kelas)
  const imageCards = Array.from(document.querySelectorAll('.image-flexbox-card'));
  if (imageCards.length) {
    imageCards.forEach(card => {
      // Pointer events: unify mouse/touch
      const addTouch = () => card.classList.add('is-touched');
      const removeTouch = () => card.classList.remove('is-touched');

      // Pointer (mouse) interactions
      card.addEventListener('pointerdown', addTouch);
      card.addEventListener('pointerup', removeTouch);
      card.addEventListener('pointerleave', removeTouch);

      // Touch-specific: brief pulse on tap
      card.addEventListener('touchstart', () => {
        card.classList.add('is-touched');
        setTimeout(() => card.classList.remove('is-touched'), 220);
      }, { passive: true });
    });
  }
});

// Bagian jam (flip/analog) dihapus sesuai permintaan