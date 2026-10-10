from pathlib import Path

MAIN = Path("main.py")

if not MAIN.exists():
    raise SystemExit(
        "ERROR: main.py tidak ditemukan. "
        "Pastikan Terminal berada di folder E-KESWA-PUSBONAT."
    )

text = MAIN.read_text(encoding="utf-8")

original = text


# ============================================================
# 1. FILTER TAHUN + BULAN
# ============================================================

old = '''def get_filters(request: Request):

    start = request.query_params.get(
        "mulai",
        ""
    )

    end = request.query_params.get(
        "sampai",
        ""
    )

    return start, end
'''

new = '''def get_filters(request: Request):

    start = request.query_params.get(
        "mulai",
        ""
    )

    end = request.query_params.get(
        "sampai",
        ""
    )

    tahun = request.query_params.get(
        "tahun",
        ""
    )

    bulan = request.query_params.get(
        "bulan",
        ""
    )

    # Jika tahun dipilih tetapi tanggal tidak diisi,
    # otomatis buat rentang tahun.
    if tahun and not start and not end:
        try:
            y = int(tahun)

            if bulan:
                m = int(bulan)

                if 1 <= m <= 12:
                    import calendar

                    last_day = calendar.monthrange(y, m)[1]

                    start = f"{y:04d}-{m:02d}-01"
                    end = f"{y:04d}-{m:02d}-{last_day:02d}"

            else:
                start = f"{y:04d}-01-01"
                end = f"{y:04d}-12-31"

        except Exception:
            pass

    return start, end, tahun, bulan
'''

if old not in text:
    raise SystemExit("ERROR: blok get_filters tidak ditemukan.")

text = text.replace(old, new, 1)


# ============================================================
# 2. SESUAIKAN SEMUA PEMANGGIL get_filters
# ============================================================

text = text.replace(
    'mulai, sampai = get_filters(request)',
    'mulai, sampai, tahun, bulan = get_filters(request)'
)


# ============================================================
# 3. TAMBAHKAN MENU EXPORT EXCEL DI SIDEBAR
# ============================================================

old = '''<a
href="/kesehatan-jiwa"
class="{'active' if active == 'keswa' else ''}"
>
<span class="nav-icon">🧠</span>
<span>Kesehatan Jiwa</span>
</a>

</nav>
'''

new = '''<a
href="/kesehatan-jiwa"
class="{'active' if active == 'keswa' else ''}"
>
<span class="nav-icon">🧠</span>
<span>Kesehatan Jiwa</span>
</a>

<a
href="/dashboard"
class="{'active' if active == 'export' else ''}"
onclick="event.preventDefault(); window.location.href='/dashboard#export-data';"
>
<span class="nav-icon">📥</span>
<span>Export Excel</span>
</a>

</nav>
'''

if old not in text:
    raise SystemExit("ERROR: menu sidebar tidak ditemukan.")

text = text.replace(old, new, 1)


# ============================================================
# 4. TAMBAHKAN FILTER TAHUN + BULAN PADA DASHBOARD
# ============================================================

old = '''<form class="filter" method="get" action="/dashboard">

<div class="field">
<label>Tanggal Mulai</label>
<input
type="date"
name="mulai"
value="{mulai}"
>
</div>

<div class="field">
<label>Tanggal Sampai</label>
<input
type="date"
name="sampai"
value="{sampai}"
>
</div>

<button class="btn btn-primary">
🔎 Filter
</button>

<a href="/dashboard" class="btn btn-light">
↻ Reset
</a>

</form>
'''

