import sqlite3
from pathlib import Path
from datetime import datetime

BASE_DIR = Path(__file__).resolve().parent
DATA_DIR = BASE_DIR / "data"
DB_PATH = DATA_DIR / "e_keswa.db"

DATA_DIR.mkdir(parents=True, exist_ok=True)


def koneksi():
    conn = sqlite3.connect(DB_PATH)
    conn.row_factory = sqlite3.Row
    return conn


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

                dibuat_pada TEXT NOT NULL,
                diperbarui_pada TEXT NOT NULL
            )
        """)
        conn.commit()


def persen(capaian, sasaran):
    if sasaran and sasaran > 0:
        return round((capaian / sasaran) * 100, 2)
    return 0


def simpan_data(data):
    sekarang = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    spm_persen = persen(
        data["spm_capaian"],
        data["spm_sasaran"]
    )

    pelacakan_persen = persen(
        data["pelacakan_capaian"],
        data["pelacakan_sasaran"]
    )

    p3lp_persen = persen(
        data["p3lp_capaian"],
        data["p3lp_sasaran"]
    )

    skrining_persen = persen(
        data["skrining_capaian"],
        data["skrining_sasaran"]
    )

    with koneksi() as conn:

        conn.execute("""
            INSERT INTO keswa (
                tanggal,
                total_odgj_berat,
                spm_sasaran,
                spm_capaian,
                spm_persentase,
                f23,
                f20,
                manusak,
                oelatimo,
                pukdale,
                nunkurus,
                naibonat,
                obat_sasaran,
                obat_rutin,
                obat_tidak_rutin,
                obat_putus,
                odgjb_baru,
                pelacakan_sasaran,
                pelacakan_capaian,
                pelacakan_persentase,
                p3lp_sasaran,
                p3lp_capaian,
                p3lp_persentase,
                skrining_sasaran,
                skrining_capaian,
                skrining_persentase,
                kendala,
                solusi,
                rencana_tindak_lanjut,
                dibuat_pada,
                diperbarui_pada
            )
            VALUES (
                ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
            )
        """, (
            data["tanggal"],
            data["total_odgj_berat"],

            data["spm_sasaran"],
            data["spm_capaian"],
            spm_persen,

            data["f23"],
            data["f20"],

            data["manusak"],
            data["oelatimo"],
            data["pukdale"],
            data["nunkurus"],
            data["naibonat"],

            data["obat_sasaran"],
            data["obat_rutin"],
            data["obat_tidak_rutin"],
            data["obat_putus"],

            data["odgjb_baru"],

            data["pelacakan_sasaran"],
            data["pelacakan_capaian"],
            pelacakan_persen,

            data["p3lp_sasaran"],
            data["p3lp_capaian"],
            p3lp_persen,

            data["skrining_sasaran"],
            data["skrining_capaian"],
            skrining_persen,

            data["kendala"],
            data["solusi"],
            data["rencana_tindak_lanjut"],

            sekarang,
            sekarang
        ))

        conn.commit()


def update_data(record_id, data):
    sekarang = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    with koneksi() as conn:

        conn.execute("""
            UPDATE keswa SET

                tanggal=?,
                total_odgj_berat=?,

                spm_sasaran=?,
                spm_capaian=?,
                spm_persentase=?,

                f23=?,
                f20=?,

                manusak=?,
                oelatimo=?,
                pukdale=?,
                nunkurus=?,
                naibonat=?,

                obat_sasaran=?,
                obat_rutin=?,
                obat_tidak_rutin=?,
                obat_putus=?,

                odgjb_baru=?,

                pelacakan_sasaran=?,
                pelacakan_capaian=?,
                pelacakan_persentase=?,

                p3lp_sasaran=?,
                p3lp_capaian=?,
                p3lp_persentase=?,

                skrining_sasaran=?,
                skrining_capaian=?,
                skrining_persentase=?,

                kendala=?,
                solusi=?,
                rencana_tindak_lanjut=?,

                diperbarui_pada=?

            WHERE id=?
        """, (
            data["tanggal"],
            data["total_odgj_berat"],

            data["spm_sasaran"],
            data["spm_capaian"],
            persen(data["spm_capaian"], data["spm_sasaran"]),

            data["f23"],
            data["f20"],

            data["manusak"],
            data["oelatimo"],
            data["pukdale"],
            data["nunkurus"],
            data["naibonat"],

            data["obat_sasaran"],
            data["obat_rutin"],
            data["obat_tidak_rutin"],
            data["obat_putus"],

            data["odgjb_baru"],

            data["pelacakan_sasaran"],
            data["pelacakan_capaian"],
            persen(
                data["pelacakan_capaian"],
                data["pelacakan_sasaran"]
            ),

            data["p3lp_sasaran"],
            data["p3lp_capaian"],
            persen(
                data["p3lp_capaian"],
                data["p3lp_sasaran"]
            ),

            data["skrining_sasaran"],
            data["skrining_capaian"],
            persen(
                data["skrining_capaian"],
                data["skrining_sasaran"]
            ),

            data["kendala"],
            data["solusi"],
            data["rencana_tindak_lanjut"],

            sekarang,
            record_id
        ))

        conn.commit()


def ambil_data(record_id):
    with koneksi() as conn:
        return conn.execute(
            "SELECT * FROM keswa WHERE id=?",
            (record_id,)
        ).fetchone()


def semua_data(tanggal_mulai=None, tanggal_akhir=None):
    with koneksi() as conn:

        query = "SELECT * FROM keswa WHERE 1=1"
        params = []

        if tanggal_mulai:
            query += " AND tanggal >= ?"
            params.append(tanggal_mulai)

        if tanggal_akhir:
            query += " AND tanggal <= ?"
            params.append(tanggal_akhir)

        query += " ORDER BY tanggal DESC, id DESC"

        return conn.execute(
            query,
            params
        ).fetchall()


def data_terbaru(tanggal_mulai=None, tanggal_akhir=None):
    rows = semua_data(
        tanggal_mulai,
        tanggal_akhir
    )

    return rows[0] if rows else None


def hapus_data(record_id):
    with koneksi() as conn:
        conn.execute(
            "DELETE FROM keswa WHERE id=?",
            (record_id,)
        )
        conn.commit()


init_database()
