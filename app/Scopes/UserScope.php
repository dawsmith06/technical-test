<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $search    = request()->search;
        $orderBy   = request()->orderBy;
        $orderMode = request()->orderMode;
        
        if($search){
            $builder->orWhere("name", 'like', '%' . $search . '%')
            ->orWhere("identification_card", 'like', '%' . $search . '%')
            ->orWhere("email", 'like', '%' . $search . '%')
            ->orWhere("cellphone_number", 'like', '%' . $search . '%');
        }
        
        if($orderBy && $this->hasColumn($orderBy)){
            $builder->orderBy($orderBy,$orderMode);
        }
    }


    /**
     * Get an array of user table columns
     * @return array
    */
    private function getTableColumns(){
        return \DB::getSchemaBuilder()->getColumnListing("users");
    }

    /**
     * Determine  if table a certain column
     *
     * @param [String] $columnName
     * @return boolean
    */
    private function hasColumn($columnName){
        return array_search($columnName,$this->getTableColumns()) !== false;
    }
}