new = '''<form class="filter" method="get" action="/dashboard">

<div class="field">
<label>Tahun</label>
<select name="tahun">
<option value="">Semua Tahun</option>
<option value="2024" {"selected" if tahun == "2024" else ""}>2024</option>
<option value="2025" {"selected" if tahun == "2025" else ""}>2025</option>
<option value="2026" {"selected" if tahun == "2026" else ""}>2026</option>
<option value="2027" {"selected" if tahun == "2027" else ""}>2027</option>
<option value="2028" {"selected" if tahun == "2028" else ""}>2028</option>
<option value="2029" {"selected" if tahun == "2029" else ""}>2029</option>
<option value="2030" {"selected" if tahun == "2030" else ""}>2030</option>
</select>
</div>

<div class="field">
<label>Bulan</label>
<select name="bulan">
<option value="">Semua Bulan</option>
<option value="1" {"selected" if bulan == "1" else ""}>Januari</option>
<option value="2" {"selected" if bulan == "2" else ""}>Februari</option>
<option value="3" {"selected" if bulan == "3" else ""}>Maret</option>
<option value="4" {"selected" if bulan == "4" else ""}>April</option>
<option value="5" {"selected" if bulan == "5" else ""}>Mei</option>
<option value="6" {"selected" if bulan == "6" else ""}>Juni</option>
<option value="7" {"selected" if bulan == "7" else ""}>Juli</option>
<option value="8" {"selected" if bulan == "8" else ""}>Agustus</option>
<option value="9" {"selected" if bulan == "9" else ""}>September</option>
<option value="10" {"selected" if bulan == "10" else ""}>Oktober</option>
<option value="11" {"selected" if bulan == "11" else ""}>November</option>
<option value="12" {"selected" if bulan == "12" else ""}>Desember</option>
</select>
</div>

<div class="field">
<label>Tanggal Mulai</label>
<input
type="date"
name="mulai"
value="{mulai}"
>
</div>

<div class="field">
<label>Tanggal Sampai</label>
<input
type="date"
name="sampai"
value="{sampai}"
>
</div>

<button class="btn btn-primary" type="submit">
🔎 Filter
</button>

<a href="/dashboard" class="btn btn-light">
↻ Reset
</a>

<a
href="/export?tahun={tahun}&bulan={bulan}&mulai={mulai}&sampai={sampai}"
class="btn btn-excel"
>
📥 Export Excel
</a>

</form>
'''

if old not in text:
    raise SystemExit("ERROR: filter dashboard tidak ditemukan.")

text = text.replace(old, new, 1)


# ============================================================
# 5. TAMBAHKAN ID PADA ANGKA DASHBOARD
# ============================================================

replacements = {
    '<div class="metric">\n{angka(total)}\n</div>':
        '<div class="metric" id="dash_total">{angka(total)}</div>',

    '<div class="metric">\n{angka(spm_capaian)}\n</div>':
        '<div class="metric" id="dash_spm_capaian">{angka(spm_capaian)}</div>',

    '<div class="metric">\n{angka(f20)}\n</div>':
        '<div class="metric" id="dash_f20">{angka(f20)}</div>',

    '<div class="metric">\n{angka(f23)}\n</div>':
        '<div class="metric" id="dash_f23">{angka(f23)}</div>',

    '<div class="percent-big">\n{p(spm_persen)}\n</div>':
        '<div class="percent-big" id="dash_spm_persen">{p(spm_persen)}</div>',

    '<div class="percent-big">\n{p(pel_persen)}\n</div>':
        '<div class="percent-big" id="dash_pel_persen">{p(pel_persen)}</div>',

    '<div class="metric">\n{angka(baru)}\n</div>':
        '<div class="metric" id="dash_baru">{angka(baru)}</div>',

    '<div class="metric">\n{angka(p3lp_capaian)}\n</div>':
        '<div class="metric" id="dash_p3lp">{angka(p3lp_capaian)}</div>',

    '<div class="metric">\n{angka(skr_capaian)}\n</div>':
        '<div class="metric" id="dash_skrining">{angka(skr_capaian)}</div>',

    '<div class="percent-big">\n{p(skr_persen)}\n</div>':
        '<div class="percent-big" id="dash_skr_persen">{p(skr_persen)}</div>',

    '<div class="percent-big">\n{p(p3lp_persen)}\n</div>':
        '<div class="percent-big" id="dash_p3lp_persen">{p(p3lp_persen)}</div>',
}

for old, new in replacements.items():
    text = text.replace(old, new, 1)


