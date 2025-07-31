<?php

namespace App\Repositories\Entities\Product;

use App\Models\Product;
use App\Repositories\Contracts\Product\IProductRepository;
use Illuminate\Support\Facades\Auth;

class ProductRepository implements IProductRepository
{
    public function all()
    {
        return Product::where('user_id', Auth::id())->get();
    }

    public function findById($id)
    {
        return Product::where(
            'user_id', 
            Auth::id()
            )
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        if (empty($data)) {
            return null;
        }

        if (isset($data['user_id'])) {
            return null;
        }

        $data['user_id'] = Auth::id();
        return Product::create($data);
    }

    public function update(int $id, array $data)
    {
        if (empty($data)) {
            return null;
        }

        if (is_null($id)) {
            return null;
        }

        $document = $this->find($id);

        if (is_null($document)) {
            return null;
        }

        $document->update($data);
        return $document;
    }

    public function delete($id)
    {
        if (is_null($id)) {
            return null;
        }

        $document = $this->find($id);

        if (is_null($document)) {
            return null;
        }

        return $document->delete();
    }

    public function search($search)
    {
        return Product::where('user_id', Auth::id())
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('description', 'like', "%$search%")
                    ->orWhereHas('user', function($q) use ($search) {
                        $q->where('cpf', 'like', "%$search%")
                          ->orWhere('name', 'like', "%$search%")
                          ->orWhere('role', 'like', "%$search%");
                    });
            })
            ->get();
    }
}