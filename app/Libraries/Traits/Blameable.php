<?php

namespace App\Libraries\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

trait Blameable
{
    /**
     * Indicates if the model blameable.
     *
     * @var bool
     */
    public $blameable = true;

    public static function bootBlameable()
    {
        static::creating(function ($model) {

            $model->updateBlameable();
        });

        static::updating(function ($model) {

            $model->updateBlameable();
        });
    }

    /**
     * Update the model's update blameable.
     *
     * @return bool
     */
    public function touchBy()
    {
        if (! $this->usesBlameable()) {
            return false;
        }

        $this->updateBlameable();

        return $this->save();
    }

    /**
     * Update the creation and update blameable user.
     *
     * @return void
     */
    protected function updateBlameable()
    {
        $user = $this->getBlameableUser();

        $updatedByColumn = $this->getUpdatedByColumn();

        if (! is_null($updatedByColumn) && ! $this->isDirty($updatedByColumn)) {
            $this->setUpdatedBy($user);
        }

        $createdByColumn = $this->getCreatedByColumn();

        if (! $this->exists && ! is_null($createdByColumn) && ! $this->isDirty($createdByColumn)) {
            $this->setCreatedBy($user);
        }
    }

     /**
     * Get a fresh timestamp for the model.
     *
     * @return int Auth User Id
     */
    public function getBlameableUser()
    {
        return (empty(Auth::id()))? $this->getDefaultValue(): Auth::id();
    }

    /**
     * Get the default value.
     *
     * @return int/string/null
     */
    public function getDefaultValue()
    {
        return $this->defaultValue ?: NULL;
    }


    /**
     * Set the value of the "created by" attribute.
     *
     * @param  mixed  $value
     * @return $this
     */
    public function setCreatedBy($value)
    {
        $this->{$this->getCreatedByColumn()} = $value;

        return $this;
    }

    /**
     * Set the value of the "updated by" attribute.
     *
     * @param  mixed  $value
     * @return $this
     */
    public function setUpdatedBy($value)
    {
        $this->{$this->getUpdatedByColumn()} = $value;

        return $this;
    }

    /**
     * Determine if the model uses timestamps.
     *
     * @return bool
     */
    public function usesBlameable()
    {
        return $this->blameable;
    }

    /**
     * Get the name of the "created by" column.
     *
     * @return string
     */
    public function getCreatedByColumn()
    {
        return defined('static::CREATED_BY') ? static::CREATED_BY : 'created_by';
    }

    /**
     * Get the name of the "updated by" column.
     *
     * @return string
     */
    public function getUpdatedByColumn()
    {
        return defined('static::UPDATED_BY') ? static::UPDATED_BY : 'updated_by';
    }

    /**
     * Get the fully qualified "created by" column.
     *
     * @return string
     */
    public function getQualifiedCreatedByColumn()
    {
        return $this->qualifyColumn($this->getCreatedByColumn());
    }

    /**
     * Get the fully qualified "updated by" column.
     *
     * @return string
     */
    public function getQualifiedUpdatedByColumn()
    {
        return $this->qualifyColumn($this->getUpdatedByColumn());
    }

    public function createdBy() {

        return $this->belongsTo(User::class,'created_by')
                    ->select('id', 'name', 'username');

    }

    public function updatedBy() {

        return $this->belongsTo(User::class,'updated_by')
                    ->select('id', 'name', 'username');

    }

    public function getCreatorAttribute() {

        return empty($this->createdBy) ? '-' : $this->createdBy->name;

    }

    public function getEditorAttribute() {

        return empty($this->updatedBy) ? '-' : $this->updatedBy->name;

    }
}
