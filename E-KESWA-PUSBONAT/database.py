import sqlite3
from pathlib import Path
from datetime import datetime

BASE_DIR = Path(__file__).resolve().parent
DATA_DIR = BASE_DIR / "data"
DB_PATH = DATA_DIR / "e_keswa.db"

FIELDS = [
    "tanggal", "total_odgj_berat", "spm_sasaran", "spm_capaian", "spm_persentase",
    "f23", "f20", "manusak", "oelatimo", "pukdale", "nunkurus", "naibonat",
    "obat_sasaran", "obat_rutin", "obat_tidak_rutin", "obat_putus", "odgjb_baru",
    "pelacakan_sasaran", "pelacakan_capaian", "pelacakan_persentase",
    "p3lp_sasaran", "p3lp_capaian", "p3lp_persentase",
    "skrining_sasaran", "skrining_capaian", "skrining_persentase",
    "kendala", "solusi", "rencana_tindak_lanjut"
]

NUMERIC_FIELDS = [x for x in FIELDS if x not in {
    "tanggal", "kendala", "solusi", "rencana_tindak_lanjut"
}]

def koneksi():
    DATA_DIR.mkdir(parents=True, exist_ok=True)
    conn = sqlite3.connect(DB_PATH)
    conn.row_factory = sqlite3.Row
    return conn

def _angka(v):
    if v is None or str(v).strip() == "":
        return 0
    try:
        return float(v) if "." in str(v) else int(v)
    except (ValueError, TypeError):
        return 0

def _persen(capaian, sasaran):
    try:
        s = float(sasaran or 0)
        c = float(capaian or 0)
        return round((c / s) * 100, 2) if s > 0 else 0
    except (ValueError, TypeError, ZeroDivisionError):
        return 0

def _normalisasi(data):
    d = dict(data or {})
    for f in NUMERIC_FIELDS:
        d[f] = _angka(d.get(f, 0))
    d["tanggal"] = str(d.get("tanggal") or datetime.now().strftime("%Y-%m-%d"))
    d["kendala"] = str(d.get("kendala") or "")
    d["solusi"] = str(d.get("solusi") or "")
    d["rencana_tindak_lanjut"] = str(d.get("rencana_tindak_lanjut") or "")
    d["spm_persentase"] = _persen(d["spm_capaian"], d["spm_sasaran"])
    d["pelacakan_persentase"] = _persen(d["pelacakan_capaian"], d["pelacakan_sasaran"])
    d["p3lp_persentase"] = _persen(d["p3lp_capaian"], d["p3lp_sasaran"])
    d["skrining_persentase"] = _persen(d["skrining_capaian"], d["skrining_sasaran"])
    return d

def init_database():
    with koneksi() as conn:
        conn.execute("""
        CREATE TABLE IF NOT EXISTS keswa (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            tanggal TEXT NOT NULL,
            total_odgj_berat INTEGER DEFAULT 0,
            spm_sasaran INTEGER DEFAULT 0,
            spm_capaian INTEGER DEFAULT 0,
            spm_persentase REAL DEFAULT 0,
            f23 INTEGER DEFAULT 0,
            f20 INTEGER DEFAULT 0,
            manusak INTEGER DEFAULT 0,
            oelatimo INTEGER DEFAULT 0,
            pukdale INTEGER DEFAULT 0,
            nunkurus INTEGER DEFAULT 0,
            naibonat INTEGER DEFAULT 0,
            obat_sasaran INTEGER DEFAULT 0,
            obat_rutin INTEGER DEFAULT 0,
            obat_tidak_rutin INTEGER DEFAULT 0,
            obat_putus INTEGER DEFAULT 0,
            odgjb_baru INTEGER DEFAULT 0,
            pelacakan_sasaran INTEGER DEFAULT 0,
            pelacakan_capaian INTEGER DEFAULT 0,
            pelacakan_persentase REAL DEFAULT 0,
            p3lp_sasaran INTEGER DEFAULT 0,
            p3lp_capaian INTEGER DEFAULT 0,
            p3lp_persentase REAL DEFAULT 0,
            skrining_sasaran INTEGER DEFAULT 0,
            skrining_capaian INTEGER DEFAULT 0,
            skrining_persentase REAL DEFAULT 0,
            kendala TEXT DEFAULT '',
            solusi TEXT DEFAULT '',
            rencana_tindak_lanjut TEXT DEFAULT '',
            dibuat_pada TEXT DEFAULT '',
            diperbarui_pada TEXT DEFAULT ''
        )
        """)
        conn.commit()

def simpan_data(data):
    d = _normalisasi(data)

    cols = FIELDS + ["dibuat_pada", "diperbarui_pada"]
    now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    vals = [d[f] for f in FIELDS] + [now, now]

    sql = f"""
        INSERT INTO keswa ({", ".join(cols)})
        VALUES ({", ".join(["?"] * len(vals))})
    """

    with koneksi() as conn:
        cursor = conn.execute(sql, vals)
        conn.commit()
        return cursor.lastrowid

def update_data(record_id, data):
    d = _normalisasi(data)
    now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    assignments = ", ".join([f"{f}=?" for f in FIELDS] + ["diperbarui_pada=?"])
    vals = [d[f] for f in FIELDS] + [now, record_id]
    with koneksi() as conn:
        conn.execute(f"UPDATE keswa SET {assignments} WHERE id=?", vals)
        conn.commit()

def ambil_data(record_id):
    with koneksi() as conn:
        return conn.execute("SELECT * FROM keswa WHERE id=?", (record_id,)).fetchone()

def semua_data(mulai=None, sampai=None):
    sql = "SELECT * FROM keswa WHERE 1=1"
    params = []
    if mulai:
        sql += " AND tanggal >= ?"
        params.append(mulai)
    if sampai:
        sql += " AND tanggal <= ?"
        params.append(sampai)
    sql += " ORDER BY tanggal DESC, id DESC"
    with koneksi() as conn:
        return conn.execute(sql, params).fetchall()

def data_terbaru(mulai=None, sampai=None):
    rows = semua_data(mulai, sampai)
    return rows[0] if rows else None

def hapus_data(record_id):
    with koneksi() as conn:
        conn.execute("DELETE FROM keswa WHERE id=?", (record_id,))
        conn.commit()

init_database()
