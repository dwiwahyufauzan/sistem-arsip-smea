<?php

namespace App\Services;

use App\Models\PengajuanLegalisir;

class NotificationService
{
    /**
     * Format nomor HP Indonesia ke format internasional (62xxxx)
     */
    public function formatPhoneNumber(string $phoneNumber): string
    {
        // Hapus karakter non-digit
        $clean = preg_replace('/[^0-9]/', '', $phoneNumber);

        if (str_starts_with($clean, '0')) {
            return '62'.substr($clean, 1);
        }

        if (str_starts_with($clean, '62')) {
            return $clean;
        }

        return '62'.$clean;
    }

    /**
     * Buat URL chat WhatsApp resmi dengan teks template
     */
    public function generateWhatsAppUrl(string $phoneNumber, string $message): string
    {
        $target = $this->formatPhoneNumber($phoneNumber);
        $encoded = urlencode(trim($message));

        return "https://api.whatsapp.com/send?phone={$target}&text={$encoded}";
    }

    /**
     * Susun pesan notifikasi resmi status legalisir ke pemohon
     */
    public function getLegalisirNotificationMessage(PengajuanLegalisir $pengajuan): string
    {
        $statusLabels = [
            'menunggu_verifikasi' => 'Menunggu Verifikasi Staf Tata Usaha',
            'diverifikasi' => 'Terverifikasi oleh Tata Usaha',
            'menunggu_approval_kepsek' => 'Sedang Menunggu Pengesahan Kepala Sekolah',
            'disetujui_kepsek' => 'Telah Disahkan oleh Kepala Sekolah',
            'sedang_diproses' => 'Sedang Diproses & Distempel Resmi',
            'siap_diambil' => 'SIAP DIAMBIL di Ruang Tata Usaha SMKN 1 Subang',
            'selesai' => 'Berkas Telah Selesai Diambil',
            'ditolak' => 'Pengajuan Tidak Dapat Diterima / Ditolak',
        ];

        $statusText = $statusLabels[$pengajuan->status] ?? ucfirst(str_replace('_', ' ', $pengajuan->status));
        $namaDokumen = ucfirst(str_replace('_', ' ', $pengajuan->jenis_dokumen));
        $tanggalAmbil = $pengajuan->tanggal_siap_ambil ? $pengajuan->tanggal_siap_ambil->format('d/m/Y') : '-';

        $msg = "*PEMBERITAHUAN LAYANAN LEGALISIR ONLINE*\n";
        $msg .= "*SMK NEGERI 1 SUBANG*\n";
        $msg .= "----------------------------------------\n\n";
        $msg .= "Yth. Sdr/i *{$pengajuan->nama_pemohon}*,\n\n";
        $msg .= "Kami menginformasikan bahwa pengajuan legalisir Anda dengan rincian:\n";
        $msg .= "• *No. Pengajuan:* {$pengajuan->nomor_pengajuan}\n";
        $msg .= "• *Dokumen:* {$namaDokumen} ({$pengajuan->jumlah_lembar} Lembar)\n";
        $msg .= "• *Status Terkini:* *{$statusText}*\n\n";

        if ($pengajuan->status === 'siap_diambil') {
            $msg .= "✅ *Berkas fisik legalisir telah siap diambil.*\n";
            $msg .= "Silakan datang ke *Ruang Tata Usaha SMKN 1 Subang* pada jam kerja dinas (Senin - Jumat, 08.00 - 15.00 WIB) dengan membawa:\n";
            $msg .= "1. Bukti Tanda Terima / No. Pengajuan: *{$pengajuan->nomor_pengajuan}*\n";
            $msg .= "2. Dokumen Asli sebagai pencocokan fisik.\n\n";
        } elseif ($pengajuan->status === 'ditolak') {
            $msg .= '⚠️ *Catatan Petugas:* '.($pengajuan->catatan_petugas ?? 'Dokumen scan tidak terbaca jelas atau tidak sesuai ketentuan.')."\n\n";
            $msg .= "Silakan ajukan permohonan ulang dengan berkas dokumen yang telah diperbaiki.\n\n";
        } elseif ($pengajuan->catatan_petugas) {
            $msg .= "Catatan: {$pengajuan->catatan_petugas}\n\n";
        }

        $msg .= "Anda juga dapat memantau status secara langsung di tautan:\n";
        $msg .= route('legalisir.tracking', ['nomor_pengajuan' => $pengajuan->nomor_pengajuan]);
        $msg .= "\n\nTerima kasih.\n_Subbag Tata Usaha SMKN 1 Subang_";

        return $msg;
    }
}
