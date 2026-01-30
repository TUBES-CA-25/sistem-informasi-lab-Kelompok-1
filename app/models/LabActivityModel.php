<?php

/**
 * ICLABS - Lab Activity Model
 * Handles Blog/News/Activities data
 */
class LabActivityModel extends Model
{
    protected $table = 'lab_activities';

    /**
     * Ambil semua kegiatan (Untuk Admin List)
     */
    public function getAllActivities()
    {
        // Menggunakan LEFT JOIN agar jika user dihapus, berita tetap tampil
        $sql = "SELECT a.*, u.name as author_name 
                FROM {$this->table} a
                LEFT JOIN users u ON a.created_by = u.id 
                ORDER BY a.activity_date DESC, a.created_at DESC";
        return $this->query($sql);
    }

    /**
     * Ambil kegiatan terbaru (Sidebar Detail & Home)
     * FIXED: Menambahkan parameter $excludeId untuk menghindari duplikasi konten
     */
    public function getRecentActivities($limit = 3, $excludeId = null)
    {
        $sql = "SELECT * FROM {$this->table} ";
        $params = [];

        // Logic Exclude (Agar berita yang sedang dibuka tidak muncul di rekomendasi)
        if ($excludeId) {
            $sql .= "WHERE id != ? ";
            $params[] = $excludeId;
        }

        // Limit
        $sql .= "ORDER BY activity_date DESC, created_at DESC LIMIT " . (int)$limit;

        return $this->query($sql, $params);
    }

    /**
     * Ambil kegiatan publik untuk halaman /activities
     */
    public function getPublicActivities($limit = 20)
    {
        $limit = (int)$limit;
        // Hapus filter 'status' karena form input kita sederhana (langsung tayang)
        $sql = "SELECT a.*, u.name as author_name 
                FROM {$this->table} a
                LEFT JOIN users u ON a.created_by = u.id 
                ORDER BY a.activity_date DESC 
                LIMIT $limit";
        return $this->query($sql);
    }

    /**
     * Hitung kegiatan yang akan datang
     */
    public function countUpcoming()
    {
        $today = date('Y-m-d');
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE activity_date >= ?";
        $result = $this->queryOne($sql, [$today]);
        return $result['total'];
    }

    // ==========================================
    // CRUD OPERATIONS
    // ==========================================

    public function createActivity($data)
    {
        // Otomatis isi created_by dengan ID admin yang login
        if (!isset($data['created_by']) && function_exists('getUserId')) {
            $data['created_by'] = getUserId();
        }

        return $this->insert($data);
    }

    public function updateActivity($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Delete activity with automatic image cleanup
     * 
     * @param int $id Activity ID to delete
     * @return bool True on success, false on failure
     */
    public function deleteActivity($id)
    {
        // Delete image file if exists
        $item = $this->find($id);
        if ($item && !empty($item['image_cover'])) {
            // Only delete if not external URL
            if (strpos($item['image_cover'], 'http') !== 0) {
                $filePath = PUBLIC_PATH . $item['image_cover'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        return $this->delete($id);
    }

    /**
     * Update activity with automatic old image cleanup
     * 
     * @param int $id Activity ID to update
     * @param array $data New activity data
     * @return bool True on success, false on failure
     */
    public function updateActivityWithImageCleanup($id, $data)
    {
        // Delete old image if new one is uploaded
        if (!empty($data['image_cover'])) {
            $oldActivity = $this->find($id);
            if ($oldActivity && !empty($oldActivity['image_cover']) && $oldActivity['image_cover'] !== $data['image_cover']) {
                // Only delete if not external URL
                if (strpos($oldActivity['image_cover'], 'http') !== 0) {
                    $filePath = PUBLIC_PATH . $oldActivity['image_cover'];
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }
        }

        return $this->update($id, $data);
    }
}
