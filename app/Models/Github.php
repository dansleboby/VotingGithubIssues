<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Github
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property string $html_url
 * @property string $title
 * @property string $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vote[] $votes
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Github onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Github whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Github whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Github whereHtmlUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Github whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Github whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Github whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Github whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Github withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Github withoutTrashed()
 * @mixin \Eloquent
 */
class Github extends Model 
{

    protected $table = 'github';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['id', 'title', 'html_url', 'state', 'comments', 'created_at'];

    public function votes()
    {
        return $this->hasMany('App\Models\Vote');
    }

}