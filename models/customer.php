<?php
require_once "BaseModel.php";

class Customer extends BaseModel
{
    protected $table = 'customers';

    public function __construct()
    {
        parent::__construct();
    }
}
