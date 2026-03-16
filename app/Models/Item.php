<?php

class Item extends Model
{

    protected $fillable = [
        'name',
        'category_id',
        'stock',
        'photo'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}