# ============================================================
# 6. ID UNTUK PROGRESS BAR
# ============================================================

text = text.replace(
    '<div style="width:{max_spm}%"></div>',
    '<div id="dash_spm_progress" style="width:{max_spm}%"></div>',
    1
)

text = text.replace(
    '<div style="width:{max_pel}%"></div>',
    '<div id="dash_pel_progress" style="width:{max_pel}%"></div>',
    1
)

text = text.replace(
    '<div style="width:{max_skr}%"></div>',
    '<div id="dash_skr_progress" style="width:{max_skr}%"></div>',
    1
)

text = text.replace(
    '<div style="width:{max_p3lp}%"></div>',
    '<div id="dash_p3lp_progress" style="width:{max_p3lp}%"></div>',
    1
)


# ============================================================
# 7. REPLACE AUTO RELOAD DENGAN REALTIME API
# ============================================================

old = '''/* AUTO REFRESH DASHBOARD
   setiap 3 detik agar data terbaru
   muncul tanpa harus refresh manual.
*/

setTimeout(function(){

    const url =
        window.location.href;

    fetch(url,{
        headers:{
            "X-Requested-With":"XMLHttpRequest"
        }
    })
    .then(function(response){

        if(response.ok){

            window.location.reload();

        }

    })
    .catch(function(){});

},3000);
'''

new = '''/* =========================================================
   REALTIME DASHBOARD
   ========================================================= */

let lastDashboardUpdate = "";

function formatAngka(value){
    try{
        return Number(value || 0)
            .toLocaleString("id-ID");
    }catch(e){
        return "0";
    }
}

function formatPersen(value){
    try{
        return Number(value || 0).toFixed(2) + "%";
    }catch(e){
        return "0.00%";
    }
}

function setText(id, value){
    const el = document.getElementById(id);

    if(el){
        el.textContent = value;
    }
}

function setProgress(id, value){
    const el = document.getElementById(id);

    if(el){
        const n = Math.min(
            Math.max(Number(value || 0), 0),
            100
        );

        el.style.width = n + "%";
    }
}

function updateDashboardRealtime(){

    fetch("/api/dashboard" + window.location.search,{
        cache:"no-store",
        headers:{
            "X-Requested-With":"XMLHttpRequest",
            "Cache-Control":"no-cache"
        }
    })
    .then(function(response){

        if(!response.ok){
            throw new Error("API dashboard gagal");
        }

        return response.json();

    })
    .then(function(result){

        if(!result.login || !result.data){
            return;
        }

        const d = result.data;

        setText(
            "dash_total",
            formatAngka(d.total_odgj_berat)
        );

        setText(
            "dash_spm_capaian",
            formatAngka(d.spm_capaian)
        );

        setText(
            "dash_f20",
            formatAngka(d.f20)
        );

        setText(
            "dash_f23",
            formatAngka(d.f23)
        );

        setText(
            "dash_spm_persen",
            formatPersen(d.spm_persentase)
        );

        setText(
            "dash_pel_persen",
            formatPersen(d.pelacakan_persentase)
        );

        setText(
            "dash_baru",
            formatAngka(d.odgjb_baru)
        );

        setText(
            "dash_p3lp",
            formatAngka(d.p3lp_capaian)
        );

        setText(
            "dash_skrining",
            formatAngka(d.skrining_capaian)
        );

        setText(
            "dash_skr_persen",
            formatPersen(d.skrining_persentase)
        );

        setText(
            "dash_p3lp_persen",
            formatPersen(d.p3lp_persentase)
        );

        setProgress(
            "dash_spm_progress",
            d.spm_persentase
        );

        setProgress(
            "dash_pel_progress",
            d.pelacakan_persentase
        );

        setProgress(
            "dash_skr_progress",
            d.skrining_persentase
        );

        setProgress(
            "dash_p3lp_progress",
            d.p3lp_persentase
        );


        /* UPDATE GRAFIK DESA */

        if(window.desaChart){

            window.desaChart.data.datasets[0].data = [
                Number(d.manusak || 0),
                Number(d.oelatimo || 0),
                Number(d.pukdale || 0),
                Number(d.nunkurus || 0),
                Number(d.naibonat || 0)
            ];

            window.desaChart.update("none");
        }


        /* UPDATE GRAFIK OBAT */

        if(window.obatChart){

            window.obatChart.data.datasets[0].data = [
                Number(d.obat_rutin || 0),
                Number(d.obat_tidak_rutin || 0),
                Number(d.obat_putus || 0)
            ];

            window.obatChart.update("none");
        }


        /* Penanda bahwa data terbaru berhasil diterima */

        if(d.diperbarui_pada){
            lastDashboardUpdate = d.diperbarui_pada;
        }

    })
    .catch(function(error){
        console.log("Realtime dashboard:", error);
    });
}


/*
   Jalankan pertama kali segera.
*/
updateDashboardRealtime();


/*
   Cek database setiap 2 detik.
   Tidak melakukan reload halaman.
*/
setInterval(
    updateDashboardRealtime,
    2000
);
'''

