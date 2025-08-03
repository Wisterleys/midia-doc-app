<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
abstract class TestCase extends BaseTestCase
{
    /*
     * all
    */

    public function allUsers()
    {
        return \App\Models\User::all();
    }

    public function allEmployeesWithUsersAndDocumentsAndNotebooks()
    {
        return \App\Models\Employee::with(['user', 'documents', 'notebooks'])->get();
    }

    public function allEmployeesWithUsersAndDocuments()
    {
        return \App\Models\Employee::with(['user', 'documents'])->get();
    }

    public function allEmployeesWithUsers()
    {
        return \App\Models\Employee::with('user')->get();
    }

    public function allEmployees()
    {
        return \App\Models\Employee::all();
    }

    public function allNotebooks()
    {
        return \App\Models\Notebook::all();
    }

    public function allDocuments()
    {
        return \App\Models\Document::all();
    }

    public function allAccessories()
    {
        return \App\Models\Accessory::all();
    }

    public function allEmployeesWithDocuments()
    {
        return \App\Models\Employee::with('documents')->get();
    }

    public function allNotebooksWithAccessories()
    {
        return \App\Models\Notebook::with('accessories')->get();
    }

    public function allNotebooksWithDocuments()
    {
        return \App\Models\Notebook::with('documents')->get();
    }

    public function allDocumentsWithAccessories()
    {
        return \App\Models\Document::with('accessories')->get();
    }

    /**
     * Seeders
     */
    protected function seedTestUser(): void
    {
        $this->artisan('db:seed', ['--class' => 'TestUserSeeder']);
    }

    protected function seedTestNotebook(): void
    {
        $this->artisan('db:seed', ['--class' => 'NotebookSeeder']);
    }

    protected function seedTestAccessory(): void
    {
        $this->artisan('db:seed', ['--class' => 'AccessorySeeder']);
    }

    /**
     * Mocking
     */
    protected function seedAccessoriesMock(int $quantity = 10)
    {
        \App\Models\Accessory::factory()->count($quantity)->create();
    }
}
