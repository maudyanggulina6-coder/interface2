<?php

// 1. Membuat Interface MetodePembayaran
interface MetodePembayaran {
    public function prosesBayar(float $jumlah, string $keterangan): bool;
    public function getNamaMetode(): string;
}

// 2 & 3. Class TransferBank
class TransferBank implements MetodePembayaran {
    private string $nomorRekening;

    public function __construct(string $nomorRekening) {
        $this->nomorRekening = $nomorRekening;
    }

    public function getNamaMetode(): string {
        return "Transfer Bank";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = 0; // 0%
        $total = $jumlah + ($jumlah * $biayaAdmin);

        echo "--- Rincian Pembayaran ---\n";
        echo "Metode          : " . $this->getNamaMetode() . "\n";
        echo "No. Rekening    : " . $this->nomorRekening . "\n";
        echo "Keterangan      : " . $keterangan . "\n";
        echo "Jumlah Awal     : " . formatRupiah($jumlah) . "\n";
        echo "Biaya Admin (0%): " . formatRupiah($biayaAdmin) . "\n";
        echo "Total Pembayaran: " . formatRupiah($total) . "\n\n";

        return true;
    }
}

// 2 & 3. Class QRIS
class QRIS implements MetodePembayaran {
    public function getNamaMetode(): string {
        return "QRIS";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = $jumlah * 0.007; // 0.7%
        $total = $jumlah + $biayaAdmin;

        echo "--- Rincian Pembayaran ---\n";
        echo "Metode          : " . $this->getNamaMetode() . "\n";
        echo "Keterangan      : " . $keterangan . "\n";
        echo "Jumlah Awal     : " . formatRupiah($jumlah) . "\n";
        echo "Biaya Admin (0.7%): " . formatRupiah($biayaAdmin) . "\n";
        echo "Total Pembayaran: " . formatRupiah($total) . "\n\n";

        return true;
    }
}

// 2 & 3. Class KartuKredit
class KartuKredit implements MetodePembayaran {
    private string $nomorKartu;

    public function __construct(string $nomorKartu) {
        // Menyimpan nomor kartu, nantinya hanya ditampilkan 4 digit terakhir
        $this->nomorKartu = $nomorKartu;
    }

    public function getNamaMetode(): string {
        return "Kartu Kredit";
    }

    public function prosesBayar(float $jumlah, string $keterangan): bool {
        $biayaAdmin = $jumlah * 0.025; // 2.5%
        $total = $jumlah + $biayaAdmin;

        // Mengambil 4 digit terakhir nomor kartu
        $empatDigitTerakhir = substr($this->nomorKartu, -4);
        $maskedKartu = "****-****-****-" . $empatDigitTerakhir;

        echo "--- Rincian Pembayaran ---\n";
        echo "Metode          : " . $this->getNamaMetode() . "\n";
        echo "No. Kartu       : " . $maskedKartu . "\n";
        echo "Keterangan      : " . $keterangan . "\n";
        echo "Jumlah Awal     : " . formatRupiah($jumlah) . "\n";
        echo "Biaya Admin (2.5%): " . formatRupiah($biayaAdmin) . "\n";
        echo "Total Pembayaran: " . formatRupiah($total) . "\n\n";

        return true;
    }
}

// 5. Fungsi Helper untuk Format Rupiah (Format Indonesia)
function formatRupiah(float $angka): string {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// --- CONTOH PENGGUNAAN / DEMO ---

$pembayaranList = [
    new TransferBank("1234567890"),
    new QRIS(),
    new KartuKredit("4111222233334444")
];

$jumlahTransaksi = 500000.0;
$keteranganTransaksi = "Pembelian Barang Elektronik";

foreach ($pembayaranList as $metode) {
    $metode->prosesBayar($jumlahTransaksi, $keteranganTransaksi);
}