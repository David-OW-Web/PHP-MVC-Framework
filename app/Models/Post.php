<?php


class Post extends Entity
{
    protected $table = "post";

    public $post_id;
    public $title;
    public $body;
    public $created_at;
    public $updated_at;
}