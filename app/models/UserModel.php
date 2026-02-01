<?php

/**
 * ICLABS - User Model
 */

class UserModel extends Model
{
    protected $table = 'users';

    /**
     * Get user by email
     */
    public function getByEmail($email)
    {
        return $this->findBy('email', $email);
    }

    /**
     * Get user with role
     */
    public function getUserWithRole($userId)
    {
        $sql = "SELECT u.*, r.role_name 
                FROM users u 
                JOIN roles r ON u.role_id = r.id 
                WHERE u.id = ?";
        return $this->queryOne($sql, [$userId]);
    }

    /**
     * Get all users with roles
     */
    public function getAllWithRoles()
    {
        $sql = "SELECT u.*, r.role_name 
                FROM users u 
                JOIN roles r ON u.role_id = r.id 
                ORDER BY u.created_at DESC";
        return $this->query($sql);
    }

    /**
     * Get users by role
     */
    public function getUsersByRole($roleId)
    {
        return $this->where('role_id', $roleId);
    }


    public function getUsersByRoleName($roleName)
    {
        // Hapus "AND u.status = 'active'" jika ingin memunculkan semua user (termasuk yang tidak aktif) untuk testing
        $sql = "SELECT u.*, r.role_name 
                FROM users u 
                JOIN roles r ON u.role_id = r.id 
                WHERE r.role_name = ? 
                ORDER BY u.name ASC";
        return $this->query($sql, [$roleName]);
    }

    /**
     * Get active users by role
     */
    public function getActiveUsersByRole($roleId)
    {
        $sql = "SELECT * FROM users WHERE role_id = ? AND status = 'active'";
        return $this->query($sql, [$roleId]);
    }

    /**
     * Create user
     */
    public function createUser($data)
    {
        $data['password'] = hashPassword($data['password']);
        $data['status'] = $data['status'] ?? 'active';
        $data['created_at'] = date('Y-m-d H:i:s');

        return $this->insert($data);
    }

    /**
     * Update user
     */
    public function updateUser($userId, $data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = hashPassword($data['password']);
        } else {
            unset($data['password']);
        }

        return $this->update($userId, $data);
    }

    /**
     * Verify login
     */
    public function verifyLogin($email, $password)
    {
        $user = $this->getByEmail($email);

        if (!$user) {
            return false;
        }

        if (!verifyPassword($password, $user['password'])) {
            return false;
        }

        if ($user['status'] !== 'active') {
            return false;
        }

        return $user;
    }

    /**
     * Count users by role
     */
    public function countByRole($roleId)
    {
        return $this->count(['role_id' => $roleId]);
    }

    public function getAllUsersRaw()
    {
        $sql = "SELECT u.*, r.role_name 
                FROM users u 
                JOIN roles r ON u.role_id = r.id 
                ORDER BY u.name ASC";

        $stmt = $this->db->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cari User ID berdasarkan Nama Lengkap (untuk mapping import jadwal)
    public function findByName($name)
    {
        // Bersihkan nama dari spasi berlebih
        $cleanName = trim($name);
        $sql = "SELECT * FROM users WHERE name LIKE ? LIMIT 1";
        $result = $this->queryOne($sql, [$cleanName]);
        return $result; // Kembalikan full row agar kita bisa ambil fotonya
    }







    // Hitung User per Role (Untuk Grafik Donat)
    public function getUserRoleStats()
    {
        $sql = "SELECT r.role_name, COUNT(u.id) as total
                FROM users u
                JOIN roles r ON u.role_id = r.id
                GROUP BY r.id";
        return $this->query($sql);
    }

    // Ambil semua user (untuk hitung total di dashboard)
    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        return $this->query($sql);
    }



    // Ambil user dengan Pagination & Pencarian
    // Ambil user dengan Pagination & Pencarian
    public function getUsersPaginated($keyword = null, $limit = 10, $offset = 0)
    {
        $sql = "SELECT u.*, r.role_name 
                FROM users u 
                JOIN roles r ON u.role_id = r.id";

        $params = [];

        if ($keyword) {
            $sql .= " WHERE u.name LIKE :keyword OR u.email LIKE :keyword";
            $params['keyword'] = "%$keyword%";
        }

        $sql .= " ORDER BY u.created_at DESC LIMIT $limit OFFSET $offset";

        return $this->query($sql, $params);
    }

    public function countTotalUsers($keyword = null)
    {
        $sql = "SELECT COUNT(*) as total FROM users u";
        $params = [];

        if ($keyword) {
            $sql .= " WHERE u.name LIKE :keyword OR u.email LIKE :keyword";
            $params['keyword'] = "%$keyword%";
        }

        $result = $this->queryOne($sql, $params);
        return $result['total'];
    }
}
