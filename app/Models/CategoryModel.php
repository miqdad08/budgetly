<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array'; // Bisa juga 'object'
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = ['user_id', 'name', 'type', 'icon', 'color'];
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'type' => 'required|in_list[income,expense]',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // --------------------------------------------------------------------

    /**
     * Mendapatkan kategori yang dapat digunakan oleh seorang user
     * (kategori global + kategori milik user sendiri)
     *
     * @param int|null $userId ID user, jika null hanya kategori global
     * @param string|null $type Filter berdasarkan tipe (income/expense)
     * @return array
     */
    public function getUserCategories($userId = null, $type = null)
    {
        $this->select('categories.*')
            ->groupStart()
            ->where('user_id', null) // global categories
            ->orWhere('user_id', $userId) // user's own categories
            ->groupEnd();

        if ($type && in_array($type, ['income', 'expense'])) {
            $this->where('type', $type);
        }

        return $this->findAll();
    }

    // --------------------------------------------------------------------

    /**
     * Mendapatkan kategori global saja (user_id = null)
     *
     * @param string|null $type
     * @return array
     */
    public function getGlobalCategories($type = null)
    {
        $this->where('user_id', null);

        if ($type && in_array($type, ['income', 'expense'])) {
            $this->where('type', $type);
        }

        return $this->findAll();
    }

    // --------------------------------------------------------------------

    /**
     * Mendapatkan kategori milik user tertentu saja
     *
     * @param int $userId
     * @param string|null $type
     * @return array
     */
    public function getUserOwnCategories(int $userId, $type = null)
    {
        $this->where('user_id', $userId);

        if ($type && in_array($type, ['income', 'expense'])) {
            $this->where('type', $type);
        }

        return $this->findAll();
    }
}
