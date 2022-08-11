<?php

namespace App\Notifications;

use App\Task;
use Illuminate\Support\Carbon;
use App\EmailNotificationSetting;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class TaskUpdatedClient extends BaseNotification
{


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $task;
    private $emailSetting;

    public function __construct(Task $task)
    {
        parent::__construct();
        $this->task = $task;
        $this->emailSetting = EmailNotificationSetting::where('setting_name', 'Task Completed')->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['database'];

        if ($this->emailSetting->send_email == 'yes' && $notifiable->email_notifications) {
            array_push($via, 'mail');
        }

        return $via;
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
            ->subject(__('email.taskUpdate.subject') . ' - ' . config('app.name') . '!')
            ->greeting(__('email.hello') . ' ' . ucwords($notifiable->name) . '!')
            ->line(ucfirst($this->task->heading) . ' ' . __('email.taskUpdate.subject') . '.')
            ->action(__('email.loginDashboard'), getDomainSpecificUrl(url('/login'), $notifiable->company))
            ->line(__('email.thankyouNote'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
//        return $this->task->toArray();
        return [
            'id' => $this->task->id,
            'created_at' => Carbon::parse($this->task->created_at)->format('Y-m-d H:i:s'),
            'heading' => $this->task->heading,
            'hash' => $this->task->hash,
            'completed_on' => Carbon::parse($this->task->completed_on)->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        //        $slack = SlackSetting::first();
        //        if(count($notifiable->employee) > 0 && (!is_null($notifiable->employee[0]->slack_username) && ($notifiable->employee[0]->slack_username != ''))){
        //            return (new SlackMessage())
        //                ->from(config('app.name'))
        //                ->image($slack->slack_logo_url)
        //                ->to('@' . $notifiable->employee[0]->slack_username)
        //                ->content(ucfirst($this->task->heading).' '.__('email.taskUpdate.subject').'.');
        //        }
        //        return (new SlackMessage())
        //            ->from(config('app.name'))
        //            ->image($slack->slack_logo_url)
        //            ->content('This is a redirected notification. Add slack username for *'.ucwords($notifiable->name).'*');
    }

}