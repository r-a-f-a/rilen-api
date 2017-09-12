<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class RedirectorModel extends Model
{
    public $timestamps = false;
    protected $table = "btg_accounting.btg_click";
    protected $fillable = [
        "btgId",  "email", "position", "productId", "productLink",
        "createdAt", "createdAtFull"
    ];
}