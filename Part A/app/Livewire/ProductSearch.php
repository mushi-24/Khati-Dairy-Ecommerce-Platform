<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

/**
 * Livewire ProductSearch — enable after: composer require livewire/livewire
 *
 * Usage in Blade: <livewire:product-search />
 *
 * Until Livewire is installed, this class is documentation/reference only.
 * Uncomment extends and traits after installing the package.
 */
class ProductSearch
{
    // use Livewire\Component;  // after install: class ProductSearch extends \Livewire\Component

    public string $query = "";
    public ?int $categoryId = null;
    public bool $inStockOnly = false;

    protected $queryString = [
        "query" => ["except" => ""],
        "categoryId" => ["except" => null],
    ];

    public function updatingQuery(): void
    {
        // reset page when using WithPagination
    }

    public function clearFilters(): void
    {
        $this->query = "";
        $this->categoryId = null;
        $this->inStockOnly = false;
    }

    /**
     * @return \Illuminate\Contracts\View\View|array
     */
    public function render()
    {
        $products = Product::query()
            ->with(["category", "shop"])
            ->when($this->query !== "", function ($q) {
                $q->where("name", "like", "%" . $this->query . "%");
            })
            ->when($this->categoryId, function ($q) {
                $q->where("category_id", $this->categoryId);
            })
            ->when($this->inStockOnly, function ($q) {
                $q->where("stock", ">", 0)->where("status", "active");
            })
            ->where("status", "active")
            ->latest()
            ->paginate(12);

        $categories = Category::where("is_active", true)->orderBy("name")->get();

        // return view("livewire.product-search", compact("products", "categories"));
        return compact("products", "categories");
    }
}
