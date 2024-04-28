<?php


namespace App\ORM\ActiveRecord\Models;

use App\ORM\ActiveRecord\NormalObjectBehavior;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use NormalObjectBehavior;

    protected $table = "users";

    public $timestamps = false;

    private int $id;

    /**
     * @param int $status
     * @param string $name
     */
    public function __construct(private string $name, private int $status = 0)
    {
        parent::__construct();
    }


    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public static function getAll()
    {
//        $users = User::all();
        $users = User::query()->where('status', '>=', 0)->get();

        return $users;
    }

    public static function getActiveUsers()
    {
        $users = User::query()->where('status', 1)->get();
        return $users;
    }

}
