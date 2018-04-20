<?php

namespace App\Models\Admin\Database;

use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Administrator.
 *
 * @property Role[] $roles
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $avatar
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Encore\Admin\Auth\Database\Permission[] $permissions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Administrator whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Administrator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Administrator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Administrator whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Administrator wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Administrator whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Administrator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Administrator whereUsername($value)
 * @mixin \Eloquent
 */
class Administrator extends Model implements AuthenticatableContract
{
    use Authenticatable, AdminBuilder, HasPermissions;

    protected $fillable = ['username', 'password', 'name', 'avatar'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.users_table'));

        parent::__construct($attributes);
    }
}
