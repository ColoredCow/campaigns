<?php

namespace App\Observers;

use App\Models\SenderIdentity;

class SenderIdentityObserver
{
    /**
     * Handle the sender identity "created" event.
     *
     * @param  \App\SenderIdentity  $senderIdentity
     * @return void
     */
    public function created(SenderIdentity $senderIdentity)
    {
        if ($senderIdentity->is_default) {
            $this->removePreviousDefault($senderIdentity);
        }
    }

    /**
     * Handle the sender identity "updated" event.
     *
     * @param  \App\SenderIdentity  $senderIdentity
     * @return void
     */
    public function updated(SenderIdentity $senderIdentity)
    {
        if ($senderIdentity->is_default) {
            $this->removePreviousDefault($senderIdentity);
        }
    }

    private function removePreviousDefault($newDefault)
    {
        $previousDefault = SenderIdentity::default()
            ->where('id', '!=', $newDefault->id)
            ->first();

        optional($previousDefault)->removeAsDefault();
    }
}
