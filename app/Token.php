<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Token
 * @package App
 */
class Token extends Model {

    /**
     * @var array
     */
    protected $fillable = ['phone','token','user_id'];

    /**
     * @var string
     */
    protected $table = 'token';

    /**
     * @var array
     */
    protected $dates = [];

    /**
     * @var array
     */
    public static $rules = [
        // Validation rules
    ];

    /**
     *
     */
    public function user()
    {
        $this->belongsTo('App\User');
    }

    /**
     * @param $loggedUser
     * @param $phoneNumber
     * @param $token
     * @return mixed
     */
    public function checkToken($loggedUser, $phoneNumber, $token)
    {

        return $this->where('phone', $phoneNumber)
            ->where('token', $token      )
            ->where('user_id', $loggedUser->id)
            ->where('validated', false)
            ->first();

    }




}
