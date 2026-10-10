from fastapi import FastAPI, Request, Form
from fastapi.responses import HTMLResponse, RedirectResponse, StreamingResponse
from starlette.middleware.sessions import SessionMiddleware
from openpyxl import Workbook
from openpyxl.styles import Font, Alignment
from io import BytesIO
from datetime import date
from pathlib import Path
from database import init_database, simpan_data, update_data, ambil_data, semua_data, data_terbaru, hapus_data

app = FastAPI(title="E-KESWA PUSBONAT")
app.add_middleware(SessionMiddleware, secret_key="E-KESWA-PUSBONAT-SECRET-2026")
init_database()

USERNAME = "eky"
PASSWORD = "ekynbt26"

FIELDS = [
    ("tanggal","Tanggal"),("total_odgj_berat","Total ODGJ Berat"),
    ("spm_sasaran","SPM Sasaran"),("spm_capaian","SPM Capaian"),("spm_persentase","SPM Persentase"),
    ("f23","Diagnosis F23"),("f20","Diagnosis F20"),
    ("manusak","Manusak"),("oelatimo","Oelatimo"),("pukdale","Pukdale"),("nunkurus","Nunkurus"),("naibonat","Kelurahan Naibonat"),
    ("obat_sasaran","Obat Sasaran"),("obat_rutin","Obat Rutin"),("obat_tidak_rutin","Obat Tidak Rutin"),("obat_putus","Obat Putus"),
    ("odgjb_baru","ODGJB Baru"),
    ("pelacakan_sasaran","Pelacakan Sasaran"),("pelacakan_capaian","Pelacakan Capaian"),("pelacakan_persentase","Pelacakan Persentase"),
    ("p3lp_sasaran","P3LP Sasaran"),("p3lp_capaian","P3LP Capaian"),("p3lp_persentase","P3LP Persentase"),
    ("skrining_sasaran","Skrining Sasaran"),("skrining_capaian","Skrining Capaian"),("skrining_persentase","Skrining Persentase"),
    ("kendala","Kendala"),("solusi","Solusi"),("rencana_tindak_lanjut","Rencana Tindak Lanjut")
]

NUMERIC = [x[0] for x in FIELDS if x[0] not in ("tanggal","kendala","solusi","rencana_tindak_lanjut","spm_persentase","pelacakan_persentase","p3lp_persentase","skrining_persentase")]

def auth(request):
    return bool(request.session.get("login"))

