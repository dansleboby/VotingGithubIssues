<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Vote
 *
 * @property int $user_id
 * @property int $github_id
 * @property-read \App\Models\Github $github
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vote whereGithubId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vote whereUserId($value)
 * @mixin \Eloquent
 */
class Vote extends Model {

    protected $table = 'votes';
    public    $timestamps = false;
    protected $fillable = [
        'github_id',
        'user_id'
    ];

    public function github() {
        return $this->hasOne('App\Models\Github');
    }

    public function user() {
        return $this->hasOne('App\Models\User');
    }

}