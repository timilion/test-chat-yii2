<?php

use app\models\User;
use yii\db\Migration;

/**
 * Class m210603_152129_rbac_role
 */
class m210603_152129_rbac_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $authManager = Yii::$app->authManager;

        $authManager->removeAll();

        $guest = $authManager->createRole(User::GUEST);
        $authManager->add($guest);

        $user = $authManager->createRole(User::ROLE_USER);
        $authManager->add($user);
        $authManager->addChild($user, $guest);

        $admin = $authManager->createRole(User::ROLE_ADMIN);
        $authManager->add($admin);
        $authManager->addChild($admin, $guest);
        $authManager->addChild($admin, $user);

        $authManager->assign($admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $authManager = Yii::$app->authManager;
        $authManager->remove($authManager->getRole(User::GUEST));
        $authManager->remove($authManager->getRole(User::ROLE_USER));
        $authManager->remove($authManager->getRole(User::ROLE_ADMIN));
    }
}
