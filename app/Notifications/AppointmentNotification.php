<?php

namespace App\Notifications;

use App\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentNotification extends Notification
{
    use Queueable;

    public $level;
    public $appointment;
    public $action_tag = "Approve";
    public $action_url;
    public $message;
    public $title;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Appointment $appointment, $level)
    {
        //There are 3 Approval levels level one is the supervisor level 2 head of department level 3 security
        $this->action_url = url('/appointments/approve', ['ref' => sha1($appointment->id), 'level' => sha1($level)]);
        
        switch ($level) {
            case 1:
                $this->title = "Action on appointment required";
                $this->message = "Your action is required for the appointment below:<br/>";
                break;
            case 2:
                $this->title = "Action on appointment required";
                $this->message = "Your action is required for the appointment below:<br/>";
                break;
            case 3:
                $this->title = "Action on appointment required";
                $this->message = "Your action is required for the appointment below:<br/>";
                break;
            default:
                // do nothing
                break;
        }

        $this->message .="
            Hauler: $appointment->hauler <br/>
            Driver Name: $appointment->driver_name  <br/>
            Truck Registration: $appointment->truck_details <br/>
            Date/Time: $appointment->start_time
        ";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->line($this->title)
            ->action($this->action_tag, $this->action_url)
            ->line($this->message);
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
