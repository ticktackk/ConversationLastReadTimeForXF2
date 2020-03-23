<?php

namespace TickTackk\ConversationLastReadTime\XF\Repository;

use XF\App as BaseApp;
use XF\Entity\ConversationUser as ConversationUserEntity;
use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Repository;
use XF\Service\AbstractService;
use XF\Mvc\Entity\Manager as EntityManager;
use XF\Job\Manager as JobManager;

/**
 * Class Conversation
 * 
 * Extends \XF\Repository\Conversation
 *
 * @package TickTackk\ConversationLastReadTime\XF\Repository
 */
class Conversation extends XFCP_Conversation
{
    /**
     * @var array
     */
    protected $forcedConversationsReadTimestamps = [];

    /**
     * @param ConversationUserEntity $conversationUser
     * @param int|null $timestamp
     */
    public function forceConversationReadTimestamp(ConversationUserEntity $conversationUser, int $timestamp = null) : void
    {
        $this->forcedConversationsReadTimestamps[$conversationUser->conversation_id] = $timestamp ?: \XF::$time;
    }

    /**
     * @return array
     */
    public function getAllForcedConversationReadTimestamps() : array
    {
        return $this->forcedConversationsReadTimestamps;
    }

    /**
     * @param ConversationUserEntity $conversationUser
     *
     * @return int|null
     */
    public function getForcedConversationReadTimestamp(ConversationUserEntity $conversationUser) :? int
    {
        $conversationId = $conversationUser->conversation_id;
        $allForcedConversationReadTimestamps = $this->getAllForcedConversationReadTimestamps();

        if (!\array_key_exists($conversationId, $allForcedConversationReadTimestamps))
        {
            return null;
        }

        return $allForcedConversationReadTimestamps[$conversationId];
    }

    /**
     * @param ConversationUserEntity $conversationUser
     */
    public function clearForcedConversationReadTimestamp(ConversationUserEntity $conversationUser) : void
    {
        unset($this->forcedConversationsReadTimestamps[$conversationUser->conversation_id]);
    }

    public function clearForcedConversationReadTimestamps() : void
    {
        $this->forcedConversationsReadTimestamps = [];
    }

    /**
     * @param ConversationUserEntity $userConv
     * @param null $newRead
     */
    public function markUserConversationRead(ConversationUserEntity $userConv, $newRead = null)
    {
        $forcedNewRead = $this->getForcedConversationReadTimestamp($userConv);
        if ($forcedNewRead !== null)
        {
            $newRead = $forcedNewRead;
        }

        parent::markUserConversationRead($userConv, $newRead);

        $this->clearForcedConversationReadTimestamp($userConv);
    }
}