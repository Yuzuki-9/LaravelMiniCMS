<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string|null $body
 * @property bool $is_public 公開・非公開
 * @property \Illuminate\Support\Carbon $published_at 公開日
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\PostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use HasFactory;

    // 更新できるプロパティを設定
    // id, created_at, updated_atはDBとフレームワークの機能で更新するのでfillableには書かない
    protected $fillable = [
        'title', 'body', 'is_public', 'published_at'
    ];

    // castsにはどのような型を扱うかを設定する
    protected $casts = [
        'is_public' => 'bool',
        'published_at' => 'datetime'
    ];

    // 公開のみ表示のスコープ
    public function scopePublic(Builder $query)
    {
        return $query->where('is_public', true);
    }
 
    // 公開記事一覧取得のスコープ
    public function scopePublicList(Builder $query)
    {
        return $query
            ->public()
            ->latest('published_at')
            ->paginate(10);
    }
 
    // 公開記事をIDで取得のスコープ
    public function scopePublicFindById(Builder $query, int $id)
    {
        return $query->public()->findOrFail($id);
    }
}
