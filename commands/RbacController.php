<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\rbac\Role;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Create roles
        $userRole = $auth->createRole('user');
        $adminRole = $auth->createRole('admin');

        // Add roles to the RBAC system
        $auth->add($userRole);
        $auth->add($adminRole);

        // Give admin role the ability to perform everything
        $auth->addChild($adminRole, $userRole);

        // Assign the 'admin' role to a user (admin user)
        // Replace 'user_id' with your admin user's id
        $auth->assign($adminRole, 1);

        // Assign the 'user' role to a user
        // Replace 'user_id' with your normal user's id
        $auth->assign($userRole, 2);

        echo "RBAC initialization complete.\n";
    }
}
