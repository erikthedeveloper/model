<?php namespace Esensi\Model;

use \Esensi\Model\Contracts\EncryptingModelInterface;
use \Esensi\Model\Contracts\HashingModelInterface;
use \Esensi\Model\Contracts\PurgingModelInterface;
use \Esensi\Model\Contracts\RelatingModelInterface;
use \Esensi\Model\Contracts\ValidatingModelInterface;
use \Esensi\Model\Traits\EncryptingModelTrait;
use \Esensi\Model\Traits\HashingModelTrait;
use \Esensi\Model\Traits\PurgingModelTrait;
use \Esensi\Model\Traits\RelatingModelTrait;
use \Esensi\Model\Traits\ValidatingModelTrait;
use \Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Base Model
 *
 * @package Esensi\Model
 * @author Daniel LaBarge <dalabarge@emersonmedia.com>
 * @copyright 2014 Emerson Media LP
 * @license https://github.com/esensi/model/blob/master/LICENSE.txt MIT License
 * @link http://www.emersonmedia.com
 *
 * @see \Illuminate\Database\Eloquent\Model
 * @see \Esensi\Model\Contracts\EncryptingModelInterface
 * @see \Esensi\Model\Contracts\HashingModelInterface
 * @see \Esensi\Model\Contracts\PurgingModelInterface
 * @see \Esensi\Model\Contracts\RelatingModelInterface
 * @see \Esensi\Model\Contracts\ValidatingModelInterface
 */
abstract class Model extends Eloquent implements
    EncryptingModelInterface,
    HashingModelInterface,
    PurgingModelInterface,
    RelatingModelInterface,
    ValidatingModelInterface {

    /**
     * Make model validate attributes.
     *
     * This comes first even though it is out of alphabetical
     * order because it is important that it is booted before
     * hashing and purging traits.
     *
     * @see \Esensi\Model\Traits\ValidatingModelTrait
     */
    use ValidatingModelTrait;

    /**
     * Make model encrypt attributes.
     *
     * @see \Esensi\Model\Traits\EncryptingModelTrait
     */
    use EncryptingModelTrait;

    /**
     * Make model hash attributes.
     *
     * @see \Esensi\Model\Traits\HashingModelTrait
     */
    use HashingModelTrait;

    /**
     * Make model purge attributes.
     *
     * @see \Esensi\Model\Traits\PurgingModelTrait
     */
    use PurgingModelTrait;

    /**
     * Make model use properties for model relationships.
     *
     * @see \Esensi\Model\Traits\RelatingModelTrait
     */
    use RelatingModelTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * The rulesets that the model will validate against.
     *
     * @var array
     */
    protected $rulesets = [];

    /**
     * The attributes to encrypt when set and
     * decrypt when gotten.
     *
     * @var array
     */
    protected $encryptable = [];

    /**
     * The attributes to hash before saving.
     *
     * @var array
     */
    protected $hashable = [];

    /**
     * The attributes to purge before saving.
     *
     * @var array
     */
    protected $purgeable = [];

    /**
     * Relationships that the model should set up.
     *
     * @var array
     */
    protected $relationships = [];


    /**
     * Dynamically retrieve attributes.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get( $key )
    {
        // Resolve relationship dynamically
        if( $relationship = $this->getDynamicRelationship( $key ) )
        {
            return $relationship;
        }

        // Dynamically retrieve the encryptable attribute
        if( $attribute = $this->getDynamicEncrypted( $key ) )
        {
            return $attribute;
        }

        // Default Eloquent dynamic getter
        return parent::__get( $key );
    }

}
