<?php
// ========================================
// 1. MODEL: App/Models/UserModel.php
// ========================================
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'm_users';
    protected $primaryKey = 'id_user';
    protected $allowedFields = [
        'full_name',
        'username',
        'password',
        'email',
        'role'
    ];
    protected $useTimestamps = false;
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    // Hash password sebelum insert/update
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
    
    // Get all users with pagination
    public function getUsersPaginated($perPage = 10)
    {
        return $this->orderBy('id_user', 'DESC')->paginate($perPage);
    }
    
    // Get users by role
    public function getUsersByRole($role)
    {
        return $this->where('role', $role)->findAll();
    }
    
    // Check if username exists
    public function usernameExists($username, $excludeId = null)
    {
        $builder = $this->where('username', $username);
        if ($excludeId) {
            $builder->where('id_user !=', $excludeId);
        }
        return $builder->first() !== null;
    }
    
    // Check if email exists
    public function emailExists($email, $excludeId = null)
    {
        $builder = $this->where('email', $email);
        if ($excludeId) {
            $builder->where('id_user !=', $excludeId);
        }
        return $builder->first() !== null;
    }
    
    // Count users by role
    public function countByRole()
    {
        return $this->select('role, COUNT(*) as total')
                    ->groupBy('role')
                    ->findAll();
    }
    
    // Search users
    public function searchUsers($keyword)
    {
        return $this->like('full_name', $keyword)
                    ->orLike('username', $keyword)
                    ->orLike('email', $keyword)
                    ->findAll();
    }
}