def page(title, body, request):
    if not auth(request) and title not in ("Login",):
        return RedirectResponse("/login", status_code=303)
    nav = """
    <aside>
      <div class="brand"><div class="heart">♥</div><div><b>E-KESWA</b><small>PUSBONAT</small></div></div>
      <nav>
        <a href="/dashboard">⌂ <span>Dashboard</span></a>
        <a href="/kesehatan-jiwa">♡ <span>Kesehatan Jiwa</span></a>
        <a href="/export">⇩ <span>Export Excel</span></a>
        <a href="/logout">↪ <span>Keluar</span></a>
      </nav>
    </aside>
    """
    return HTMLResponse(f"""<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{title} — E-KESWA PUSBONAT</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    *{{box-sizing:border-box}}body{{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;background:linear-gradient(135deg,#eafff9,#f6fbff);color:#143b3b}}
    aside{{position:fixed;left:0;top:0;bottom:0;width:250px;background:linear-gradient(180deg,#008f83,#006d67);color:white;padding:24px 16px;box-shadow:8px 0 30px #006d6730;z-index:5}}
    .brand{{display:flex;gap:12px;align-items:center;padding:8px 10px 28px}}.brand b{{font-size:20px;letter-spacing:1px;display:block}}.brand small{{opacity:.8}}
    .heart{{font-size:34px;text-shadow:0 0 15px #b8fff5;animation:pulse 1.2s infinite}}@keyframes pulse{{50%{{transform:scale(1.15);text-shadow:0 0 25px #fff}}}}
    nav a{{display:block;color:white;text-decoration:none;padding:14px;border-radius:14px;margin:7px 0;background:#ffffff0d}}nav a:hover{{background:#ffffff20;transform:translateX(3px)}}
    main{{margin-left:250px;padding:28px;min-height:100vh}}h1{{margin:0 0 6px;font-size:30px}}h2{{margin-top:0}}.muted{{color:#6b8785}}
    .grid{{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:16px;margin:22px 0}}.card,.panel{{background:#ffffffc9;border:1px solid #ffffff;box-shadow:0 10px 35px #006d6712;border-radius:20px;padding:20px;backdrop-filter:blur(14px)}}
    .card .label{{font-size:13px;color:#65817f}}.card .value{{font-size:30px;font-weight:800;margin-top:8px}}.bar{{height:9px;background:#dcefed;border-radius:9px;overflow:hidden;margin-top:12px}}.fill{{height:100%;background:linear-gradient(90deg,#00a99d,#44d9c9);border-radius:9px}}
    .two{{display:grid;grid-template-columns:1fr 1fr;gap:18px}}@media(max-width:900px){{aside{{position:static;width:100%}}main{{margin-left:0;padding:18px}}.two{{grid-template-columns:1fr}}}}
    input,select,textarea{{width:100%;padding:11px;border:1px solid #c9dfdc;border-radius:11px;background:#fff;font:inherit}}textarea{{min-height:90px;resize:vertical}}label{{font-weight:650;font-size:13px;display:block;margin:12px 0 6px}}
    .formgrid{{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}}@media(max-width:800px){{.formgrid{{grid-template-columns:1fr 1fr}}}}@media(max-width:500px){{.formgrid{{grid-template-columns:1fr}}}}
    button,.btn{{border:0;background:#008f83;color:white;padding:11px 16px;border-radius:12px;font-weight:700;cursor:pointer;text-decoration:none;display:inline-block}}button:hover,.btn:hover{{background:#00736b}}.btn.alt{{background:#e6f7f4;color:#006d67}}.actions{{display:flex;gap:10px;flex-wrap:wrap;margin-top:20px}}
    table{{width:100%;border-collapse:collapse;background:white;border-radius:15px;overflow:hidden}}th,td{{padding:10px;border-bottom:1px solid #e8f0ef;text-align:left;font-size:13px}}th{{background:#e8f8f5}}.scroll{{overflow:auto}}
    .notice{{padding:13px 16px;border-radius:12px;background:#e8f8f5;margin-bottom:15px}}.danger{{background:#fff0f0;color:#a33}}
    .login{{max-width:430px;margin:10vh auto}}.center{{text-align:center}}
    </style></head><body>{nav}<main>{body}</main></body></html>""")

@app.get("/login", response_class=HTMLResponse)
def login_page(request: Request):
    body = """<div class="login card center"><div class="heart">♥</div><h1>E-KESWA PUSBONAT</h1><p class="muted">Sistem Informasi Kesehatan Jiwa</p>
    <form method="post" action="/login"><label>Username</label><input name="username" required autofocus><label>Password</label><input type="password" name="password" required>
    <div class="actions"><button style="width:100%">Masuk</button></div></form></div>"""
    return page("Login", body, request)

@app.post("/login")
def login(request: Request, username: str = Form(...), password: str = Form(...)):
    if username == USERNAME and password == PASSWORD:
        request.session["login"] = True
        return RedirectResponse("/dashboard", status_code=303)
    return RedirectResponse("/login?error=1", status_code=303)

@app.get("/logout")
def logout(request: Request):
    request.session.clear()
    return RedirectResponse("/login", status_code=303)

