<?php

namespace App\Models\Traits;

use App\Models\Opportunity;

trait SearchScope{
    protected $madjmaa_search_q;
    public function scopeSearch($query, $search){
        $columns = (array) $this->searchColumns();
        if($search && count((array) $columns)){
            $search = "%".$search."%";
            $this->madjmaa_search_q = $search;

            $query->where(function($q) use($search, $columns){
                foreach ($columns as $i => $column) {
                    if(is_array($column)){
                        $this->madjmaaWhereHas($q, $i, $column);
                    }else{
                        $q = $this->madjmaaSearchByColumn($q, $i, $column);
                    }
                }
            });
            return $query;
        }
        return $query;
    }

    public function searchColumns(){
        return [];
    }

    private function madjmaaSearchByColumn($q, $i, $column){
        if($i==0) $q->where($column, 'LIKE', $this->madjmaa_search_q);
        else $q->orWhere($column, 'LIKE', $this->madjmaa_search_q);
        return $q;
    }

    private function madjmaaWhereHas($q, $i, $column){
        if($i==0) $q->whereHas($i, function($q2) use($column){
            $q2 = $this->madjmaaSearchOnRelation($q2, $column);
        });
        else $q->orWhereHas($i, function($q2) use($column){
            $q2 = $this->madjmaaSearchOnRelation($q2, $column);
        });
        return $q;
    }

    private function madjmaaSearchOnRelation($q2, $column){
        foreach ($column as $i => $column2) {
            if(is_array($column2)){
                $q2 = $this->madjmaaWhereHas($q2, $i, $column2, $this->madjmaa_search_q);
            }else{
                $q2 = $this->madjmaaSearchByColumn($q2, $i, $column2, $this->madjmaa_search_q);
            }
        }
        return $q2;
    }
}
