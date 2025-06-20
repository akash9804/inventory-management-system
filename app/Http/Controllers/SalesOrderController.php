<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesOrderController extends Controller
{

      // GET /sales-orders
    public function index()
    {
        $orders = SalesOrder::with('user')->latest()->get();
        return view('sales-orders.index', compact('orders'));
    }

    // GET /sales-orders/create
    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        return view('sales-orders.create', compact('products'));
    }

        // GET /sales-orders/{id}
    public function show($id)
    {
        $order = SalesOrder::with(['items.product', 'user'])->findOrFail($id);
        return view('sales-orders.show', compact('order'));
    }
    public function store(Request $request)
    {
        // ✅ Validate incoming request
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        // dd($request->items);     
        // ✅ Filter out zero or negative quantity entries
        $items = collect($request->items)->filter(fn($item) => $item['quantity'] > 0);
        // dd($items);
        if ($items->isEmpty()) {
            return back()->withErrors(['message' => 'Please order at least one product with quantity > 0.']);
        }

        DB::beginTransaction();

        try {
            $total = 0;

            // ✅ Step 1: Validate stock & calculate total
            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->quantity < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }

                $total += $product->price * $item['quantity'];
            }

            // ✅ Step 2: Create Sales Order
            $order = SalesOrder::create([
                'user_id' => auth()->id(),
                'total'   => $total,
            ]);

            // ✅ Step 3: Create Order Items and Reduce Stock
            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);
                SalesOrderItem::create([
                    'sales_order_id' => $order->id,
                    'product_id'     => $product->id,
                    'quantity'       => $item['quantity'],
                    'price'          => $product->price,
                    'total'          => $product->price * $item['quantity'],
                ]);

                $product->decrement('quantity', $item['quantity']);
            }

            DB::commit();

            return redirect()
                ->route('sales-orders.show', $order->id)
                ->with('success', 'Sales order created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }   


    public function downloadPdf($id)
    {
        $order = SalesOrder::with(['items.product', 'user'])->findOrFail($id);

        $pdf = Pdf::loadView('pdf.sales_order', ['order' => $order]);
        
        return $pdf->download('sales_order_' . $order->id . '.pdf');
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $items = collect($request->items)->filter(fn($item) => $item['quantity'] > 0);

        if ($items->isEmpty()) {
            return response()->json(['message' => 'No valid items provided.'], 422);
        }

        DB::beginTransaction();

        try {
            $total = 0;

            foreach ($items as $item) {
                $product = \App\Models\Product::findOrFail($item['product_id']);
                if ($product->quantity < $item['quantity']) {
                    return response()->json(['message' => "Not enough stock for {$product->name}"], 400);
                }
                $total += $product->price * $item['quantity'];
            }

            $order = \App\Models\SalesOrder::create([
                'user_id' => auth()->id(),
                'total' => $total,
            ]);

            foreach ($items as $item) {
                $product = \App\Models\Product::findOrFail($item['product_id']);

                \App\Models\SalesOrderItem::create([
                    'sales_order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                $product->decrement('quantity', $item['quantity']);
            }

            DB::commit();

            return response()->json(['message' => 'Order created', 'order_id' => $order->id], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to create order'], 500);
        }
    }

    public function apiShow($id)
    {
        $order = \App\Models\SalesOrder::with('items.product')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json([
            'id' => $order->id,
            'user' => $order->user->only('id', 'name', 'email'),
            'total' => $order->total,
            'created_at' => $order->created_at,
            'items' => $order->items->map(function ($item) {
                return [
                    'product_name' => $item->product->name,
                    'sku' => $item->product->sku,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ];
            }),
        ]);
    }

}



