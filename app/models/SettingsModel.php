<?php

class SettingsModel extends Model
{
    protected $table = 'app_settings';

    /**
     * Ambil nilai setting berdasarkan key
     */
    public function get($key, $default = '')
    {
        // Pastikan tabel ada dulu (safety check)
        $sql = "SELECT setting_value FROM {$this->table} WHERE setting_key = ?";
        $result = $this->queryOne($sql, [$key]);
        return $result ? $result['setting_value'] : $default;
    }

    /**
     * Simpan atau Update nilai setting
     */
    public function save($key, $value)
    {
        $sql = "INSERT INTO {$this->table} (setting_key, setting_value) VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE setting_value = ?";
        return $this->query($sql, [$key, $value, $value]);
    }
}