def get_filters(request: Request):
    q = request.query_params
    mulai, sampai = q.get("mulai") or None, q.get("sampai") or None
    tahun, bulan = q.get("tahun") or "", q.get("bulan") or ""
    if not mulai and tahun:
        try:
            y=int(tahun); m=int(bulan) if bulan else 1
            mulai=f"{y:04d}-{m:02d}-01"
            if m == 12: sampai=f"{y+1:04d}-01-01"
            else: sampai=f"{y:04d}-{m+1:02d}-01"
        except: mulai=sampai=None
    return mulai, sampai, tahun, bulan

def filters_html(tahun="", bulan="", mulai="", sampai="", export=False):
    opts = "".join(f'<option value="{m}" {"selected" if bulan==str(m) else ""}>{m:02d}</option>' for m in range(1,13))
    extra = '<input type="hidden" name="from_export" value="1">' if export else ''
    return f"""<form class="panel" method="get"><div class="formgrid">
    <div><label>Tahun</label><input name="tahun" value="{tahun}" placeholder="2026"></div>
    <div><label>Bulan</label><select name="bulan"><option value="">Semua Bulan</option>{opts}</select></div>
    <div><label>Tanggal Mulai</label><input type="date" name="mulai" value="{mulai or ''}"></div>
    <div><label>Tanggal Akhir</label><input type="date" name="sampai" value="{sampai or ''}"></div>
    </div>{extra}<div class="actions"><button>Filter</button><a class="btn alt" href="/dashboard">Reset</a><a class="btn" href="/export">Export Excel</a></div></form>"""

def row_dict(r):
    return {k:r[k] for k in r.keys()} if r else {}

def metric(label, value, id=""):
    return f'<div class="card"><div class="label">{label}</div><div class="value" id="{id}">{value}</div></div>'

@app.get("/", response_class=HTMLResponse)
def root(request: Request):
    return RedirectResponse("/dashboard" if auth(request) else "/login", status_code=303)

