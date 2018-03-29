<?php

namespace TickTackk\ConversationLastReadTime\XF\Entity;

class User extends XFCP_User
{
    /**
     * @return bool
     */
    public function canViewConversationLastReadTime()
    {
        $visitor = \XF::visitor();

        if (!$visitor->user_id)
        {
            return false;
        }

        return ($this->user_id && $this->hasPermission('conversation', 'viewLastReadTime'));
    }
}