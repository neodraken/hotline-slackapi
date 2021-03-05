<?php

namespace App\Notifier;

use App\Entity\Ticket;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackActionsBlock;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackDividerBlock;
use Symfony\Component\Notifier\Bridge\Slack\Block\SlackSectionBlock;
use Symfony\Component\Notifier\Bridge\Slack\SlackOptions;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Component\Notifier\Notification\ChatNotificationInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\Recipient;

class TicketNotification extends Notification implements ChatNotificationInterface
{
    private $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;

        parent::__construct('New ticket sent');
    }

    public function asChatMessage(Recipient $recipient, ?string $transport = null): ?ChatMessage
    {
        if ('slack' === $transport) {
            // return (new ChatMessage('you got a new message on slack'))->transport('slack');

            $chat = ChatMessage::fromNotification($this, $recipient, $transport);
            // $chat->subject($this->ticket->getSummary());
            $chat->options((new SlackOptions())
                    ->iconEmoji('tada')
                    ->iconUrl('https://guestbook.example.com')
                    ->username('Guestbook')
                    ->block((new SlackSectionBlock())->text($this->ticket->getLabelType() . ': ' . $this->ticket->getSummary()))
                    ->block(new SlackDividerBlock())
                    ->block((new SlackSectionBlock())
                        ->text(
                            sprintf('%s (%s) says: %s', $this->ticket->getName(), $this->ticket->getEmail(), $this->ticket->getDescription())
                        ))
            );

            return $chat;
        }

        return null;
    }

    public function getChannels(Recipient $recipient): array
    {
        return ['chat/slack'];
    }
}