if old not in text:
    raise SystemExit(
        "ERROR: kode auto-refresh lama tidak ditemukan."
    )

text = text.replace(old, new, 1)


# ============================================================
# 8. BUAT CHART MENJADI GLOBAL AGAR BISA DIUPDATE REALTIME
# ============================================================

text = text.replace(
    '''new Chart(
document.getElementById("desaChart"),''',
    '''window.desaChart = new Chart(
document.getElementById("desaChart"),''',
    1
)

text = text.replace(
    '''new Chart(
document.getElementById("obatChart"),''',
    '''window.obatChart = new Chart(
document.getElementById("obatChart"),''',
    1
)


# ============================================================
# 9. PERBAIKI PERSENTASE INPUT
# ============================================================

old = '''function hitungPersen(prefix){{
    
    let sasaran;
    let capaian;
    
    if(prefix==="spm"){{
        sasaran =
            Number(
                document.getElementById(
                    "spm_sasaran"
                ).value
            );
        
        capaian =
            Number(
                document.getElementById(
                    "spm_capaian"
                ).value
            );
    }}
    
    if(prefix==="pel"){{
        sasaran =
            Number(
                document.getElementById(
                    "pel_sasaran"
                ).value
            );
        
        capaian =
            Number(
                document.getElementById(
                    "pel_capaian"
                ).value
            );
    }}
    
    if(prefix==="p3lp"){{
        sasaran =
            Number(
                document.getElementById(
                    "p3lp_sasaran"
                ).value
            );
        
        capaian =
            Number(
                document.getElementById(
                    "p3lp_capaian"
                ).value
            );
    }}
    
    if(prefix==="skr"){{
        sasaran =
            Number(
                document.getElementById(
                    "skr_sasaran"
                ).value
            );
        
        capaian =
            Number(
                document.getElementById(
                    "skr_capaian"
                ).value
            );
    }}
    
    let hasil = 0;
    
    if(sasaran > 0){{
        hasil =
            (capaian / sasaran) * 100;
    }}
    
    document.getElementById(
        prefix + "_hasil"
    ).innerText =
        hasil.toFixed(2) + "%";
}}


hitungPersen("spm");
hitungPersen("pel");
hitungPersen("p3lp");
hitungPersen("skr");
'''

