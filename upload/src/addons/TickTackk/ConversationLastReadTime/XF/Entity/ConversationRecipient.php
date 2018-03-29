<?php

namespace TickTackk\ConversationLastReadTime\XF\Entity;

class ConversationRecipient extends XFCP_ConversationRecipient
{
    /**
     * @return bool
     */
    public function canViewConversationLastReadTime()
    {
        /** @var \TickTackk\ConversationLastReadTime\XF\Entity\User $visitor */
        $visitor = \XF::visitor();
        return $visitor->canViewConversationLastReadTime();
    }
}