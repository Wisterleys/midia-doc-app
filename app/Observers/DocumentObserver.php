<?php

namespace App\Observers;

use App\Models\Document;

class DocumentObserver
{
    public function retrieved(Document $model): void
    {
        if (
            !is_null($model->id)
            && !is_null($model->price)
        ) {
            $model->price = 'R$ ' . number_format($model->price, 2, ',', '.');
            \Log::info("Documento listado: " . json_encode($model->toArray()));
        }
    }

    public function creating(Document $model): void
    {
        if (
            !is_null($model->id)
            && !is_null($model->price)
        ) {
            $model->price = floatval(str_replace(['.', ','], ['', '.'], $model->price));
        }
    }

    public function created(Document $model): void
    {
        // Exemplo: Registrar atividade no log ou notificar o usuário
        \Log::info("Novo documento criado: " . json_encode($model->toArray()));
    }

    public function updating(Document $model): void
    {
        if (
            !is_null($model->id)
            && !is_null($model->price)
        ) {
            $model->price = floatval(str_replace(['.', ','], ['', '.'], $model->price));
        }
    }

    public function deleted(Document $model): void
    {
        // Exemplo: Limpar cache ou registros relacionados
        \Log::info("Documento deletado: {$model->id}");
    }
}