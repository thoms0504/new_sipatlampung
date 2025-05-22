<?php
namespace App\Models\ModulUtama;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 
        'email', 
        'password', 
        'remember_token', 
        'is_active', 
        'role',
        'nama_lengkap',
        'google_id',
        'avatar'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    // Method untuk menghash password sebelum disimpan ke database
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    // Method untuk mengambil data pengguna berdasarkan username atau email
    public function getData($parameter)
    {
        $builder = $this->table($this->table);
        $builder->where('username', $parameter);
        $builder->orWhere('email', $parameter);
        $query = $builder->get();
        return $query->getRowArray();
    }

    // Method untuk mengupdate data pengguna
    public function updateData($data)
    {
        return $this->save($data);
    }

    // Method untuk mencari pengguna berdasarkan username
    public function findUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    // Method untuk mencari pengguna berdasarkan Google ID
    public function findByGoogleId($googleId)
    {
        return $this->where('google_id', $googleId)->first();
    }

    // Method untuk membuat atau mengupdate pengguna berdasarkan data Google
    public function createOrUpdateGoogleUser($userInfo)
    {
        $existingUser = $this->where('email', $userInfo['email'])->first();

        $userData = [
            'username' => $userInfo['username'] ?? $userInfo['email'],
            'email' => $userInfo['email'],
            'google_id' => $userInfo['google_id'],
            'nama_lengkap' => $userInfo['nama_lengkap'] ?? '',
            'role' => $existingUser['role'] ?? 'user',
            'is_active' => 1,
            'avatar' => $userInfo['avatar'] ?? null
        ];

        if ($existingUser) {
            $userData['id'] = $existingUser['id'];
            $this->save($userData);
            return $this->find($existingUser['id']);
        }

        $this->insert($userData);
        return $this->findByGoogleId($userInfo['google_id']);
    }

    public function getUser($id)
    {
        return $this->db->table('users')->getWhere(['id' => $id])->getRowArray();
    }
}