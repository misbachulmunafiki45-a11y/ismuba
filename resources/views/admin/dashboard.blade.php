@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')


<div class="row mt-3">
    <!-- Kalender -->
    <div class="col-md-12">
        <div class="card" style="border:none; box-shadow: 0 6px 24px rgba(0,0,0,0.05);">
            <div class="card-header" style="background:#2cc5a7; color:#fff; display:flex; align-items:center; justify-content:center; gap:18px;">
                <button id="calPrev" class="btn btn-sm" style="color:#fff; background:transparent; border:none; font-size:20px;">&lt;</button>
                <h5 id="calTitle" class="m-0" style="letter-spacing:1px;">Kalender</h5>
                <button id="calNext" class="btn btn-sm" style="color:#fff; background:transparent; border:none; font-size:20px;">&gt;</button>
            </div>
            <div class="card-body" style="padding: 12px 16px;">
                <div id="adminCalendar" style="display:grid; grid-template-columns: repeat(7, 1fr); gap:10px;"></div>
                <div id="adminCalendarLegend" style="margin-top:10px; display:flex; gap:12px; align-items:center;">
                    <span style="display:inline-flex; align-items:center; gap:6px;"><span style="width:10px; height:10px; border-radius:50%; background:#2ecc71;"></span> Ada Jadwal</span>
                    <span style="display:inline-flex; align-items:center; gap:6px;"><span style="width:10px; height:10px; border-radius:50%; background:transparent; border:2px solid #3498db;"></span> Hari Ini</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Tata Cara Berwudhu -->
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header">Total Input Tata Cara Berwudhu</div>
            <div class="card-body" style="height:280px">
                <canvas id="chartWudhuReading"></canvas>
            </div>
        </div>
    </div>
    <!-- Tata Cara Sholat -->
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header">Total Input Tata Cara Sholat</div>
            <div class="card-body" style="height:280px">
                <canvas id="chartPrayerReading"></canvas>
            </div>
        </div>
    </div>
    <!-- Kaifiyah -->
    <div class="col-md-6 col-lg-4">
        <div class="card" style="background-color: transparent;">
            <div class="card-header" style="background-color: transparent;">Total Input Kaifiyah Jenazah</div>
            <div class="card-body" style="height:280px; background-color: transparent;">
                <canvas id="chartKaifiyah"></canvas>
            </div>
        </div>
    </div>
    <!-- Bacaan Doa Harian -->
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header">Total Input Bacaan Doa Harian</div>
            <div class="card-body" style="height:280px">
                <canvas id="chartDailyPrayer"></canvas>
            </div>
        </div>
    </div>
    <!-- Materi -->
    <div class="col-md-6 col-lg-4">
        <div class="card" style="background-color: transparent;">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: transparent;">
                <span>Total Input Materi</span>
                <select id="materialGroupBy" class="form-control form-control-sm" style="width:auto; background: transparent;">
                    <option value="subject">Mata Pelajaran</option>
                    <option value="semester">Semester</option>
                    <option value="class">Kelas</option>
                </select>
            </div>
            <div class="card-body" style="height:280px; background-color: transparent;">
                <canvas id="chartMaterial"></canvas>
            </div>
        </div>
    </div>
    <!-- Foto Kegiatan -->
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-header">Total Input Foto Kegiatan</div>
            <div class="card-body" style="height:280px">
                <canvas id="chartActivityPhoto"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script>
    const months = @json($months ?? []);
    // Register plugins
    Chart.register(ChartDataLabels);

    // Center text plugin for doughnut charts
    const centerTextPlugin = {
        id: 'centerTextPlugin',
        afterDraw(chart, args, options) {
            const {ctx, chartArea: {width, height}} = chart;
            if (!options || !options.text) return;
            ctx.save();
            ctx.font = options.font || '600 14px Arial';
            ctx.fillStyle = options.color || '#666';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(options.text, chart.getDatasetMeta(0).data[0].x, chart.getDatasetMeta(0).data[0].y);
            ctx.restore();
        }
    };
    Chart.register(centerTextPlugin);
    const totalCounts = {
        prayerSchedules: @json($countPrayerSchedules ?? 0),
        wudhuReadings: @json($countWudhuReadings ?? 0),
        prayerReadings: @json($countPrayerReadings ?? 0),
        kaifiyahItems: @json($countKaifiyahItems ?? 0),
        dailyPrayers: @json($countDailyPrayers ?? 0),
        materials: @json($countMaterials ?? 0),
        activityPhotos: @json($countActivityPhotos ?? 0),
    };
    const datasets = {
        prayerSchedules: @json($prayerSchedules ?? []),
        wudhuReadings: @json($wudhuReadings ?? []),
        prayerReadings: @json($prayerReadings ?? []),
        kaifiyahItems: @json($kaifiyahItems ?? []),
        dailyPrayers: @json($dailyPrayers ?? []),
        materials: @json($materials ?? []),
        activityPhotos: @json($activityPhotos ?? []),
    };
    const materialGroup = {
        subject: @json($materialBySubject ?? ['labels'=>[], 'data'=>[]]),
        semester: @json($materialBySemester ?? ['labels'=>[], 'data'=>[]]),
        class: @json($materialByClassLevel ?? ['labels'=>[], 'data'=>[]]),
    };
    const kaifiyahGroup = @json($kaifiyahBySectionFixed ?? ['labels'=>[], 'data'=>[]]);
    const calendarEvents = @json($calendarEvents ?? []);

    const baseOptions = {
        type: 'bar',
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, grid: { color: '#eee' } }
            }
        }
    };

    function renderBarChart(elId, label, data, color) {
        const ctx = document.getElementById(elId);
        if (!ctx) return;
        new Chart(ctx, {
            ...baseOptions,
            data: {
                labels: months,
                datasets: [{
                    label,
                    data,
                    backgroundColor: color,
                    borderColor: color,
                    borderWidth: 1,
                }]
            }
        });
    }

    // Palette for 12 months (neon-like)
    const COLORS_12 = ['#8e54e9','#00c2ff','#f9c74f','#ff4d6d','#00d4a3','#7a89ff','#f28482','#b388eb','#4dd4b6','#ffd166','#ef476f','#06d6a0'];

    function renderDonutChart(elId, label, data) {
        const ctx = document.getElementById(elId);
        if (!ctx) return;
        const sum = (data || []).reduce((a,b)=>a+(b||0),0);
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: months,
                datasets: [{
                    label,
                    data,
                    backgroundColor: COLORS_12,
                    borderColor: '#111',
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: { position: 'right' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw || 0;
                                const pct = sum ? Math.round(value/sum*100) : 0;
                                return `${context.label}: ${value} (${pct}%)`;
                            }
                        }
                    },
                    datalabels: {
                        color: '#fff',
                        formatter: (value, ctx) => {
                            const total = sum || 1;
                            const pct = Math.round((value/total)*100);
                            return pct > 0 ? pct + '%' : '';
                        }
                    },
                    centerTextPlugin: { text: sum ? `${sum} total` : 'Tidak ada data', color:'#777' }
                }
            }
        });
    }

    function renderSingleDonut(elId, label, count, color) {
        const ctx = document.getElementById(elId);
        if (!ctx) return;
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [label],
                datasets: [{
                    data: [count],
                    backgroundColor: [color + 'cc'],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: { display: false },
                    datalabels: {
                        color: '#fff',
                        formatter: (value) => value
                    },
                    tooltip: { callbacks: { label: (ctx) => `${label}: ${ctx.raw}` } },
                    centerTextPlugin: { text: `${count} total`, color:'#777' }
                }
            }
        });
    }

    function renderMaterialDonut(groupKey) {
        const ctx = document.getElementById('chartMaterial');
        if (!ctx) return;
        const dataset = materialGroup[groupKey] || {labels: [], data: []};
        const sum = (dataset.data||[]).reduce((a,b)=>a+(b||0),0);
        // destroy previous instance if any
        if (ctx._chartInstance) { ctx._chartInstance.destroy(); }
        const chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: dataset.labels,
                datasets: [{
                    data: dataset.data,
                    backgroundColor: dataset.data.map((_,i)=> COLORS_12[i % COLORS_12.length] + 'cc'),
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: { position: 'right', labels: { color: '#555' } },
                    datalabels: {
                        color: '#fff',
                        formatter: (value) => {
                            const pct = sum ? Math.round((value/sum)*100) : 0;
                            return pct > 0 ? pct + '%' : '';
                        }
                    },
                    centerTextPlugin: { text: sum ? `${sum} total` : 'Tidak ada data', color:'#777' }
                }
            }
        });
        ctx._chartInstance = chart;
    }

    function renderPieChart(elId, dataset) {
        const ctx = document.getElementById(elId);
        if (!ctx) return;
        const labels = (dataset.labels || []);
        const data = (dataset.data || []);
        const total = data.reduce((a,b)=>a+(b||0),0);
        if (ctx._chartInstance) { ctx._chartInstance.destroy(); }
        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels,
                datasets: [{
                    data,
                    backgroundColor: data.map((_,i)=> COLORS_12[i % COLORS_12.length] + 'cc'),
                    borderColor: '#ffffff55',
                    borderWidth: 4,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right', labels: { color: '#555' } },
                    datalabels: {
                        color: '#fff',
                        font: { size: 14, weight: '700' },
                        formatter: (value, ctx) => {
                            const pct = total ? Math.round((value/total)*100) : 0;
                            const label = labels[ctx.dataIndex] || '';
                            return pct > 0 ? pct + '%\n' + label : '';
                        },
                        align: 'center',
                        anchor: 'center',
                        clamp: true,
                        clip: true,
                    }
                }
            }
        });
        ctx._chartInstance = chart;
    }

    // Kalender
    (function(){
        const monthsId = ['JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'];
        const calendarEl = document.getElementById('adminCalendar');
        const titleEl = document.getElementById('calTitle');
        const prevBtn = document.getElementById('calPrev');
        const nextBtn = document.getElementById('calNext');
        let viewDate = new Date();

        function getEventsForMonth(year, month){
            // calendarEvents: { 'YYYY-MM-DD': count }
            const map = {};
            Object.keys(calendarEvents||{}).forEach(d=>{
                const dt = new Date(d+'T00:00:00');
                if (dt.getFullYear()===year && dt.getMonth()===month){
                    map[dt.getDate()] = calendarEvents[d];
                }
            });
            return map;
        }

        function render(){
            if (!calendarEl) return;
            const y = viewDate.getFullYear();
            const m = viewDate.getMonth();
            titleEl && (titleEl.textContent = monthsId[m] + ' ' + y);
            calendarEl.innerHTML = '';
            // header weekday
            const weekdays = ['M','S','S','R','K','J','S']; // Senin awal pekan
            const header = document.createElement('div');
            header.style.display='contents';
            weekdays.forEach(w=>{
                const el = document.createElement('div');
                el.textContent = w;
                el.style.color = '#999';
                el.style.textAlign = 'center';
                el.style.fontWeight = '700';
                el.style.fontSize = '16px';
                calendarEl.appendChild(el);
            });
            const first = new Date(y, m, 1);
            const startIdx = (first.getDay()+6)%7; // make Monday=0
            const daysInMonth = new Date(y, m+1, 0).getDate();
            const events = getEventsForMonth(y, m);
            // blanks before first day
            for (let i=0;i<startIdx;i++){
                const blank = document.createElement('div');
                calendarEl.appendChild(blank);
            }
            for (let d=1; d<=daysInMonth; d++){
                const cell = document.createElement('div');
                cell.style.textAlign = 'center';
                cell.style.padding='8px 0';
                cell.style.position='relative';
                cell.style.minHeight='40px';
                const badge = document.createElement('div');
                const count = events[d]||0;
                const now = new Date();
                const isToday = (now.getFullYear()===y && now.getMonth()===m && now.getDate()===d);
                if (count>0){
                    badge.textContent = d;
                    badge.style.margin='0 auto';
                    badge.style.width='36px';
                    badge.style.height='36px';
                    badge.style.lineHeight='36px';
                    badge.style.borderRadius='50%';
                    badge.style.color='#fff';
                    badge.style.fontWeight='600';
                    badge.style.boxShadow='0 4px 10px rgba(0,0,0,0.12)';
                    badge.style.background = '#2ecc71';
                    if (isToday) { badge.style.border = '3px solid #3498db'; }
                    cell.appendChild(badge);
                } else {
                    const txt = document.createElement('span');
                    txt.textContent = d;
                    txt.style.color='#555';
                    cell.appendChild(txt);
                }
                calendarEl.appendChild(cell);
            }
        }
        prevBtn && prevBtn.addEventListener('click', ()=>{ viewDate.setMonth(viewDate.getMonth()-1); render(); });
        nextBtn && nextBtn.addEventListener('click', ()=>{ viewDate.setMonth(viewDate.getMonth()+1); render(); });
        render();
    })();

    renderSingleDonut('chartWudhuReading', 'Total Berwudhu', totalCounts.wudhuReadings, '#00c2ff');
    renderSingleDonut('chartPrayerReading', 'Total Tata Cara Sholat', totalCounts.prayerReadings, '#ff4d6d');
    // Kaifiyah: tampilkan pie 4 segmen per section
    renderPieChart('chartKaifiyah', kaifiyahGroup);
    renderSingleDonut('chartDailyPrayer', 'Total Bacaan', totalCounts.dailyPrayers, '#f9c74f');
    // init material donut with subject group
    renderMaterialDonut('subject');
    const materialSelector = document.getElementById('materialGroupBy');
    materialSelector && materialSelector.addEventListener('change', (e)=>{
        renderMaterialDonut(e.target.value);
    });
    renderSingleDonut('chartActivityPhoto', 'Total Foto', totalCounts.activityPhotos, '#f28482');
</script>
@endpush