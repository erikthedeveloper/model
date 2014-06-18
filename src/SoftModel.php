<?php namespace Esensi\Model;

use \Esensi\Model\Model;
use \Esensi\Model\Contracts\SoftDeletingModelInterface;
use \Esensi\Model\Traits\SoftDeletingModelTrait;

/**
 * Soft Deleting Model
 *
 * @author daniel <daniel@bexarcreative.com>
 * @see \Esensi\Model\Model
 * @see \Esensi\Model\Contracts\SoftDeletingModelInterface
 */
abstract class SoftModel extends Model implements SoftDeletingModelInterface {

    /**
     * Make model use soft deletes.
     *
     * @see \Esensi\Model\Traits\SoftDeletingModelTrait
     */
    use SoftDeletingModelTrait;

    /**
     * Get the attributes that should be converted to dates.
     *
     * Overwriting this method here allows the developer to
     * extend the dates using the $dates property without
     * needing to maintain the "deleted_at" column.
     *
     * @return array
     */
    public function getDates()
    {
        $defaults = array(static::CREATED_AT, static::UPDATED_AT, $this->getDeletedAtColumn());

        return array_merge($this->dates, $defaults);
    }
}