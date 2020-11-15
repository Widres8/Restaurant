<?php

namespace App\Http\Controllers;

use App\Repository\classes\OrderRepository;
use App\Repository\classes\ProductRepository;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    private $repository;
    private $producRepository;

    public function __construct(OrderRepository $repository, ProductRepository $producRepository)
    {
        $this->middleware('auth');
        $this->repository       = $repository;
        $this->producRepository = $producRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->querysearch ?? '';
        $list  = $this->repository->collectionPaginate($this->repository->all(['orderDetails'], $query, 'created_at')['data']);

        return view('orders.index', compact('list', 'query'));
    }

    /**
     * Show the resource.
     *
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->repository->findWithIncludes($id, ['orderDetails'])['data'];

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = $this->producRepository->all()['data'];

        return view('orders.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input  = $request->only('details', 'total');
        $result = $this->repository->store($input);
        $data   = [
            'status'  => $result['success'],
            'Message' => $result['message'],
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing a resource.
     *
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = $this->producRepository->all()['data'];
        $order    = $this->repository->findWithIncludes($id, ['orderDetails'])['data'];

        return view('orders.edit', compact('products', 'order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input  = $request->only('details', 'total');
        $result = $this->repository->edit($id, $input);
        $data   = [
            'status'  => $result['success'],
            'Message' => $result['message'],
        ];

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->repository->destroy($id);
        $data   = [
            'status'  => $result['success'],
            'Message' => $result['message'],
        ];

        return response()->json($data);
    }
}