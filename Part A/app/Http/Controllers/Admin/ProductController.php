<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q = Product::with(['category', 'shop']);
        if ($request->filled('search')) {
            $q->where('name', 'like', '%'.$request->search.'%');
        }
        $products = $q->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => Category::orderBy('name')->get(),
            'shops' => Shop::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']).'-'.Str::random(4);
        $data['image'] = $this->handleImage($request, null) ?? 'images/products/milk.jpg';
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
            'shops' => Shop::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);
        $img = $this->handleImage($request, $product->image);
        if ($img !== null) {
            $data['image'] = $img;
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Product updated. Image & description saved.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Product deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'shop_id' => 'nullable|exists:shops,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive,out_of_stock',
            'image_file' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'image' => 'nullable|string|max:500',
        ]);
    }

    /**
     * Save upload to public/images/products (always web-visible)
     * and also to storage/app/public/products.
     * Returns path like images/products/xxx.jpg
     */
    protected function handleImage(Request $request, ?string $current): ?string
    {
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $name = Str::random(20).'.'.$file->getClientOriginalExtension();

            // Primary: public/images/products — works without storage:link
            $dir = public_path('images/products');
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $file->move($dir, $name);
            $publicPath = 'images/products/'.$name;

            // Mirror into storage for consistency
            try {
                $src = $dir.DIRECTORY_SEPARATOR.$name;
                Storage::disk('public')->put('products/'.$name, file_get_contents($src));
            } catch (\Throwable $e) {
                // ignore mirror failure
            }

            return $publicPath;
        }

        if ($request->filled('image')) {
            return ltrim($request->input('image'), '/');
        }

        return $current;
    }
}
