<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfirmationToken extends Model
{
    const ACTION_CONFIRM_ACCOUNT = 'confirm_account';
    const ACTION_DELETE_ACCOUNT = 'delete_account';

    protected $dates = [
        'expires_at'
    ];

    protected $fillable = [
        'token',
        'action',
        'expires_at'
    ];

    /**
     * A confirmation token belongs to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function isValid()
    {
        return $this->expires_at ? $this->expires_at->isFuture() : true;
    }
}
