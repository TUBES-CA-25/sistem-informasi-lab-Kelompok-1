<?php

/**
 * ICLABS - Base Model Class
 */

class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = getDBConnection();
    }

    /**
     * Get all records
     */
    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    /**
     * Find record by ID
     */
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Find record by column
     */
    public function findBy($column, $value)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = ?");
        $stmt->execute([$value]);
        return $stmt->fetch();
    }

    /**
     * Get records by condition
     */
    public function where($column, $value)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$column} = ?");
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }

    /**
     * Insert new record
     */
    public function insert($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($data));

        return $this->db->lastInsertId();
    }

    /**
     * Update record
     */
    public function update($id, $data)
    {
        $setParts = [];
        foreach (array_keys($data) as $key) {
            $setParts[] = "{$key} = ?";
        }
        $setClause = implode(', ', $setParts);

        $sql = "UPDATE {$this->table} SET {$setClause} WHERE id = ?";
        $values = array_values($data);
        $values[] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    /**
     * Delete record
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Execute custom query
     */
    public function query($sql, $params = [])
    {
        // 1. Siapkan statement
        $stmt = $this->db->prepare($sql);

        // 2. Eksekusi dengan parameter (otomatis binding)
        $stmt->execute($params);

        // 3. Ambil semua baris
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Execute custom query (single result)
     */
    // Cari fungsi queryOne, dan pastikan ada 'return'
    public function queryOne($sql, $params = [])
    {
        // 1. Siapkan statement
        $stmt = $this->db->prepare($sql);

        // 2. Eksekusi dengan parameter
        $stmt->execute($params);

        // 3. Ambil satu baris saja
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Count records
     */
    public function count($where = [])
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";

        if (!empty($where)) {
            $conditions = [];
            foreach (array_keys($where) as $key) {
                $conditions[] = "{$key} = ?";
            }
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($where));
        $result = $stmt->fetch();

        return (int) $result['count'];
    }
}
