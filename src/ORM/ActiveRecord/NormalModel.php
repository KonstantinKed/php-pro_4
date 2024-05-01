<?php


namespace App\ORM\ActiveRecord;

use Illuminate\Database\Eloquent\Model;

abstract class NormalModel extends Model
{
    use NormalObjectBehavior;
}