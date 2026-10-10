from fastapi import FastAPI
from fastapi.responses import HTMLResponse

app = FastAPI(title="E-PUSBONAT Keswa")

PAGE = r'''<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="theme-color" content="#087f82">
<title>Dashboard Kesehatan Jiwa | Puskesmas Naibonat</title>
<style>
:root{--teal:#087f82;--deep:#075467;--mint:#d9fff0;--blue:#168fe0;--gold:#ffc83d;--red:#f04452;--green:#37b84b;--ink:#092d49;--bg:#e8f9fa;--line:#cdebed}
*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--ink);font-family:Arial,Helvetica,sans-serif}
button,input,textarea,select{font:inherit}
button{cursor:pointer}
.toolbar{position:sticky;top:0;z-index:10;background:#fff;padding:10px 16px;display:flex;justify-content:space-between;align-items:center;gap:10px;box-shadow:0 3px 16px #064e5b18}
.toolbar strong{font-size:14px;color:var(--teal)}
.actions{display:flex;gap:7px;flex-wrap:wrap}
.btn{border:0;border-radius:9px;padding:10px 13px;font-weight:700;font-size:12px}
.primary{background:var(--teal);color:white}.gold{background:var(--gold);color:#23394a}.light{background:#e9f6f7;color:var(--deep)}
.wrap{max-width:1200px;margin:auto;padding:14px}
.hero{min-height:205px;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:space-between;gap:20px;padding:27px 4%;color:#fff;background:linear-gradient(115deg,#087b83,#006080 60%,#034d65)}
.hero:before{content:"✚";position:absolute;right:22%;font-size:250px;color:#ffffff0d}
.hero-copy{z-index:1}
.kicker{font-size:11px;letter-spacing:2px;color:#b8f5ec;font-weight:bold}
.hero h1{font-size:clamp(25px,4vw,43px);line-height:1.08;margin:12px 0 5px}
.hero h2{font-size:clamp(17px,2.5vw,27px);color:#ffda70;margin:7px 0}
.byline{font-size:13px;letter-spacing:.3px}
.hero-side{z-index:1;max-width:180px;border-left:3px solid #ffcf56;padding:10px 0 10px 16px;font-size:12px;line-height:1.8;letter-spacing:2px}
.months{display:grid;grid-template-columns:repeat(12,minmax(0,1fr));gap:5px;margin:12px 0;background:white;border:1px solid var(--line);padding:9px;border-radius:15px}
.month{border:1px solid #d5e9ec;background:#f3fbfd;border-radius:9px;padding:10px 2px;color:#143953;font-size:11px;font-weight:bold}
.month.active{background:var(--deep);color:#ffdc6e;border:3px solid var(--gold);padding:8px 0}
.grid3{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
.panel{background:#fff;border:1px solid #cde9eb;border-radius:17px;padding:12px;box-shadow:0 5px 15px #087f8210;min-width:0;overflow:hidden}
.panel-head{display:flex;align-items:center;gap:11px;margin:-2px -2px 12px;padding:11px;border-radius:12px;background:#d8fff0}
.panel-head h3{font-size:clamp(15px,1.7vw,23px);line-height:1.12;margin:0;text-transform:uppercase}
.panel-head .ico{width:49px;height:49px;flex-shrink:0;border-radius:50%;display:grid;place-items:center;background:#078d83;color:#fff;font-size:24px;font-weight:bold}
.yellow-head{background:#fff4d8}.yellow-head .ico{background:#059f9a}
.blue-head{background:#dff7ff}.blue-head .ico{background:#087aa5}
.red-head{background:#ffe0df}.red-head .ico{background:#f04452}
.legend{display:flex;justify-content:center;flex-wrap:wrap;gap:9px;margin:8px 0 4px;font-size:10px}
.legend span{display:flex;align-items:center;gap:5px}
.dot{width:10px;height:10px;border-radius:50%;display:inline-block}
.chart{height:220px;width:100%;display:block}
.metrics{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:4px;margin-top:7px}
.metric{text-align:center;border-radius:9px;padding:10px 3px;background:#fff1bd;min-width:0}
.metric:nth-child(2){background:#d5fbe5}
.metric:nth-child(3){background:#d7edff}
.metric strong{display:block;font-size:clamp(15px,2vw,22px);overflow-wrap:anywhere}
.metric span{display:block;font-size:11px;line-height:1.4;margin-top:4px}
.metric.red{background:#ffdddd}.metric.red strong{color:#c91c34}
.metric.green strong{color:#12652e}
.metric.blue strong{color:#0752a0}
.info-panel{margin-top:12px}
.yellow-strip{text-align:center;background:linear-gradient(90deg,#ffdb65,#ffc62f);padding:10px;border-radius:10px;font-weight:900;font-size:clamp(14px,2vw,20px);margin:8px 0}
.info-line{padding:10px;border-radius:10px;background:#fff5db;margin:7px 0;font-size:13px;line-height:1.8}
.info-line strong{font-size:15px}
.subheading{font-size:14px;font-weight:900;padding:8px 3px 2px}
.simple-list{display:grid;gap:8px}
.list-item{display:flex;align-items:center;gap:10px;background:#fff0ef;border-radius:11px;padding:10px;font-size:13px;line-height:1.5}
.list-item .num{width:35px;height:35px;flex-shrink:0;border-radius:50%;display:grid;place-items:center;background:#ffc1c0;font-size:16px;font-weight:900}
.solutions .list-item{background:#d8fbf4}
.solutions .num{background:#51d9cb}
.region{margin-top:13px;background:linear-gradient(110deg,#9be6ed,#d5fbfa);border:1px solid #91dfe5;border-radius:17px;padding:14px}
.region h3{margin:0 0 12px;font-size:clamp(15px,2vw,21px);text-transform:uppercase}
.region-layout{display:grid;grid-template-columns:1fr 165px;gap:12px}
.region-cards{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:5px}
.region-card{background:#f0fdff;border-radius:11px;text-align:center;padding:10px 3px;border:1px solid #b7e9ee;min-width:0}
.region-card:last-child{background:#fff0c6}
.region-card .pin{font-size:20px;color:#0597ad}
.region-card strong{display:block;font-size:clamp(12px,1.7vw,20px);margin:5px 0;overflow-wrap:anywhere}
.region-card .name{font-size:clamp(9px,1.1vw,12px);font-weight:bold;overflow-wrap:anywhere}
.region-card small{font-size:10px}
.region-totals{display:grid;gap:7px}
.total-box{background:#d8fbdc;border-radius:12px;padding:10px;text-align:center}
.total-box:last-child{background:#ffc934}
.total-box span{display:block;font-weight:bold;font-size:12px}
.total-box strong{font-size:35px}
.footer{margin-top:13px;padding:18px;color:white;border-radius:14px;background:linear-gradient(110deg,#075064,#008a8a);display:flex;justify-content:space-between;align-items:center;gap:12px}
.footer em{font-family:Georgia,serif;font-style:italic;font-size:clamp(14px,2vw,21px);line-height:1.5}
.footer small{text-align:right;letter-spacing:2px;line-height:2}
.modal{position:fixed;inset:0;z-index:30;background:#062d3bd9;display:none;align-items:flex-start;justify-content:center;padding:18px;overflow:auto}
.modal.open{display:flex}
.dialog{background:white;width:min(760px,100%);border-radius:16px;padding:20px}
.dialog-top{display:flex;justify-content:space-between;gap:12px;align-items:center}
.dialog h2{margin:0;font-size:21px}
.dialog p{font-size:12px;line-height:1.6;color:#59717c}
.formgrid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
.field{display:flex;flex-direction:column;gap:5px}
.field label{font-size:12px;font-weight:bold;color:#214351}
.field input,.field textarea{width:100%;border:1px solid #cbdfe2;border-radius:8px;padding:10px;background:#fbfefe;color:#153b48}
.field textarea{min-height:75px;resize:vertical}
.field.full{grid-column:1/-1}
.dialog-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:18px;flex-wrap:wrap}
.toast{position:fixed;bottom:20px;left:50%;transform:translateX(-50%);background:#073f4d;color:white;padding:12px 18px;border-radius:10px;z-index:50;display:none;font-size:13px}
@media(max-width:800px){.grid3{grid-template-columns:1fr}.panel{padding:12px}.chart{height:240px}.months{grid-template-columns:repeat(6,minmax(0,1fr))}.region-layout{grid-template-columns:1fr}.region-cards{grid-template-columns:repeat(3,minmax(0,1fr))}.region-totals{grid-template-columns:repeat(2,minmax(0,1fr))}.hero-side{display:none}.hero{min-height:180px}}
@media(max-width:420px){.wrap{padding:7px}.toolbar{padding:9px}.toolbar strong{font-size:11px}.btn{padding:9px;font-size:11px}.formgrid{grid-template-columns:1fr}.field.full{grid-column:auto}.region-cards{grid-template-columns:repeat(2,minmax(0,1fr))}.footer{align-items:flex-start;flex-direction:column}.footer small{text-align:left}}
@media print{.toolbar,.months,.actions{display:none!important}.wrap{max-width:none;padding:0}.panel,.region,.hero,.footer{break-inside:avoid;box-shadow:none}.grid3{grid-template-columns:repeat(3,minmax(0,1fr))}.region-layout{grid-template-columns:1fr 140px}body{background:white}.chart{height:180px}}
</style>
</head>
<body>
<div class="toolbar">
 <strong>E-PUSBONAT · DASHBOARD KESWA</strong>
 <div class="actions">
  <button class="btn light" onclick="resetMonth()">Reset bulan</button>
  <button class="btn gold" onclick="openEditor()">✎ EDIT DASHBOARD</button>
  <button class="btn primary" onclick="window.print()">Cetak / PDF</button>
 </div>
</div>

<div class="wrap">
<header class="hero">
 <div class="hero-copy">
  <div class="kicker">✚ PUSKESMAS NAIBONAT</div>
  <h1 id="heroTitle">DASHBOARD<br>KESEHATAN JIWA</h1>
  <h2 id="heroSub">PUSKESMAS NAIBONAT</h2>
  <div class="byline" id="byline">Oleh: Yeheskiel Baitanu, S.Kep., Ns.</div>
 </div>
 <div class="hero-side">KESEHATAN<br>JIWA<br>UNTUK<br>MASYARAKAT<br>YANG LEBIH BAIK</div>
</header>

<nav class="months" id="months"></nav>

<section class="grid3">
 <article class="panel">
  <div class="panel-head"><div class="ico">♟</div><h3>SPM PELAYANAN ODGJ</h3></div>
  <div class="legend"><span><i class="dot" style="background:#ffce29"></i>Target</span><span><i class="dot" style="background:#39b94b"></i>Capaian</span><span><i class="dot" style="background:#087ce8"></i>Persentase</span></div>
  <svg class="chart" id="chartSpm" viewBox="0 0 320 225" role="img" aria-label="Grafik SPM"></svg>
  <div class="metrics" id="metricsSpm"></div>
 </article>
 <article class="panel">
  <div class="panel-head yellow-head"><div class="ico">▥</div><h3>SKRINING JIWA</h3></div>
  <div class="legend"><span><i class="dot" style="background:#ef2340"></i>Target</span><span><i class="dot" style="background:#39b94b"></i>Capaian</span><span><i class="dot" style="background:#087ce8"></i>Persentase</span></div>
  <svg class="chart" id="chartScreen" viewBox="0 0 320 225" role="img" aria-label="Grafik skrining jiwa"></svg>
  <div class="metrics" id="metricsScreen"></div>
 </article>
 <article class="panel">
  <div class="panel-head blue-head"><div class="ico">⌁</div><h3 id="bokTitle">GIAT BOK (20 ORANG)</h3></div>
  <div class="legend" style="justify-content:flex-start;line-height:1.6"><span><i class="dot" style="background:#ffcc2d"></i>Target</span><span><i class="dot" style="background:#ef3547"></i>Capaian</span><span><i class="dot" style="background:#087ce8"></i>Persentase</span></div>
  <svg class="chart" id="chartBok" viewBox="0 0 320 225" role="img" aria-label="Grafik GIAT BOK"></svg>
  <div class="metrics" id="metricsBok"></div>
 </article>
</section>

<section class="grid3 info-panel">
 <article class="panel">
  <div class="panel-head blue-head"><div class="ico">♟</div><h3>INFO ODGJ</h3></div>
  <div class="yellow-strip" id="totalStrip"></div>
  <div class="info-line" id="infoDiagnosis"></div>
  <div style="border-top:1px dashed #b7d5d8;margin:12px 0"></div>
  <div class="subheading">ODGJ BARU</div>
  <div class="info-line" style="background:#f5fbfc" id="infoNew"></div>
 </article>
 <article class="panel">
  <div class="panel-head red-head"><div class="ico">!</div><h3>KENDALA</h3></div>
  <div class="simple-list" id="obstacles"></div>
 </article>
 <article class="panel">
  <div class="panel-head"><div class="ico">☼</div><h3>SOLUSI</h3></div>
  <div class="simple-list solutions" id="solutions"></div>
 </article>
</section>

<section class="region">
 <h3>📍 JUMLAH ODGJ BERDASARKAN WILAYAH</h3>
 <div class="region-layout">
  <div class="region-cards" id="regions"></div>
  <div class="region-totals">
   <div class="total-box"><span>◉ F20</span><strong id="f20Total"></strong></div>
   <div class="total-box"><span>♟ TOTAL ODGJ</span><strong id="odgjTotal"></strong></div>
  </div>
 </div>
</section>

<footer class="footer">
 <em id="footerText">Setiap Skrining Adalah<br>Langkah Menuju Masyarakat yang Lebih Sehat</em>
 <small id="footerRight">PUSKESMAS NAIBONAT<br>KESEHATAN JIWA · HARAPAN BERSAMA</small>
</footer>
</div>

<div class="modal" id="editor">
 <div class="dialog">
  <div class="dialog-top"><h2>✎ Edit Dashboard Kesehatan Jiwa</h2><button class="btn light" onclick="closeEditor()">Tutup ✕</button></div>
  <p>Ubah informasi dan angka pada formulir. Grafik, persentase, dan kartu wilayah akan diperbarui otomatis. Data disimpan pada browser perangkat ini.</p>
  <form id="editForm">
   <div class="formgrid" id="formFields"></div>
   <div class="dialog-actions">
    <button type="button" class="btn light" onclick="closeEditor()">Batal</button>
    <button type="button" class="btn light" onclick="exportData()">Ekspor JSON</button>
    <button type="submit" class="btn primary">Simpan Perubahan</button>
   </div>
  </form>
 </div>
</div>
<input type="file" id="importFile" accept=".json,application/json" hidden>
<div class="toast" id="toast"></div>

<script>
const DEFAULT = {
 title:"DASHBOARD KESEHATAN JIWA",
 subtitle:"PUSKESMAS NAIBONAT",
 byline:"Oleh: Yeheskiel Baitanu, S.Kep., Ns.",
 footer:"Setiap Skrining Adalah\nLangkah Menuju Masyarakat yang Lebih Sehat",
 footerRight:"PUSKESMAS NAIBONAT\nKESEHATAN JIWA · HARAPAN BERSAMA",
 bokTitle:"GIAT BOK (20 ORANG)",
 spmTarget:35,spmAchieved:36,
 screenTarget:3259,screenAchieved:5740,
 bokTarget:6,bokAchieved:2,
 odgjTotal:50,f20:46,other:3,
 newMonth:"September",newMonthly:2,newCumulative:9,
 obstacles:["Keterbatasan SDM","Stigma masyarakat","Peran keluarga minim"],
 solutions:["Optimalkan peran keluarga dan kader","Koordinasi lintas sektor","Jadwal rutin","Edukasi kesehatan jiwa"],
 regions:[
  {name:"OELATIMO",count:11,code:"L6. P5"},
  {name:"NUNUKURUS",count:4,code:"L2. P2"},
  {name:"MANUSAK",count:3,code:"L3. P3"},
  {name:"PUKDALE",count:8,code:"L2. P6"},
  {name:"NAIBONAT",count:20,code:"L8. P12"},
  {name:"LAIN-LAIN",count:3,code:""}
 ]
};
const MONTHS=["JAN","FEB","MAR","APR","MEI","JUN","JUL","AGS","SEP","OKTOBER","NOV","DES"];
let data=loadData();
let selectedMonth="OKTOBER";

function loadData(){
 try{
  const saved=localStorage.getItem("epusbonat-keswa-data");
  return saved?mergeData(JSON.parse(saved)):structuredClone(DEFAULT);
 }catch(e){return JSON.parse(JSON.stringify(DEFAULT))}
}
function mergeData(x){
 const d={...DEFAULT,...x};
 d.regions=Array.isArray(x.regions)?x.regions:JSON.parse(JSON.stringify(DEFAULT.regions));
 d.obstacles=Array.isArray(x.obstacles)?x.obstacles:[...DEFAULT.obstacles];
 d.solutions=Array.isArray(x.solutions)?x.solutions:[...DEFAULT.solutions];
 return d;
}
function saveData(){localStorage.setItem("epusbonat-keswa-data",JSON.stringify(data))}
function pct(a,b){return b?Number(a)/Number(b)*100:0}
function fmt(n){return Number(n||0).toLocaleString("id-ID",{maximumFractionDigits:2})}
function percent(a,b){return pct(a,b).toLocaleString("id-ID",{minimumFractionDigits:2,maximumFractionDigits:2})+"%"}
function text(id,value){document.getElementById(id).textContent=value}
function safe(v){return String(v??"").replace(/[&<>"']/g,c=>({"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;"}[c]))}
function drawMonths(){
 document.getElementById("months").innerHTML=MONTHS.map(m=>
  `<button class="month ${m===selectedMonth?"active":""}" onclick="selectMonth('${m}')">${m}</button>`
 ).join("");
}
function selectMonth(m){selectedMonth=m;drawMonths();toast("Bulan aktif: "+m)}
function resetMonth(){if(confirm("Kembalikan data dashboard bulan ini ke data awal? Data simpanan browser akan dihapus.")){localStorage.removeItem("epusbonat-keswa-data");data=JSON.parse(JSON.stringify(DEFAULT));render();toast("Data awal dipulihkan")}}
function barChart(id,items,maxValue){
 const svg=document.getElementById(id),W=320,H=225,L=32,R=8,T=24,B=46,plotH=H-T-B,plotW=W-L-R;
 let html="";
 for(let i=0;i<=4;i++){
  const y=T+plotH*i/4,val=maxValue*(1-i/4);
  html+=`<line x1="${L}" y1="${y}" x2="${W-R}" y2="${y}" stroke="#d8e8e9" stroke-width="1"/><text x="${L-6}" y="${y+4}" text-anchor="end" fill="#24455d" font-size="10">${fmt(val)}</text>`;
 }
 const slot=plotW/items.length,bw=Math.min(48,slot*.58);
 items.forEach((it,i)=>{
  const h=Math.max(2,Math.min(plotH,Number(it.value||0)/maxValue*plotH));
  const x=L+i*slot+(slot-bw)/2,y=T+plotH-h;
  html+=`<rect x="${x}" y="${y}" width="${bw}" height="${h}" rx="2" fill="${it.color}"/>`;
  html+=`<text x="${x+bw/2}" y="${Math.max(13,y-6)}" text-anchor="middle" fill="#111f30" font-weight="bold" font-size="${String(it.value).length>7?9:12}">${safe(fmt(it.value))}</text>`;
  html+=`<text x="${x+bw/2}" y="${H-B+17}" text-anchor="middle" fill="#17384f" font-size="10">${it.label}</text>`;
 });
 svg.innerHTML=html;
}
function lineChart(id,items){
 const svg=document.getElementById(id),W=320,H=225,L=30,R=12,T=20,B=46,ph=H-T-B,pw=W-L-R;
 let html="";
 for(let i=0;i<=5;i++){let y=T+ph*i/5;html+=`<line x1="${L}" y1="${y}" x2="${W-R}" y2="${y}" stroke="#d8e8e9"/><text x="${L-5}" y="${y+4}" text-anchor="end" fill="#24455d" font-size="10">${5-i}</text>`}
 let pts=items.map((v,i)=>({x:L+pw*i/(items.length-1),y:T+ph-(Math.min(5,v.value)/5)*ph,v}));
 html+=`<polyline points="${pts.map(p=>p.x+","+p.y).join(" ")}" fill="none" stroke="#f0b824" stroke-width="3"/>`;
 html+=`<polyline points="${pts.map(p=>p.x+","+p.y).join(" ")}" fill="none" stroke="#ed394d" stroke-width="2"/>`;
 pts.forEach((p,i)=>{html+=`<circle cx="${p.x}" cy="${p.y}" r="5" fill="${items[i].color}"/><text x="${p.x}" y="${p.y-11}" text-anchor="middle" fill="#142d43" font-size="12" font-weight="bold">${safe(fmt(items[i].value))}</text><text x="${p.x}" y="${H-B+13}" text-anchor="middle" fill="#17384f" font-size="10">${items[i].label}</text>`});
 svg.innerHTML=html;
}
function metricHTML(a,b,p){
 return `<div class="metric"><strong>${fmt(a)}</strong><span>Target</span></div><div class="metric green"><strong>${fmt(b)}</strong><span>Capaian</span></div><div class="metric blue"><strong>${percent(b,a)}</strong><span>Persentase</span></div>`;
}
function render(){
 text("heroTitle",data.title);text("heroSub",data.subtitle);text("byline",data.byline);
 text("footerText",data.footer);text("footerRight",data.footerRight);text("bokTitle",data.bokTitle);
 barChart("chartSpm",[{label:"TARGET",value:data.spmTarget,color:"#ffcc2f"},{label:"CAPAIAN",value:data.spmAchieved,color:"#43b94d"},{label:"PERSEN",value:pct(data.spmAchieved,data.spmTarget),color:"#168fe0"}],Math.max(50,data.spmTarget,data.spmAchieved,pct(data.spmAchieved,data.spmTarget))*1.12);
 barChart("chartScreen",[{label:"TARGET",value:data.screenTarget,color:"#ed2340"},{label:"CAPAIAN",value:data.screenAchieved,color:"#43b94d"},{label:"PERSEN",value:pct(data.screenAchieved,data.screenTarget),color:"#168fe0"}],Math.max(data.screenTarget,data.screenAchieved)*1.2);
 lineChart("chartBok",[{label:"TARGET",value:data.bokTarget,color:"#ffcc2f"},{label:"CAPAIAN",value:data.bokAchieved,color:"#ed3548"},{label:"PERSEN",value:pct(data.bokAchieved,data.bokTarget)/20,color:"#168fe0"}]);
 document.getElementById("metricsSpm").innerHTML=metricHTML(data.spmTarget,data.spmAchieved);
 document.getElementById("metricsScreen").innerHTML=metricHTML(data.screenTarget,data.screenAchieved);
 document.getElementById("metricsBok").innerHTML=metricHTML(data.bokTarget,data.bokAchieved);
 text("totalStrip","TOTAL ODGJ : "+fmt(data.odgjTotal)+" ORANG");
 document.getElementById("infoDiagnosis").innerHTML=`<strong>👤 ODGJB (F20) : ${safe(fmt(data.f20))}<br>Lain-lain : ${safe(fmt(data.other))}</strong>`;
 document.getElementById("infoNew").innerHTML=`▦ &nbsp; Bulan ${safe(data.newMonth)} : <strong>${safe(fmt(data.newMonthly))}</strong><br>▥ &nbsp; Kumulatif : <strong>${safe(fmt(data.newCumulative))}</strong>`;
 document.getElementById("obstacles").innerHTML=data.obstacles.map((x,i)=>`<div class="list-item"><span class="num">${i+1}</span><strong>${safe(x)}</strong></div>`).join("");
 document.getElementById("solutions").innerHTML=data.solutions.map((x,i)=>`<div class="list-item"><span class="num">${i+1}</span><strong>${safe(x)}</strong></div>`).join("");
 document.getElementById("regions").innerHTML=data.regions.map(r=>`<div class="region-card"><div class="pin">●</div><div class="name">${safe(r.name)}</div><strong>${safe(fmt(r.count))}</strong><small>${safe(r.code||"")}</small></div>`).join("");
 text("f20Total",fmt(data.f20));text("odgjTotal",fmt(data.odgjTotal));
 drawMonths();
}
function field(label,key,value,type="text",full=false){
 return `<div class="field ${full?"full":""}"><label for="f_${key}">${safe(label)}</label><input id="f_${key}" name="${key}" type="${type}" value="${safe(value)}" ${type==="number"?'min="0" step="any"':""}></div>`;
}
function area(label,key,value){
 return `<div class="field full"><label for="f_${key}">${safe(label)} (satu item per baris)</label><textarea id="f_${key}" name="${key}">${safe(value.join("\n"))}</textarea></div>`;
}
function openEditor(){
 let h="";
 h+=field("Judul utama","title",data.title,"text",true);
 h+=field("Nama Puskesmas","subtitle",data.subtitle);
 h+=field("Nama petugas / penyusun","byline",data.byline);
 h+=field("Target SPM ODGJ","spmTarget",data.spmTarget,"number");
 h+=field("Capaian SPM ODGJ","spmAchieved",data.spmAchieved,"number");
 h+=field("Target skrining jiwa","screenTarget",data.screenTarget,"number");
 h+=field("Capaian skrining jiwa","screenAchieved",data.screenAchieved,"number");
 h+=field("Target GIAT BOK","bokTarget",data.bokTarget,"number");
 h+=field("Capaian GIAT BOK","bokAchieved",data.bokAchieved,"number");
 h+=field("Judul GIAT BOK","bokTitle",data.bokTitle,"text",true);
 h+=field("Total ODGJ","odgjTotal",data.odgjTotal,"number");
 h+=field("Jumlah F20","f20",data.f20,"number");
 h+=field("Jumlah diagnosis lain","other",data.other,"number");
 h+=field("Bulan ODGJ baru","newMonth",data.newMonth);
 h+=field("ODGJ baru bulan tersebut","newMonthly",data.newMonthly,"number");
 h+=field("ODGJ baru kumulatif","newCumulative",data.newCumulative,"number");
 h+=area("Kendala","obstacles",data.obstacles);
 h+=area("Solusi","solutions",data.solutions);
 data.regions.forEach((r,i)=>{
  h+=field("Wilayah "+(i+1),"regionName"+i,r.name);
  h+=field("Jumlah ODGJ "+r.name,"regionCount"+i,r.count,"number");
  h+=field("Keterangan "+r.name,"regionCode"+i,r.code);
 });
 h+=field("Teks footer","footer",data.footer,"text",true);
 h+=field("Teks kanan footer","footerRight",data.footerRight,"text",true);
 document.getElementById("formFields").innerHTML=h;
 document.getElementById("editor").classList.add("open");
}
function closeEditor(){document.getElementById("editor").classList.remove("open")}
document.getElementById("editForm").addEventListener("submit",e=>{
 e.preventDefault();
 const fd=new FormData(e.target);
 const strings=["title","subtitle","byline","bokTitle","newMonth","footer","footerRight"];
 strings.forEach(k=>data[k]=String(fd.get(k)||""));
 ["spmTarget","spmAchieved","screenTarget","screenAchieved","bokTarget","bokAchieved","odgjTotal","f20","other","newMonthly","newCumulative"].forEach(k=>data[k]=Math.max(0,Number(fd.get(k)||0)));
 data.obstacles=String(fd.get("obstacles")||"").split("\n").map(s=>s.trim()).filter(Boolean);
 data.solutions=String(fd.get("solutions")||"").split("\n").map(s=>s.trim()).filter(Boolean);
 data.regions=data.regions.map((r,i)=>({
  name:String(fd.get("regionName"+i)||""),
  count:Math.max(0,Number(fd.get("regionCount"+i)||0)),
  code:String(fd.get("regionCode"+i)||"")
 }));
 saveData();render();closeEditor();toast("Perubahan dashboard berhasil disimpan di browser");
});
function toast(s){let t=document.getElementById("toast");t.textContent=s;t.style.display="block";setTimeout(()=>t.style.display="none",2600)}
function exportData(){
 const blob=new Blob([JSON.stringify(data,null,2)],{type:"application/json"});
 const a=document.createElement("a");a.href=URL.createObjectURL(blob);a.download="data-dashboard-keswa.json";a.click();URL.revokeObjectURL(a.href);
}
render();
</script>
</body>
</html>'''

@app.get("/", response_class=HTMLResponse)
def dashboard():
    return PAGE

@app.get("/health")
def health():
    return {"status": "ok", "app": "E-PUSBONAT Keswa"}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run("main:app", host="127.0.0.1", port=8000, reload=True)
