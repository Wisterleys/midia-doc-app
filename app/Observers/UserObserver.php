<?php

namespace App\Observers;

use App\Models\User;
use App\Repositories\Contracts\Employee\IEmployeeRepository;

class UserObserver
{
    protected IEmployeeRepository $employeeRepository;

    public function __construct(IEmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        //
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleting" event.
     */
    public function deleting(User $user): void
    {
        $employee = $user->employee;

        if (
            !is_null($employee) 
            && !is_null($employee->id)
        ) {
            $this->employeeRepository
                ->delete(
                    $employee->id
                );
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
