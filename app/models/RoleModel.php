<?php
/**
 * ICLABS - Role Model
 */

class RoleModel extends Model {
    protected $table = 'roles';
    
    /**
     * Get role by name
     */
    public function getByName($roleName) {
        return $this->findBy('role_name', $roleName);
    }
    
    /**
     * Get all roles
     */
    public function getAllRoles() {
        return $this->all();
    }
}
