<?php

namespace App\Models\Admin\Database;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

/**
 * Class Menu.
 *
 * @property int $id
 * @method where($parent_id, $id)
 * @property int $parent_id
 * @property int $order
 * @property string $title
 * @property string $icon
 * @property string|null $uri
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Admin\Database\Menu[] $children
 * @property-read \App\Models\Admin\Database\Menu $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Encore\Admin\Auth\Database\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Menu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Menu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin\Database\Menu whereUri($value)
 * @mixin \Eloquent
 */
class Menu extends Model
{
    use AdminBuilder, ModelTree {
        ModelTree::boot as treeBoot;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'order', 'title', 'icon', 'uri'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.menu_table'));

        parent::__construct($attributes);
    }

    /**
     * A Menu belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        $pivotTable = config('admin.database.role_menu_table');

        $relatedModel = config('admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'menu_id', 'role_id');
    }

    /**
     * @return array
     */
    public function allNodes() : array
    {
        $orderColumn = DB::getQueryGrammar()->wrap($this->orderColumn);
        $byOrder = $orderColumn.' = 0,'.$orderColumn;

        return static::with('roles')->orderByRaw($byOrder)->get()->toArray();
    }

    /**
     * Detach models from the relationship.
     *
     * @return void
     */
    protected static function boot()
    {
        static::treeBoot();

        static::deleting(function ($model) {
            $model->roles()->detach();
        });
    }
}