@app.get("/dashboard", response_class=HTMLResponse)
def dashboard(request: Request):
    if not auth(request): return RedirectResponse("/login", status_code=303)
    mulai,sampai,tahun,bulan=get_filters(request)
    r=data_terbaru(mulai,sampai)
    d=row_dict(r)
    if not d:
        d={f:0 for f,_ in FIELDS}; d["tanggal"]=""
    body=f"""<h1>Dashboard</h1><p class="muted">Monitoring Kesehatan Jiwa Puskesmas Naibonat • pembaruan otomatis 2 detik</p>
    {filters_html(tahun,bulan,mulai,sampai)}
    <div class="grid">
    {metric("Total ODGJ Berat",d.get("total_odgj_berat",0),"dash_total")}
    {metric("SPM Capaian",d.get("spm_capaian",0),"dash_spm_capaian")}
    {metric("Diagnosis F20",d.get("f20",0),"dash_f20")}
    {metric("Diagnosis F23",d.get("f23",0),"dash_f23")}
    {metric("ODGJB Baru",d.get("odgjb_baru",0),"dash_baru")}
    {metric("P3LP Capaian",d.get("p3lp_capaian",0),"dash_p3lp")}
    {metric("Skrining Capaian",d.get("skrining_capaian",0),"dash_skrining")}
    </div>
    <div class="two">
      <div class="panel"><h2>SPM</h2><b id="dash_spm_persen">{d.get("spm_persentase",0)}%</b><div class="bar"><div id="progress_spm" class="fill" style="width:{min(float(d.get("spm_persentase",0)),100)}%"></div></div></div>
      <div class="panel"><h2>Pelacakan ODGJB</h2><b id="dash_pel_persen">{d.get("pelacakan_persentase",0)}%</b><div class="bar"><div id="progress_pel" class="fill" style="width:{min(float(d.get("pelacakan_persentase",0)),100)}%"></div></div></div>
      <div class="panel"><h2>P3LP</h2><b id="dash_p3lp_persen">{d.get("p3lp_persentase",0)}%</b><div class="bar"><div id="progress_p3lp" class="fill" style="width:{min(float(d.get("p3lp_persentase",0)),100)}%"></div></div></div>
      <div class="panel"><h2>Skrining ODGJB</h2><b id="dash_skr_persen">{d.get("skrining_persentase",0)}%</b><div class="bar"><div id="progress_skr" class="fill" style="width:{min(float(d.get("skrining_persentase",0)),100)}%"></div></div></div>
    </div>
    <div class="two" style="margin-top:18px"><div class="panel"><h2>ODGJB per Desa/Kelurahan</h2><canvas id="desaChart"></canvas></div><div class="panel"><h2>Status Obat</h2><canvas id="obatChart"></canvas></div></div>
    <div class="panel" style="margin-top:18px"><h2>Kendala • Solusi • RTL</h2><p><b>Kendala:</b> <span id="kendala">{d.get("kendala","")}</span></p><p><b>Solusi:</b> <span id="solusi">{d.get("solusi","")}</span></p><p><b>Rencana Tindak Lanjut:</b> <span id="rtl">{d.get("rencana_tindak_lanjut","")}</span></p></div>
    <script>
    let desaChart,obatChart;
    function setv(id,v){{let e=document.getElementById(id);if(e)e.textContent=v}}
    function pct(id,bar,v){{setv(id,(Number(v)||0).toFixed(2)+'%');let e=document.getElementById(bar);if(e)e.style.width=Math.min(Number(v)||0,100)+'%'}}
    async function refresh(){{try{{let r=await fetch('/api/dashboard'+location.search,{{cache:'no-store'}});let x=await r.json();let d=x.data||{{}};
      setv('dash_total',d.total_odgj_berat||0);setv('dash_spm_capaian',d.spm_capaian||0);setv('dash_f20',d.f20||0);setv('dash_f23',d.f23||0);setv('dash_baru',d.odgjb_baru||0);setv('dash_p3lp',d.p3lp_capaian||0);setv('dash_skrining',d.skrining_capaian||0);
      pct('dash_spm_persen','progress_spm',d.spm_persentase);pct('dash_pel_persen','progress_pel',d.pelacakan_persentase);pct('dash_p3lp_persen','progress_p3lp',d.p3lp_persentase);pct('dash_skr_persen','progress_skr',d.skrining_persentase);
      setv('kendala',d.kendala||'');setv('solusi',d.solusi||'');setv('rtl',d.rencana_tindak_lanjut||'');
      let labels=['Manusak','Oelatimo','Pukdale','Nunkurus','Naibonat'], vals=[d.manusak,d.oelatimo,d.pukdale,d.nunkurus,d.naibonat].map(Number);
      if(desaChart) desaChart.data.datasets[0].data=vals,desaChart.update(); else desaChart=new Chart(document.getElementById('desaChart'),{{type:'bar',data:{{labels,datasets:[{{label:'ODGJB',data:vals}}]}},options:{{responsive:true,plugins:{{legend:{{display:false}}}}}}}});
      let ov=[Number(d.obat_rutin)||0,Number(d.obat_tidak_rutin)||0,Number(d.obat_putus)||0];
      if(obatChart) obatChart.data.datasets[0].data=ov,obatChart.update(); else obatChart=new Chart(document.getElementById('obatChart'),{{type:'doughnut',data:{{labels:['Rutin','Tidak Rutin','Putus'],datasets:[{{data:ov}}]}}}});
    }}catch(e){{console.log(e)}}}}
    refresh();setInterval(refresh,2000);
    </script>"""
    return page("Dashboard",body,request)

def form_input(name,label,value="",typ="number"):
    if typ=="number":
        return f'<div><label>{label}</label><input type="number" min="0" step="1" name="{name}" value="{value or 0}"></div>'
    return f'<div><label>{label}</label><input type="{typ}" name="{name}" value="{value or ""}"></div>'

