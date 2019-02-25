<?php

namespace App\Models\Access\Project;
use App\Models\Access\Project;
//use App\Models\Access\Project\Traits\Attribute\ProjectAttribute;
//use App\Models\Access\Project\Traits\Relationship\ProjectRelationship;
use App\Models\Access\Project\Traits\Scope\ProjectScope;
use App\Models\Access\Project\Traits\ProjectAccess;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class Project.
 */
class project implements JWTSubject
{
    use ProjectScope,
        ProjectAccess,
        Notifiable,
        SoftDeletes;
        //ProjectAttribute,
       // ProjectRelationship;
       
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_name',
        'project_details',
        'file',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
   

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('access.project_table');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array 
     */
    public function getJWTCustomClaims()
    {
        return [
            'id'                    => $this->id,
            'project_name'          => $this->project_name,
            'project_details'       => $this->project_details,
            'file'                  => $this->getFile(),
            'status'                => $this->status,
            'created_at'            => $this->created_at->toIso8601String(),
            'updated_at'            => $this->updated_at->toIso8601String(),
        ];
    }
}
