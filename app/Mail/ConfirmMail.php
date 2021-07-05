<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('mail_confirm', [
        //         'url' => 'caltymart.com/verifikasi_akun/'.$this->data->id,
        //     ]);
        return $this->from('noreply-caltymart@caltymart.com')
                ->subject('Aktivasi akun Caltymart')
                ->markdown('mail_confirm', [
                    'url' => 'https://api.caltymart.com/verifikasi_akun/'.$this->data->id,
                ]);

        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()->addTextHeader(
                'Custom-Header', 'Calty Mart Verification'
            );
        });
    }
}