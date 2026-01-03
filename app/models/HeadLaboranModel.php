<?php

/**
 * ICLABS - Head Laboran Model
 */

class HeadLaboranModel extends Model
{
    protected $table = 'head_laboran';

    /**
     * Get all head laboran with user info
     */
    public function getAllWithUser()
    {
        $sql = "SELECT h.*, u.name, u.email 
                FROM head_laboran h 
                JOIN users u ON h.user_id = u.id 
                ORDER BY h.created_at DESC";
        return $this->query($sql);
    }

    /**
     * Get all data for Presence Page (Sorted by Status)
     * [NEW METHOD] Mengambil data lengkap untuk halaman Management Presence
     */
    public function getAllPresence()
    {
        $sql = "SELECT h.*, u.name, u.email 
                FROM head_laboran h 
                JOIN users u ON h.user_id = u.id 
                ORDER BY 
                    CASE WHEN h.status = 'active' THEN 1 ELSE 2 END, -- Yang hadir di atas
                    h.position ASC";
        return $this->query($sql);
    }

    /**
     * Get active head laboran
     */
    public function getActiveHeadLaboran()
    {
        $sql = "SELECT h.*, u.name, u.email 
                FROM head_laboran h 
                JOIN users u ON h.user_id = u.id 
                WHERE h.status = 'active' 
                ORDER BY h.created_at DESC";
        return $this->query($sql);
    }

    /**
     * Get head laboran by user
     */
    public function getByUser($userId)
    {
        return $this->findBy('user_id', $userId);
    }

    /**
     * Create head laboran
     */
    public function createHeadLaboran($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->insert($data);
    }

    /**
     * Update head laboran
     */
    public function updateHeadLaboran($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Delete head laboran
     */
    public function deleteHeadLaboran($id)
    {
        return $this->delete($id);
    }

    /**
     * Check if user is already head laboran
     */
    public function isHeadLaboran($userId)
    {
        $result = $this->getByUser($userId);
        return !empty($result);
    }

    /**
     * Count active head laboran
     */
    public function countActive()
    {
        return $this->count(['status' => 'active']);
    }
}
