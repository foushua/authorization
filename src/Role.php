<?php

namespace Foushua\Authorization;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description', 'editable', 'removable'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'editable' => 'boolean',
        'removable' => 'boolean',
    ];

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if ($connection = Config::get('authorization.connection')) {
            $this->connection = $connection;
        }
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Check if this role is removable before deleting it..
        static::deleting(function ($role) {
            if (! $role->removable) {
                throw new Exception(__('This role cannot be deleted.'));
            }
        });

        // Check if this role is editable before updating it..
        static::updating(function ($role) {
            if (! $role->editable) {
                throw new Exception('This role cannot be updated.');
            }
        });
    }

    /**
     * Return all users with theses role.
     *
     * @return mixed
     */
    public function users()
    {
        return $this->hasMany(Config::get('auth.providers.users.model'));
    }
}
