<?php

namespace App\Models;

use Froiden\RestAPI\ApiModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends ApiModel
{
   
    public static function options($items, $group = null, $columnName = null)
    {
        $options = '<option value="">--</option>';


        foreach ($items as $item) {

            $name = is_null($columnName) ? $item->name : $item->{$columnName};

            $selected = (!is_null($group) && ($item->id == $group->id)) ? 'selected' : '';

            $options .= '<option ' . $selected . ' value="' . $item->id . '"> ' . $name . ' </option>';
        }

        return $options;
    }
}
