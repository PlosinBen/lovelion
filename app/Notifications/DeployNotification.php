<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class DeployNotification extends Notification
{
    use Queueable;

    private $travisPayload;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($travisPayload)
    {
        $this->travisPayload = $travisPayload;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toTelegram($notifiable)
    {
        $buildResult = $this->travisPayload->result_message;
        $branch = $this->travisPayload->branch;
        $repoName = $this->travisPayload->repository->name;
//        $repoOwner = $this->travisPayload->repository->owner_name;
        $author = $this->travisPayload->author_name;

        $messageStack = collect();
        foreach ($this->travisPayload->matrix as $matrix) {
            $commit = substr($matrix->commit, 0, 8);
            $message = $matrix->message;
            $compare_url = $matrix->compare_url;

            $messageStack->push("> [{$commit}]({$compare_url}) {$message}");
        }
        $message = implode("\n", $messageStack);

        //travis ci
        $buildNum = $this->travisPayload->number;
        $buildUrl = $this->travisPayload->build_url;

        $content = "
Github:
{$repoName}:{$branch} Push by {$author}
{$message}
--
Travis-CI:
[Build #{$buildNum}]({$buildUrl}) - State: \[{$buildResult}]
";

        return TelegramMessage::create($content)
            ->to($notifiable->routes['telegram']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
