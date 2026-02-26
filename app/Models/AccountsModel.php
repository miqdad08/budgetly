<?php
// app/Models/AccountsModel.php

namespace App\Models;

use CodeIgniter\Model;

class AccountsModel extends Model
{
    protected $table            = 'accounts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['user_id', 'name', 'type', 'balance'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Mengambil semua akun milik user tertentu (tidak termasuk global)
     */
    public function getUserAccounts($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }

    // Method untuk update saldo (tetap sama)
    public function updateBalanceByTransactionType(int $accountId, string $type, float $amount)
    {
        if ($type === 'income') {
            return $this->increaseBalance($accountId, $amount);
        } else {
            return $this->decreaseBalance($accountId, $amount);
        }
    }

    public function increaseBalance(int $accountId, float $amount)
    {
        return $this->set('balance', 'balance + ' . (float) $amount, false)
                    ->where('id', $accountId)
                    ->update();
    }

    public function decreaseBalance(int $accountId, float $amount)
    {
        return $this->set('balance', 'balance - ' . (float) $amount, false)
                    ->where('id', $accountId)
                    ->update();
    }
}