@app.get("/kesehatan-jiwa", response_class=HTMLResponse)
def keswa_page(request: Request):
    if not auth(request): return RedirectResponse("/login",status_code=303)
    rows=semua_data()
    body='<h1>Kesehatan Jiwa</h1><p class="muted">Input, simpan, edit, dan hapus data.</p>'
    body+='<form class="panel" method="post" action="/kesehatan-jiwa">'
    body+='<div class="formgrid">'
    body+=form_input("tanggal","Tanggal",date.today().isoformat(),"date")
    for name,label in FIELDS[1:]:
        if name in ("spm_persentase","pelacakan_persentase","p3lp_persentase","skrining_persentase"): continue
        if name in ("kendala","solusi","rencana_tindak_lanjut"): continue
        body+=form_input(name,label)
    body+='</div><div class="two">'
    for name,label in [("kendala","Kendala"),("solusi","Solusi"),("rencana_tindak_lanjut","Rencana Tindak Lanjut")]:
        body+=f'<div><label>{label}</label><textarea name="{name}"></textarea></div>'
    body+='</div><div class="notice">Persentase SPM, Pelacakan, P3LP, dan Skrining dihitung otomatis saat data disimpan.</div><div class="actions"><button type="submit">💾 Simpan Data</button><a class="btn alt" href="/dashboard">Kembali ke Dashboard</a></div></form>'
    body+='<div class="panel" style="margin-top:18px"><h2>Data Tersimpan</h2><div class="scroll"><table><tr><th>Tanggal</th><th>ODGJ Berat</th><th>SPM</th><th>F20</th><th>F23</th><th>Aksi</th></tr>'
    for r in rows:
        body += f"""<tr><td>{r["tanggal"]}</td><td>{r["total_odgj_berat"]}</td><td>{r["spm_capaian"]} / {r["spm_sasaran"]} ({r["spm_persentase"]}%)</td><td>{r["f20"]}</td><td>{r["f23"]}</td><td><a class="btn alt" href="/kesehatan-jiwa/edit/{r["id"]}">Edit</a> <form method="post" action="/hapus/{r["id"]}" style="display:inline" onsubmit="return confirm('Hapus data ini?')"><button class="btn" style="background:#a33">Hapus</button></form></td></tr>"""
    body+='</table></div></div>'
    return page("Kesehatan Jiwa",body,request)

@app.post("/kesehatan-jiwa")
async def save_keswa(request: Request):
    if not auth(request):
        return RedirectResponse("/login", status_code=303)

    data = dict(await request.form())
    simpan_data(data)

    return RedirectResponse("/kesehatan-jiwa?saved=1", status_code=303)

@app.get("/kesehatan-jiwa/edit/{record_id}", response_class=HTMLResponse)
def edit_page(request: Request, record_id:int):
    if not auth(request): return RedirectResponse("/login",status_code=303)
    r=ambil_data(record_id)
    if not r: return RedirectResponse("/kesehatan-jiwa",status_code=303)
    body=f'<h1>Edit Data #{record_id}</h1><form class="panel" method="post" action="/kesehatan-jiwa/edit/{record_id}"><div class="formgrid">'
    for name,label in FIELDS:
        if name in ("spm_persentase","pelacakan_persentase","p3lp_persentase","skrining_persentase"): continue
        v=r[name]
        if name in ("kendala","solusi","rencana_tindak_lanjut"): continue
        body+=form_input(name,label,v,"date" if name=="tanggal" else "number")
    body+='</div><div class="two">'
    for name,label in [("kendala","Kendala"),("solusi","Solusi"),("rencana_tindak_lanjut","Rencana Tindak Lanjut")]:
        body+=f'<div><label>{label}</label><textarea name="{name}">{r[name] or ""}</textarea></div>'
    body+='</div><div class="actions"><button>💾 Update Data</button><a class="btn alt" href="/kesehatan-jiwa">Batal</a></div></form>'
    return page("Edit Kesehatan Jiwa",body,request)

