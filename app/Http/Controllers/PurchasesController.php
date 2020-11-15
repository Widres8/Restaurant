<?php

namespace App\Http\Controllers;

use App\Repository\classes\PurchaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchasesController extends Controller
{
    private $repository;

    public function __construct(PurchaseRepository $repository)
    {
        $this->middleware('auth');
        $this->repository         = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->querysearch ?? '';
        $list  = $this->repository->collectionPaginate($this->repository->all([], $query, 'description')['data']);

        return view('purchases.index', compact('list', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchases.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input      = $request->only('description', 'price', 'comments');
        $rules      = [
            'description'           => 'required|max:255|unique:purchases',
            'price'                 => 'required',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return  view('purchases.create', compact('input'))->withErrors($validator->errors()->messages());
        }
        $result = $this->repository->create($input);

        return $result['success'] ?
            redirect()->route('purchases.index')->with('info', $result['message']) :
            view('purchases.create', compact('input'))->withErrors($result['message']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $itemToEdit = $this->repository->findOneOrFail($id);

        return view('purchases.edit', compact('itemToEdit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $itemToEdit           = $this->repository->findOneOrFail($id);
        $input                = $request->only('description', 'price', 'comments');
        $rules                = [
            'description'           => 'required|max:100|unique:purchases,id,{{ id }}',
            'price'                 => 'required',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return  view('purchases.edit', compact('itemToEdit'))->withErrors($validator->errors()->messages());
        }
        $result= $this->repository->update($id, $input);

        return $result['success'] ?
            redirect()->route('purchases.index')->with('info', $result['message']) :
            view('purchases.edit', compact('itemToEdit'))->withErrors($result['message']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->repository->delete($id);
        $data   = [
            'status'  => $result['success'],
            'Message' => $result['message'],
        ];

        return response()->json($data);
    }
}