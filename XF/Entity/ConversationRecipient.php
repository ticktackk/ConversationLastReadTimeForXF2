<?php

namespace TickTackk\ConversationLastReadTime\XF\Entity;

use TickTackk\ConversationLastReadTime\XF\Entity\User as ExtendedUserEntity;
use XF\Phrase;

/**
 * Class ConversationRecipient
 *
 * @package TickTackk\ConversationLastReadTime
 */
class ConversationRecipient extends XFCP_ConversationRecipient
{
    /**
     * @param Phrase|null $error
     *
     * @return bool
     */
    public function canViewConversationLastReadTime(Phrase &$error = null) : bool
    {
        /** @var ExtendedUserEntity $visitor */
        $visitor = \XF::visitor();
        return $visitor->canViewConversationLastReadTime($error);
    }
}