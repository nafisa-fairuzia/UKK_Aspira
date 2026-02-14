<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates a stored function `fn_aspirasi_status` and a stored procedure
     * `sp_get_latest_pengaduan_others(p_limit INT, p_nis VARCHAR(20))`.
     * The procedure returns latest `input_aspirasi` from other students.
     */
    public function up(): void
    {
        // drop if exists then create function
        DB::unprepared('DROP FUNCTION IF EXISTS `fn_aspirasi_status`;');

        DB::unprepared(
            <<<'SQL'
CREATE FUNCTION `fn_aspirasi_status`(p_id_input INT)
RETURNS VARCHAR(20) DETERMINISTIC
BEGIN
  DECLARE v_status VARCHAR(20);
  SELECT COALESCE(asp.status, 'Menunggu') INTO v_status
  FROM aspirasi asp
  WHERE asp.id_input_aspirasi = p_id_input
  LIMIT 1;
  RETURN v_status;
END
SQL
        );

        // drop if exists then create procedure
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_latest_pengaduan_others`;');

        DB::unprepared(
            <<<'SQL'
CREATE PROCEDURE `sp_get_latest_pengaduan_others`(IN p_limit INT, IN p_nis VARCHAR(20))
BEGIN
  SELECT
    ia.id_pelaporan,
    ia.nis,
    s.nama AS siswa_nama,
    k.ket_kategori AS kategori_nama,
    ia.lokasi,
    ia.ket AS deskripsi,
    ia.gambar,
    fn_aspirasi_status(ia.id_pelaporan) AS status,
    ia.created_at
  FROM input_aspirasi ia
  JOIN siswa s ON s.nis = ia.nis
  LEFT JOIN kategori k ON k.id_kategori = ia.id_kategori
  WHERE ia.nis <> p_nis
  ORDER BY ia.created_at DESC
  LIMIT p_limit;
END
SQL
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS `sp_get_latest_pengaduan_others`;');
        DB::unprepared('DROP FUNCTION IF EXISTS `fn_aspirasi_status`;');
    }
};
