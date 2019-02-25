<?php

namespace App\Models\Access\User\Traits\Attribute;

/**
 * Class UserAttribute.
 */
trait ProjectAttribute
{
   
   
    public function getStatusLabelAttribute()
    {
        if ($this->isActive()) {
            return "<label class='label label-success'>".trans('labels.general.active').'</label>';
        }

        return "<label class='label label-danger'>".trans('labels.general.inactive').'</label>';
    }

  
    
    /**
     * @return mixed
     */
    public function getFileAttribute()
    {
        return $this->getFile();
    }

    /**
     * @param bool $size
     *
     * @return mixed
     */
    public function getFile($size = false)
    {
        if (!$size) {
            $size = config('gravatar.default.size');
        }

        return gravatar()->get($this->email, ['size' => $size]);
    }

    /**
     * @param $provider
     *
     * @return bool
     */
    public function hasProvider($provider)
    {
        foreach ($this->providers as $p) {
            if ($p->provider == $provider) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status == 1;
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed == 1;
    }

    /**
     * @return string
     */
    public function getShowButtonAttribute($class)
    {
        if (access()->allow('show-project')) {
            return '<a class="'.$class.'" href="'.route('admin.access.project.show', $this).'">
                    <i data-toggle="tooltip" data-placement="top" title="View" class="fa fa-eye"></i>
                </a>';
        }
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute($class)
    {
        if (access()->allow('edit-project')) {
            return '<a class="'.$class.'" href="'.route('admin.access.project.edit', $this).'">
                    <i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-pencil"></i>
                </a>';
        }
    }

    /**
     * @return string
     */
   
    }

    /**
     * @return string
     */
    
    /**
     * @return string
     */
   

    /**
     * @return string
     */
    public function getDeleteButtonAttribute($class)
    {
        if ($this->id != access()->id() && access()->allow('delete-project')) {
            $name = $class == '' ? 'Delete' : '';

            return '<a class="'.$class.'" href="'.route('admin.access.project.destroy', $this).'"
                 data-method="delete"
                 data-trans-button-cancel="'.trans('buttons.general.cancel').'"
                 data-trans-button-confirm="'.trans('buttons.general.crud.delete').'"
                 data-trans-title="'.trans('strings.backend.general.are_you_sure').'"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.general.crud.delete').'"></i>'.$name.'</a>';
        }

        return '';
    }

    /**
     * @return string
     */
    public function getRestoreButtonAttribute($class)
    {
        if (access()->allow('delete-project')) {
            return '<a class="'.$class.'" href="'.route('admin.access.project.restore', $this).'" name="restore_user"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.backend.access.projects.restore_project').'"></i></a> ';
        }
    }

