<?php
/**
 * ICLABS - Laboratory Model
 */

class LaboratoryModel extends Model {
    protected $table = 'laboratories';
    
    /**
     * Get all laboratories
     */
    public function getAllLaboratories() {
        return $this->all();
    }
    
    /**
     * Get laboratory by ID
     */
    public function getLaboratory($id) {
        return $this->find($id);
    }
    
    /**
     * Create laboratory
     */
    public function createLaboratory($data) {
        return $this->insert($data);
    }
    
    /**
     * Update laboratory
     */
    public function updateLaboratory($id, $data) {
        return $this->update($id, $data);
    }
    
    /**
     * Delete laboratory
     */
    public function deleteLaboratory($id) {
        return $this->delete($id);
    }
    
    /**
     * Count laboratories
     */
    public function countLaboratories() {
        return $this->count();
    }
}
