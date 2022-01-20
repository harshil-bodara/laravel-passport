<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{

    public function created(User $user)
    {
        $this->sendMailable($user, StudentAddedEmail::class);
    }

    public function deleted(Classroom $classroom)
    {
        $this->sendMailable($classroom, StudentDeletedEmail::class);
    }

    private function sendMailable(Classroom $classroom, $mailable)
    {
        $teacher = User::findOrFail($classroom->teacher_id)->first();
        $student = User::findOrFail($classroom->student_id)->first();

        \Mail::to($teacher->email)->send(
            new $mailable($teacher, $student)
        );

    
    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
