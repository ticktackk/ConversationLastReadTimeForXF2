<?php

namespace TickTackk\ConversationLastReadTime\XF\Entity;

use XF\Phrase;

/**
 * Class User
 *
 * @package TickTackk\ConversationLastReadTime
 */
class User extends XFCP_User
{
    /**
     * @param Phrase|null $error
     *
     * @return bool
     */
    public function canViewConversationLastReadTime(Phrase &$error = null) : bool
    {
        if (!$this->user_id)
        {
            return false;
        }

        return $this->hasPermission('conversation', 'viewLastReadTime');
    }
}