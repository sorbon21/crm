<?php

namespace App\Enums;

enum RBAC: string
{
    case Admin = 'admin';
    case Operator = 'operator';
    case Specialist = 'specialist_back_office';


}
