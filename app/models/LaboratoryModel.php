<?php

/**
 * ICLABS - Laboratory Model
 * Handles Labs Data & Multiple Photos
 */
class LaboratoryModel extends Model
{
    protected $table = 'laboratories';

    // Ambil semua lab (untuk List Admin & Landing Page)
    public function getAllLaboratories()
    {
        $this->table = 'laboratories'; // Pastikan tabel benar
        $labs = $this->query("SELECT * FROM laboratories");

        // Inject data foto ke setiap lab
        foreach ($labs as &$lab) {
            $lab['photos'] = $this->getLabPhotos($lab['id']);
            // Set foto utama (ambil foto pertama jika ada, atau null)
            $lab['primary_photo'] = !empty($lab['photos']) ? $lab['photos'][0]['file_path'] : null;
        }
        return $labs;
    }

    // Cari Lab by ID
    public function find($id)
    {
        $this->table = 'laboratories';
        return $this->queryOne("SELECT * FROM laboratories WHERE id = ?", [$id]);
    }

    // ==========================================
    // MULTIPLE PHOTOS LOGIC (FIXED)
    // ==========================================

    // Ambil semua foto milik lab tertentu
    public function getLabPhotos($labId)
    {
        return $this->query("SELECT * FROM lab_photos WHERE laboratory_id = ?", [$labId]);
    }

    // Simpan 1 foto
    public function addLabPhoto($labId, $filePath)
    {
        // FIX: Ubah tabel target secara dinamis sebelum insert
        $this->table = 'lab_photos';

        return $this->insert([
            'laboratory_id' => $labId,
            'file_path' => $filePath
        ]);
    }

    // Hapus foto spesifik
    public function deleteLabPhoto($photoId)
    {
        // FIX: Ubah tabel target secara dinamis sebelum delete
        $this->table = 'lab_photos';

        return $this->delete($photoId);
    }

    // ==========================================
    // CRUD LABORATORIES (MAIN)
    // ==========================================

    public function createLaboratory($data)
    {
        $this->table = 'laboratories';
        return $this->insert($data);
    }

    public function updateLaboratory($id, $data)
    {
        $this->table = 'laboratories';
        return $this->update($id, $data);
    }

    public function deleteLaboratory($id)
    {
        $this->table = 'laboratories';
        return $this->delete($id);
    }

    // Hitung total lab (untuk Dashboard)
    public function countLaboratories()
    {
        $this->table = 'laboratories';
        $result = $this->queryOne("SELECT COUNT(*) as total FROM laboratories");
        return $result['total'];
    }

    // Cari ID Lab berdasarkan Nama (Case Insensitive & Mirip)
    public function findIdByName($name)
    {
        $this->table = 'laboratories';
        // Mencari yang namanya mirip, misal "Lab IoT" cocok dengan "IoT"
        $sql = "SELECT id FROM laboratories WHERE lab_name LIKE ? LIMIT 1";
        $result = $this->queryOne($sql, ['%' . $name . '%']);
        return $result ? $result['id'] : null;
    }

    // Ambil semua user (untuk hitung total di dashboard)
    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        return $this->query($sql);
    }

    // Ambil semua data laboratorium untuk statistik dashboard
    public function getAllLabs()
    {
        $sql = "SELECT * FROM laboratories";
        return $this->query($sql);
    }
}
