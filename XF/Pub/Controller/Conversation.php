<?php

namespace TickTackk\ConversationLastReadTime\XF\Pub\Controller;

use XF\Entity\ConversationUser as ConversationUserEntity;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;
use XF\Mvc\Reply\View as ViewReply;
use XF\Mvc\Reply\Redirect as RedirectReply;
use XF\Mvc\Reply\Reroute as RerouteReply;
use XF\Mvc\Reply\Message as MessageReply;
use XF\Mvc\Reply\Exception as ExceptionReply;
use XF\Mvc\Reply\Error as ErrorReply;
use TickTackk\ConversationLastReadTime\XF\Repository\Conversation as ExtendedConversationRepo;

/**
 * Class Conversation
 * 
 * Extends \XF\Pub\Controller\Conversation
 *
 * @package TickTackk\ConversationLastReadTime\XF\Pub\Controller
 */
class Conversation extends XFCP_Conversation
{
    /**
     * @param string $action
     * @param ParameterBag $parameterBag
     * @param AbstractReply $reply
     */
    protected function postDispatchController($action, ParameterBag $parameterBag, AbstractReply &$reply)
    {
        parent::postDispatchController($action, $parameterBag, $reply);

        /** @var ExtendedConversationRepo $conversationRepo */
        $conversationRepo = $this->getConversationRepo();
        $conversationRepo->clearForcedConversationReadTimestamps();
    }

    /**
     * @param int|null $conversationId
     * @param array $extraWith
     *
     * @return ConversationUserEntity
     *
     * @throws ExceptionReply
     */
    protected function assertViewableUserConversation($conversationId, array $extraWith = [])
    {
        $conversationUser = parent::assertViewableUserConversation($conversationId, $extraWith);

        if ($conversationUser instanceof ConversationUserEntity)
        {
            /** @var ExtendedConversationRepo $conversationRepo */
            $conversationRepo = $this->getConversationRepo();
            $conversationRepo->forceConversationReadTimestamp($conversationUser);
        }

        return $conversationUser;
    }
}