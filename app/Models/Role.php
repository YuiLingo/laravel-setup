<?php

namespace App\Models;

use App\Libraries\Traits\Blameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Tests\Database\Factories\RoleFactory;

class Role extends \TCG\Voyager\Models\Role
{
    use Blameable;
}
