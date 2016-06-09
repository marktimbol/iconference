<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exhibitor extends Model
{
    use AddRemoveContacts;

    protected $fillable = ['name', 'standNumber', 'country', 'website', 'about'];

    protected $with = ['contacts'];

    public function contacts()
    {
        return $this->belongsToMany(
        	User::class, 
        	'exhibitor_contacts', 
        	'exhibitor_id', 
        	'contact_id'
        );
    }
}
