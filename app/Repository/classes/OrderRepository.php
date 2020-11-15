<?php

namespace App\Repository\classes;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository
{
    protected $model = Order::class;

    public function store(array $model)
    {
        DB::beginTransaction();
        try {
            $order = [
                'bill_number' => $this->billnumber(),
                'total'       => $model['total'],
            ];
            $this->setModel()->create($order);
            $orderId = $this->findMax('id');

            foreach ($model['details'] as $order) {
                $product = Product::find($order['id']);
                $product->update(['stock' =>($product->stock - $order['quantity'])]);
                OrderDetail::create([
                    'order_id'       => $orderId,
                    'product_id'     => $order['id'],
                    'price'          => $order['price'],
                    'quantity'       => $order['quantity'],
                ]);
            }
            DB::commit();

            return $this->getResponseMessage(true, 'Register Created Success', 200, true);
        } catch (\Exception $ex) {
            DB::rollBack();

            return $this->getResponseMessage(false, $ex->getMessage(), 500);
        }
    }

    public function edit($id, array $model)
    {
        DB::beginTransaction();
        try {
            $itemToEdit = $this->find($id);
            if (false == $itemToEdit) {
                return $this->getResponseMessage(false, 'Register Not Found', 404, true);
            }
            $itemToEdit->update(['total' => $model['total']]);
            foreach (OrderDetail::all() as $orderDetail) {
                $product = Product::find($orderDetail->product_id);
                $product->update(['stock' =>($product->stock + $orderDetail->quantity)]);
            }
            DB::table('order_details')
                ->where('order_id', $itemToEdit->id)
                ->delete();
            foreach ($model['details'] as $order) {
                $product = Product::find($order['id']);
                $product->update(['stock' =>($product->stock - $order['quantity'])]);
                OrderDetail::create([
                    'order_id'       => $itemToEdit->id,
                    'product_id'     => $order['id'],
                    'price'          => $order['price'],
                    'quantity'       => $order['quantity'],
                ]);
            }
            DB::commit();

            return $this->getResponseMessage(true, 'Register Updated Success', 200, true);
        } catch (\Exception $ex) {
            DB::rollBack();

            return $this->getResponseMessage(false, $ex->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $itemToDelete = $this->find($id);
            if (false == $itemToDelete) {
                return $this->getResponseMessage(false, 'Register Not Found', 404, true);
            }
            foreach (OrderDetail::all() as $orderDetail) {
                $product = Product::find($orderDetail->product_id);
                $product->update(['stock' =>($product->stock + $orderDetail->quantity)]);
            }
            DB::table('order_details')
                ->where('order_id', $itemToDelete->id)
                ->delete();
            $itemToDelete->delete();
            DB::commit();

            return $this->getResponseMessage(true, 'Register Deleted Success', 200, true);
        } catch (\Exception $ex) {
            DB::rollBack();

            return $this->getResponseMessage(false, $ex->getMessage(), 500);
        }
    }

    protected function billnumber()
    {
        $bill_number = $this->findMax('bill_number');
        if ('' == $bill_number) {
            $bill_number = '001';
        } else {
            if ($bill_number <= 8) {
                $bill_number = '00'.($bill_number + 1);
            } elseif ($bill_number >= 10 && $bill_number <= 98) {
                $bill_number = '0'.($bill_number + 1);
            } else {
                $bill_number = ''.($bill_number + 1);
            }
        }

        return $bill_number;
    }
}