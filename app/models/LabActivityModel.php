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
        $sql = "SELECT a.*, u.name as author_name 
                FROM lab_activities a
                JOIN users u ON a.created_by = u.id 
                ORDER BY a.created_at DESC";
        return $this->query($sql);
    }

    /**
     * Ambil kegiatan terbaru untuk Landing Page (Carousel/Grid Home)
     * Digunakan di: LandingController@index
     */
    public function getRecentActivities($limit = 3)
    {
        $limit = (int)$limit; // Casting ke int untuk keamanan query
        $sql = "SELECT * FROM lab_activities 
                WHERE status = 'published' 
                ORDER BY activity_date DESC, created_at DESC 
                LIMIT $limit";
        return $this->query($sql);
    }

    /**
     * Ambil kegiatan publik untuk halaman /activities
     * Digunakan di: LandingController@labActivities
     */
    public function getPublicActivities($limit = 20)
    {
        $limit = (int)$limit;
        $sql = "SELECT a.*, u.name as author_name 
                FROM lab_activities a
                JOIN users u ON a.created_by = u.id 
                WHERE a.status = 'published' 
                ORDER BY a.activity_date DESC 
                LIMIT $limit";
        return $this->query($sql);
    }

    /**
     * Hitung kegiatan yang akan datang (Upcoming)
     * Digunakan di: AdminController@dashboard
     */
    public function countUpcoming()
    {
        $today = date('Y-m-d');
        $sql = "SELECT COUNT(*) as total FROM lab_activities 
                WHERE activity_date >= ? AND status = 'published'";
        $result = $this->queryOne($sql, [$today]);
        return $result['total'];
    }

    // ==========================================
    // CRUD OPERATIONS
    // ==========================================

    public function createActivity($data)
    {
        // Set default created_by jika belum ada
        if (!isset($data['created_by'])) {
            $data['created_by'] = getUserId();
        }
        return $this->insert($data);
    }

    public function updateActivity($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteActivity($id)
    {
        return $this->delete($id);
    }
}
