<?php


class Product extends Entity
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';

    public $product_id;
    public $product_title;
    public $product_description;
    public $short_description;
    public $created_at;
    public $updated_at;
    public $quantity;
    public $price;
    public $fk_category_id;
    public $fk_status_id;
    public $fk_manufacturer_id;
    public $keywords;
}