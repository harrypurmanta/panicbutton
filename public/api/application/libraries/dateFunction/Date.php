<?php


class Date 
{
    public function pendek($date)
	{
		$BulanIndo = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des");

		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl   = substr($date, 8, 2);

		$result = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun;
		return ($result);
	}
	public function panjang($date)
	{
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl   = substr($date, 8, 2);

		$result = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun;
		return ($result);
	}


	public function dateSlash($date)
	{
		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl   = substr($date, 8, 2);

		$result = $tgl . "/" . $bulan. "/" . $tahun;
		return ($result);
	}

	public function dateNow()
	{
		$result = date('Y-m-d H:i:s');
		return ($result);
	}
}