<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\EmailScope;

class Email extends Model
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new EmailScope);
    }
    
    /**
     * boot model eloquent events
     *
     * @return void
    */
    public static function boot()
    {
        parent::boot();
        
        /**
         * Send email after creation
        */
        self::created(function($model){
            dispatch(new \App\Jobs\SendEmailJob($model));
        });
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'to',
        'subject',
        'message',
    ];
    
    /**
     * Get the user that owns the Email
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}