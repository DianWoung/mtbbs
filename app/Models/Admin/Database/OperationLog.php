<?php

namespace App\Models\Admin\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Admin\Database\OperationLog
 *
 * @property int $id
 * @property int $user_id
 * @property string $path
 * @property string $method
 * @property string $ip
 * @property string $input
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Admin\Database\Administrator $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\OperationLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\OperationLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\OperationLog whereInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\OperationLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\OperationLog whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\OperationLog wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\OperationLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\OperationLog whereUserId($value)
 * @mixin \Eloquent
 */
class OperationLog extends Model
{
    protected $fillable = ['user_id', 'path', 'method', 'ip', 'input'];

    public static $methodColors = [
        'GET'    => 'green',
        'POST'   => 'yellow',
        'PUT'    => 'blue',
        'DELETE' => 'red',
    ];

    public static $methods = [
        'GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH',
        'LINK', 'UNLINK', 'COPY', 'HEAD', 'PURGE',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.operation_log_table'));

        parent::__construct($attributes);
    }

    /**
     * Log belongs to users.
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(Administrator::class);
    }
}
