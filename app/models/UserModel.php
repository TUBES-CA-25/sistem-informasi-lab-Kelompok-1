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
}