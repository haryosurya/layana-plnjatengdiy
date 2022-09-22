<?php

namespace App\Repositories;

use App\Models\Dc_apj;
use App\Repositories\BaseRepository;

/**
 * Class Dc_apjRepository
 * @package App\Repositories
 * @version September 21, 2022, 6:05 pm UTC
*/

class Dc_apjRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Dc_apj::class;
    }
}
