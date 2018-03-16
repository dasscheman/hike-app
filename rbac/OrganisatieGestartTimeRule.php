<?php

namespace app\rbac;

use Yii;
use yii\rbac\Rule;
use app\models\DeelnemersEvent;
use app\models\EventNames;
use app\models\PostPassage;

/**
 * Checks if authorID matches user passed via params
 */
class OrganisatieGestartTimeRule extends Rule
{
    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (Yii::$app->user->identity->getStatusForEvent() == EventNames::STATUS_gestart &&
            Yii::$app->user->identity->getRolUserForEvent() == DeelnemersEvent::ROL_organisatie &&
            PostPassage::istimeLeftToday(Yii::$app->user->identity->selected_event_ID, Yii::$app->user->identity->getGroupUserForEvent())) {
            return TRUE;
        }
        return FALSE;
    }
}