new = '''function hitungPersen(prefix){{

    const map = {{
        spm: ["spm_sasaran", "spm_capaian"],
        pel: ["pel_sasaran", "pel_capaian"],
        p3lp: ["p3lp_sasaran", "p3lp_capaian"],
        skr: ["skr_sasaran", "skr_capaian"]
    }};

    if(!map[prefix]){{
        return;
    }}

    const sasaranEl =
        document.getElementById(map[prefix][0]);

    const capaianEl =
        document.getElementById(map[prefix][1]);

    const hasilEl =
        document.getElementById(prefix + "_hasil");

    if(!sasaranEl || !capaianEl || !hasilEl){{
        return;
    }}

    const sasaran =
        Number(sasaranEl.value || 0);

    const capaian =
        Number(capaianEl.value || 0);

    let hasil = 0;

    if(sasaran > 0){{
        hasil =
            (capaian / sasaran) * 100;
    }}

    hasilEl.textContent =
        hasil.toFixed(2) + "%";
}}


/*
   Hitung langsung ketika:
   - mengetik
   - selesai mengisi
   - pindah field
   - menekan Enter
*/

[
    "spm",
    "pel",
    "p3lp",
    "skr"
].forEach(function(prefix){{

    const map = {{
        spm: ["spm_sasaran", "spm_capaian"],
        pel: ["pel_sasaran", "pel_capaian"],
        p3lp: ["p3lp_sasaran", "p3lp_capaian"],
        skr: ["skr_sasaran", "skr_capaian"]
    }};

    map[prefix].forEach(function(id){{

        const input =
            document.getElementById(id);

        if(!input){{
            return;
        }}

        ["input","change","blur"].forEach(function(eventName){{

            input.addEventListener(
                eventName,
                function(){{
                    hitungPersen(prefix);
                }}
            );

        }});

        input.addEventListener(
            "keydown",
            function(event){{

                if(event.key === "Enter"){{
                    hitungPersen(prefix);
                }}

            }}
        );

    }});

    hitungPersen(prefix);

}});
'''

if old not in text:
    raise SystemExit(
        "ERROR: fungsi hitungPersen lama tidak ditemukan."
    )

text = text.replace(old, new, 1)


# ============================================================
# 10. VALIDASI AGAR PERSENTASE FORM EDIT LANGSUNG MUNCUL
# ============================================================

# Pastikan atribut onchange/blur juga tersedia pada input.
text = text.replace(
    'oninput="hitungPersen(\\'spm\\')"',
    'oninput="hitungPersen(\\'spm\\')" onchange="hitungPersen(\\'spm\\')" onblur="hitungPersen(\\'spm\\')"',
)

text = text.replace(
    'oninput="hitungPersen(\\'pel\\')"',
    'oninput="hitungPersen(\\'pel\\')" onchange="hitungPersen(\\'pel\\')" onblur="hitungPersen(\\'pel\\')"',
)

text = text.replace(
    'oninput="hitungPersen(\\'p3lp\\')"',
    'oninput="hitungPersen(\\'p3lp\\')" onchange="hitungPersen(\\'p3lp\\')" onblur="hitungPersen(\\'p3lp\\')"',
)

text = text.replace(
    'oninput="hitungPersen(\\'skr\\')"',
    'oninput="hitungPersen(\\'skr\\')" onchange="hitungPersen(\\'skr\\')" onblur="hitungPersen(\\'skr\\')"',
)


# ============================================================
# 11. EXPORT: PASTIKAN FILTER TAHUN/BULAN TETAP DITERIMA
# ============================================================

# Tidak perlu mengubah endpoint export.
# get_filters() sekarang otomatis menerjemahkan tahun/bulan
# menjadi tanggal mulai dan tanggal akhir.


# ============================================================
# SIMPAN
# ============================================================

if text == original:
    raise SystemExit(
        "ERROR: Tidak ada perubahan dilakukan. "
        "Struktur main.py mungkin berbeda."
    )

# Backup otomatis sebelum perubahan.
backup = Path("main.py.backup_sebelum_realtime")

if not backup.exists():
    backup.write_text(
        original,
        encoding="utf-8"
    )

MAIN.write_text(
    text,
    encoding="utf-8"
)

print()
print("============================================================")
print(" E-KESWA PUSBONAT - PERBAIKAN BERHASIL")
print("============================================================")
print()
print("✓ Export Excel + filter tahun/bulan/tanggal")
print("✓ Tombol Export Excel tersedia di Dashboard")
print("✓ Persentase otomatis saat input/change/blur/Enter")
print("✓ Dashboard realtime menggunakan API")
print("✓ Grafik desa realtime")
print("✓ Grafik obat realtime")
print("✓ Backup dibuat:")
print("  main.py.backup_sebelum_realtime")
print()
