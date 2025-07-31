<?php

namespace App\Observers;

use App\Models\Person;

class PersonObserver
{
    /**
     * Handle the Person "creating" event.
     */
    public function creating(Person $person): void
    {
        $this->formatPersonData($person);
    }

    /**
     * Handle the Person "created" event.
     */
    public function created(Person $person): void
    {
        activity()->log("Nova pessoa criada: {$person->full_name}");
    }

    /**
     * Handle the Person "updating" event.
     */
    public function updating(Person $person): void
    {
        if ($person->isDirty('cpf')) {
            $this->formatPersonData($person);
        }
    }

    /**
     * Handle the Person "updated" event.
     */
    public function updated(Person $person): void
    {
        activity()->log("Pessoa atualizada: {$person->full_name}");
    }

    /**
     * Handle the Person "deleting" event.
     */
    public function deleting(Person $person): void
    {
        if ($person->user()->exists()) {
            abort(403, 'Não é possível excluir pessoa com usuário associado');
        }
    }

    /**
     * Handle the Person "deleted" event.
     */
    public function deleted(Person $person): void
    {
        activity()->log("Pessoa excluída: {$person->full_name}");
    }

    /**
     * Format person data before saving
     */
    private function formatPersonData(Person $person): void
    {
        $person->cpf = preg_replace('/[^0-9]/', '', $person->cpf);
        $person->zip_code = preg_replace('/[^0-9]/', '', $person->zip_code);
        $person->full_name = mb_convert_case($person->full_name, MB_CASE_TITLE, 'UTF-8');
    }
}