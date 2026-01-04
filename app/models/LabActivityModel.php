<?php

class LabActivityModel extends Model
{
    protected $table = 'lab_activities';

    /**
     * Ambil semua kegiatan (untuk Admin List)
     * Diurutkan dari yang terbaru
     */
    public function getAllActivities()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY activity_date DESC, created_at DESC";
        return $this->query($sql);
    }

    /**
     * Ambil kegiatan untuk Halaman Depan (Public Landing Page)
     */
    public function getPublicActivities($limit = 6)
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY activity_date DESC LIMIT ?";
        return $this->query($sql, [$limit]);
    }

    /**
     * Cari satu kegiatan berdasarkan ID
     */
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $result = $this->query($sql, [$id]);

        // Mengembalikan baris pertama atau false jika kosong
        return isset($result[0]) ? $result[0] : false;
    }

    /**
     * Hitung kegiatan yang akan datang
     */
    public function countUpcoming()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE activity_date >= CURDATE()";
        $result = $this->query($sql);
        return isset($result[0]['total']) ? $result[0]['total'] : 0;
    }

    /**
     * Tambah Kegiatan Baru
     */
    public function createActivity($data)
    {
        // Tambahkan data sistem otomatis (Pembuat & Waktu)
        $data['created_by'] = $_SESSION['user_id'] ?? 0;
        $data['created_at'] = date('Y-m-d H:i:s');

        // Menggunakan method bawaan framework Anda (insert)
        return $this->insert($data);
    }

    /**
     * Update Kegiatan
     */
    public function updateActivity($id, $data)
    {
        // Menggunakan method bawaan framework Anda (update)
        return $this->update($id, $data);
    }

    /**
     * Hapus Kegiatan
     */
    public function deleteActivity($id)
    {
        // Menggunakan method bawaan framework Anda (delete)
        return $this->delete($id);
    }
}
