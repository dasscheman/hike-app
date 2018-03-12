<?php

namespace app\rbac;

use Yii;
use yii\rbac\Rule;
use app\models\DeelnemersEvent;

/**
 * Checks if authorID matches user passed via params
 */
class DeelnemerRule extends Rule
{
    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (Yii::$app->user->identity->getRolUserForEvent() == DeelnemersEvent::ROL_deelnemer) {
            return TRUE;
        }

        return FALSE;
    }
}