@app.post("/kesehatan-jiwa/edit/{record_id}")
async def edit_keswa(request: Request, record_id:int):
    if not auth(request): return RedirectResponse("/login",status_code=303)
    data=dict(await request.form());update_data(record_id,data)
    return RedirectResponse("/kesehatan-jiwa",status_code=303)

@app.post("/hapus/{record_id}")
def delete_keswa(request: Request, record_id:int):
    if not auth(request): return RedirectResponse("/login",status_code=303)
    hapus_data(record_id);return RedirectResponse("/kesehatan-jiwa",status_code=303)

@app.get("/api/dashboard")
def api_dashboard(request: Request):
    if not auth(request): return {"data":{}}
    mulai,sampai,_,_=get_filters(request)
    r=data_terbaru(mulai,sampai)
    return {"data":row_dict(r)}

@app.get("/export", response_class=HTMLResponse)
def export_page(request: Request):
    if not auth(request): return RedirectResponse("/login",status_code=303)
    mulai,sampai,tahun,bulan=get_filters(request)
    rows=semua_data(mulai,sampai)
    qs=f"tahun={tahun}&bulan={bulan}&mulai={mulai or ''}&sampai={sampai or ''}"
    body=f"""<h1>Export Excel</h1><p class="muted">Pilih periode, lihat pratinjau, lalu unduh file Excel.</p>
    {filters_html(tahun,bulan,mulai,sampai,True)}
    <div class="panel"><h2>Pratinjau</h2><p><b>{len(rows)}</b> entri ditemukan.</p><div class="scroll"><table><tr><th>Tanggal</th><th>ODGJ Berat</th><th>SPM</th><th>F20</th><th>F23</th></tr>"""
    for r in rows[:30]:
        body += f"""<tr><td>{r["tanggal"]}</td><td>{r["total_odgj_berat"]}</td><td>{r["spm_capaian"]} / {r["spm_sasaran"]} ({r["spm_persentase"]}%)</td><td>{r["f20"]}</td><td>{r["f23"]}</td><td><a class="btn alt" href="/kesehatan-jiwa/edit/{r["id"]}">Edit</a> <form method="post" action="/hapus/{r["id"]}" style="display:inline" onsubmit="return confirm('Hapus data ini?')"><button class="btn" style="background:#a33">Hapus</button></form></td></tr>"""
    body+=f'</table></div><div class="actions"><a class="btn" href="/export/excel?{qs}">⬇ Download Excel</a></div></div>'
    return page("Export Excel",body,request)

@app.get("/export/excel")
def export_excel(request: Request):
    if not auth(request): return RedirectResponse("/login",status_code=303)
    mulai,sampai,_,_=get_filters(request)
    rows=semua_data(mulai,sampai)
    wb=Workbook();ws=wb.active;ws.title="Data Keswa"
    headers=[x[1] for x in FIELDS]
    ws.append(headers)
    for c in ws[1]:
        c.font=Font(bold=True);c.alignment=Alignment(horizontal="center")
    for r in rows:
        ws.append([r[x[0]] for x in FIELDS])
    for row in ws.iter_rows():
        for c in row: c.alignment=Alignment(vertical="top")
    for col in ["E","U","X","AA"]:
        for c in ws[col][1:]: c.number_format="0.00%"
        # Stored values are 0-100, so convert to Excel fraction.
        for c in ws[col][1:]:
            if isinstance(c.value,(int,float)): c.value=float(c.value)/100
    for col in ws.columns:
        letter=col[0].column_letter
        ws.column_dimensions[letter].width=min(max(max(len(str(c.value or "")) for c in col)+2,10),35)
    bio=BytesIO();wb.save(bio);bio.seek(0)
    filename=f"E-KESWA_PUSBONAT_{date.today().isoformat()}.xlsx"
    return StreamingResponse(bio,media_type="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",headers={"Content-Disposition":f'attachment; filename="{filename}"'})
