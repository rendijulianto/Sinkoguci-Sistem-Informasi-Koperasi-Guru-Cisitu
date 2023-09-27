<?php
use Carbon\Carbon;
class Helper {
    /**
 * Helper for convert rupiah to number
 *
 *
 */

    public static function rupiahToNumeric($rupiah)
    {
        // Remove non-numeric characters and spaces
        $numericString = preg_replace("/[^0-9]/", "", $rupiah);

        // Convert the numeric string to an integer or float
        $numericValue = (int) $numericString; // Use (float) for decimals

        // Output the numeric value
        if($numericValue == null) {
            return 0;
        } else {
            return $numericValue;
        }
    }

    /**
     * Helper for convert number to rupiah
     *
     *
     */

    public static function numericToRupiah($number)
    {
        return 'Rp. ' . number_format($number, 0, ',', '.');
    }

    /**
     * Helper for convert datetime to indonesian datetime
     *
     *
     */
    public static function dateTimeIndo($dateTime)
    {
        $date = Carbon::parse($dateTime);
        return $date->isoFormat('dddd, D MMMM Y HH:mm:ss');
    }

    /**
     * Helper for convert date to indonesian date
     *
     *
     */
    public static function dateIndo($date)
    {
        $date = Carbon::parse($date);
        return $date->isoFormat('dddd, D MMMM Y');
    }

    /**
     * Helper for convert month to indonesian month
     *
     *
     */
    public static function monthIndo($month)
    {
        $date = Carbon::parse($month);
        return $date->isoFormat('MMMM Y');
    }


    public static function terbilangRupiah($nilai)
    {
        $nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = self::terbilangRupiah($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = self::terbilangRupiah($nilai/10)." puluh". self::terbilangRupiah($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . self::terbilangRupiah($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = self::terbilangRupiah($nilai/100) . " ratus" . self::terbilangRupiah($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . self::terbilangRupiah($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = self::terbilangRupiah($nilai/1000) . " ribu" . self::terbilangRupiah($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = self::terbilangRupiah($nilai/1000000) . " juta" . self::terbilangRupiah($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = self::terbilangRupiah($nilai/1000000000) . " milyar" . self::terbilangRupiah(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = self::terbilangRupiah($nilai/1000000000000) . " trilyun" . self::terbilangRupiah(fmod($nilai,1000000000000));
		}
		return $temp;
    }

    /**
     * Helper for list of month in indonesian
     *
     *
     */
    public static function listOfMonth()
    {
        return [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];
    }

}
