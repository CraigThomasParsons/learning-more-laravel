<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $fullName
 * @property integer $user_id
 * @property int $role_id
 * @property boolean $active
 * @property string $role
 * @property string $created_at
 * @property string $updated_at
 */
class Person extends Model
{
    use HasFactory;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['fullName', 'user_id', 'role_id', 'active', 'role', 'created_at', 'updated_at'];

    /**
     * Take the array from the client call of get_users and popluate this object of person with it.
     */
    public function populateWithTestRailUserData(array $userData) {
        $this->user_id = $userData['id'];
        $this->role_id = $userData['role_id'];
        $this->role = $userData['role'];
        $this->fullName = $userData['name'];
        $this->active = $userData['is_active'];
    }
}
