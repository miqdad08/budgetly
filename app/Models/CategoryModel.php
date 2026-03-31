<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array'; 
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

    public function getGlobalCategories($type = null)
    {
        $this->where('user_id', null);

        if ($type && in_array($type, ['income', 'expense'])) {
            $this->where('type', $type);
        }

        return $this->findAll();
    }

    // --------------------------------------------------------------------

    public function getUserOwnCategories(int $userId, $type = null)
    {
        $this->where('user_id', $userId);

        if ($type && in_array($type, ['income', 'expense'])) {
            $this->where('type', $type);
        }

        return $this->findAll();
    }
}
