<?php


namespace App\ORM\ActiveRecord\Models;

use App\ORM\ActiveRecord\NormalObjectBehavior;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string phone
 * @property int id
 */
class Phone extends Model
{
    use NormalObjectBehavior;

    protected $table = "phones";
    protected $fillable = [
        "id",
        "user_id",
        "phone"
    ];
    private int $user_id;
    public $timestamps = false;

    public function __construct(private string $phone, User $user)
    {
        $this->user_id = $user->getId();
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }


    public static function createPhone(User $user, string $phone)
    {
        return Phone::create([
            "phone" => $phone,
            'user_id' => $user->id
        ]);
    }
}