    /**
     * @return string
     */
    public function getDeletePermanentlyButtonAttribute($class)
    {
        return '<a class="'.$class.'" href="'.route('admin.access.project.delete-permanently', $this).'" name="delete_project_perm"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.backend.access.projects.delete_permanently').'"></i></a> ';
    }

    /**
     * @return string
     */
   
    /**
     * @return string
     */
    public function getClearSessionButtonAttribute($class)
    {
        $name = $class == '' ? 'Clear Session' : '';

        if ($this->id != access()->id() && config('session.driver') == 'database' && access()->allow('clear-user-session')) {
            return '<a class="'.$class.'" href="'.route('admin.access.user.clear-session', $this).'"
			 	 data-trans-button-cancel="'.trans('buttons.general.cancel').'"
                 data-trans-button-confirm="'.trans('buttons.general.continue').'"
                 data-trans-title="'.trans('strings.backend.general.are_you_sure').'"
                 name="confirm_item"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="'.trans('buttons.backend.access.users.clear_session').'"></i>'.$name.'</a>';
        }

        return '';
    }

    public function checkAdmin()
    {
        if ($this->id != 1) {
            return '<div class="btn-group dropup">
                        <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-option-vertical"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                        <li>'.$this->getStatusButtonAttribute('').'</li>
                        <li>'.$this->getClearSessionButtonAttribute('').'</li>
                        <li>'.$this->getDeleteButtonAttribute('').'</li>
                        <li>'.$this->getLoginAsButtonAttribute('').'</li>
                        </ul>
                    </div>';
        }
    }

    /**
     * Get logged in user permission related to user management grid.
     *
     * @return array
     */
    public function getUserPermission()
    {
        $userPermission = [];
        $attributePermission = ['8', '10', '11', '12', '13', '14', '15'];
        foreach (access()->user()->permissions as $permission) {
            if (in_array($permission->id, $attributePermission)) {
                $userPermission[] = $permission->name;
            }
        }

        return $userPermission;
    }

    /**
     * Get action button attribute by permission name.
     *
     * @param string $permissionName
     * @param int    $counter
     *
     * @return string
     */
    public function getActionButtonsByPermissionName($permissionName, $counter)
    {
        // check if counter is less then 3 then apply button client
        $class = ($counter <= 3) ? 'btn btn-default btn-flat' : '';

        switch ($permissionName) {
            case 'show-user':
                $button = ($counter <= 3) ? $this->getShowButtonAttribute($class) : '<li>'
                    .$this->getShowButtonAttribute($class).
                    '</li>';
                break;
            case 'edit-user':
                $button = ($counter <= 3) ? $this->getEditButtonAttribute($class) : '<li>'
                    .$this->getEditButtonAttribute($class).
                    '</li>';
                $button .= ($counter <= 3) ? $this->getChangePasswordButtonAttribute($class) : '<li>'
                    .$this->getChangePasswordButtonAttribute($class).
                    '</li>';
                break;
            case 'activate-user':
                if (\Route::currentRouteName() == 'admin.access.user.deactivated.get') {
                    $button = ($counter <= 3) ? $this->getStatusButtonAttribute($class) : '<li>'
                    .$this->getStatusButtonAttribute($class).
                    '</li>';
                } else {
                    $button = '';
                }
                break;
            case 'deactivate-user':
                if (\Route::currentRouteName() == 'admin.access.user.get') {
                    $button = ($counter <= 3) ? $this->getStatusButtonAttribute($class) : '<li>'
                    .$this->getStatusButtonAttribute($class).
                    '</li>';
                } else {
                    $button = '';
                }
                break;
            case 'delete-user':
                if (access()->user()->id != $this->id) {
                    $button = ($counter <= 3) ? $this->getDeleteButtonAttribute($class) : '<li>'
                        .$this->getDeleteButtonAttribute($class).
                        '</li>';
                } else {
                    $button = '';
                }
                break;
            case 'login-as-user':
                if (access()->user()->id != $this->id) {
                    $button = ($counter <= 3) ? $this->getLoginAsButtonAttribute($class) : '<li>'
                        .$this->getLoginAsButtonAttribute($class).
                        '</li>';
                } else {
                    $button = '';
                }
                break;
            case 'clear-user-session':
                if (access()->user()->id != $this->id) {
                    $button = ($counter <= 3) ? $this->getClearSessionButtonAttribute($class) : '<li>'
                        .$this->getClearSessionButtonAttribute($class).
                        '</li>';
                } else {
                    $button = '';
                }
                break;
            default:
                $button = '';
                break;
        }

        return $button;
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        if ($this->trashed()) {
            return '<div class="btn-group action-btn">
                        '.$this->getRestoreButtonAttribute('btn btn-default btn-flat').'
                        '.$this->getDeletePermanentlyButtonAttribute('btn btn-default btn-flat').'
                    </div>';
        }

        // Check if role have all permission
        if (access()->user()->roles[0]->all) {
            return '<div class="btn-group action-btn">
                    '.$this->getShowButtonAttribute('btn btn-default btn-flat').'
                    '.$this->getEditButtonAttribute('btn btn-default btn-flat').'
                    '.$this->getChangePasswordButtonAttribute('btn btn-default btn-flat').'
                    '.$this->checkAdmin().'
                </div>';
        } else {
            $userPermission = $this->getUserPermission();
            $permissionCounter = count($userPermission);
            $actionButton = '<div class="btn-group action-btn">';
            $i = 1;

            if (access()->user()->id == $this->id) {
                if (in_array('clear-user-session', $userPermission)) {
                    $permissionCounter = $permissionCounter - 1;
                }

                if (in_array('login-as-user', $userPermission)) {
                    $permissionCounter = $permissionCounter - 1;
                }

                if (in_array('delete-user', $userPermission)) {
                    $permissionCounter = $permissionCounter - 1;
                }

                if (in_array('deactivate-user', $userPermission)) {
                    $permissionCounter = $permissionCounter - 1;
                }
            }

            foreach ($userPermission as $value) {
                if ($i != 3) {
                    $actionButton = $actionButton.''.$this->getActionButtonsByPermissionName($value, $i);
                }

                if ($i == 3) {
                    $actionButton = $actionButton.''.$this->getActionButtonsByPermissionName($value, $i);

                    if ($permissionCounter > 3) {
                        $actionButton = $actionButton.'
                            <div class="btn-group dropup">
                            <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-option-vertical"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">';
                    }
                }
                $i++;
            }
            $actionButton .= '</ul></div></div>';

            return $actionButton;
        }
    }
}
