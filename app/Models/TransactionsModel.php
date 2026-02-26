<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionsModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = ['user_id', 'type', 'amount', 'category_id', 'account_id', 'date', 'notes'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'user_id' => 'required|integer',
        'type' => 'required|in_list[income,expense]',
        'amount' => 'required|numeric|greater_than[0]',
        'category_id' => 'required|integer',
        'account_id' => 'required|integer',
        'date' => 'required|valid_date',
        'notes' => 'permit_empty|string',
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $afterInsert = ['afterInsertTransaction'];
    protected $afterUpdate = []; // Untuk update bisa ditambahkan nanti
    protected $afterDelete = ['updateAccountBalanceAfterDelete'];

    // --------------------------------------------------------------------
    // Relationships & Query Scopes
    // --------------------------------------------------------------------
    public function withCategory()
    {
        $this->select('transactions.*, categories.name as category_name, categories.type as category_type')->join('categories', 'categories.id = transactions.category_id', 'left');
        return $this;
    }

    public function withAccount()
    {
        $this->select('transactions.*, accounts.name as account_name, accounts.balance as account_balance')->join('accounts', 'accounts.id = transactions.account_id', 'left');
        return $this;
    }

    public function withUser()
    {
        $this->select('transactions.*, users.name as user_name, users.email as user_email')->join('users', 'users.id = transactions.user_id', 'left');
        return $this;
    }

    public function forUser($userId)
    {
        return $this->where('transactions.user_id', $userId);
    }

    public function ofType($type)
    {
        return $this->where('type', $type);
    }

    public function betweenDates($startDate, $endDate)
    {
        return $this->where('date >=', $startDate)->where('date <=', $endDate);
    }

    public function forAccount($accountId)
    {
        return $this->where('account_id', $accountId);
    }

    public function forCategory($categoryId)
    {
        return $this->where('category_id', $categoryId);
    }

    // --------------------------------------------------------------------
    // Callback Methods
    // --------------------------------------------------------------------
    protected function afterInsertTransaction(array $data)
    {
        if (!isset($data['id']) && !isset($data['data']['id'])) {
            return false;
        }

        $transactionId = $data['id'] ?? $data['data']['id'];
        $transaction = $this->find($transactionId);
        if (!$transaction) {
            return false;
        }

        $accountModel = new AccountsModel();
        $accountModel->updateBalanceByTransactionType($transaction['account_id'], $transaction['type'], $transaction['amount']);

        return true;
    }

    protected function updateAccountBalanceAfterDelete(array $data)
    {
        // Untuk soft delete, tidak perlu mengubah balance
        // Jika ingin hard delete, tambahkan logika di sini
        return true;
    }

    // --------------------------------------------------------------------
    // Manual Balance Adjustment
    // --------------------------------------------------------------------
    public function reverseBalance($transactionId)
    {
        $transaction = $this->find($transactionId);
        if (!$transaction) {
            return false;
        }

        $accountModel = new AccountsModel();
        if ($transaction['type'] == 'income') {
            return $accountModel->decreaseBalance($transaction['account_id'], $transaction['amount']);
        } else {
            return $accountModel->increaseBalance($transaction['account_id'], $transaction['amount']);
        }
    }

    public function deleteTransaction($id)
    {
        $transaction = $this->find($id);
        if (!$transaction) {
            return false;
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Hard delete
        $this->delete($id, true);

        $accountModel = new AccountsModel();
        if ($transaction['type'] == 'income') {
            $accountModel->decreaseBalance($transaction['account_id'], $transaction['amount']);
        } else {
            $accountModel->increaseBalance($transaction['account_id'], $transaction['amount']);
        }

        $db->transComplete();
        return true;
    }
}
