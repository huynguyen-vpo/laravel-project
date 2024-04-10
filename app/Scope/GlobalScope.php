<?php
use Illuminate\Database\Eloquent\Scope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GlobalScope implements Scope{
    public function apply(Builder $builder, Model $model){
        $builder->where('created_at', '>', Carbon::yesterday());
    }
}