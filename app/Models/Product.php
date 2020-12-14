<?php


namespace App\Models;


use App\Helpers\Traits\HasFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFile;

    /**
     * @var string
     */
    protected $rootDirPath = "products";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'price', 'image', 'created_at', 'updated_at'
    ];

    /**
     * @var string[]
     */
    protected $appends = ["link"];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['created_at' => 'datetime:d M, Y h:i A'];

    /**
     * @return BelongsTo|null
     */
    public function user(): ?BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getLinkAttribute(): string
    {
        return route("api.products.image", ['product' => $this->id]);
    }
}
