<?php

namespace App\Http\Controllers;

use App\Repository\classes\CategoryRepository;
use App\Repository\classes\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    private $repository;
    private $categoryRepository;

    public function __construct(ProductRepository $repository, CategoryRepository $categoryRepository)
    {
        $this->middleware('auth');
        $this->repository         = $repository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->querysearch ?? '';
        $list  = $this->repository->collectionPaginate($this->repository->all(['category'], $query, 'stock')['data']);

        return view('products.index', compact('list', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->all()['data'];

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categories = $this->categoryRepository->all()['data'];
        $input      = $request->only('description', 'measurenment_unit', 'price', 'category_id');
        $rules      = [
            'description'           => 'required|max:100|unique:products,category_id,'.$input['category_id'],
            'measurenment_unit'     => 'required|max:100',
            'price'                 => 'required',
            'category_id'           => 'required',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return  view('products.create', compact('input', 'categories'))->withErrors($validator->errors()->messages());
        }
        $result = $this->repository->create($input);

        return $result['success'] ?
            redirect()->route('products.index')->with('info', $result['message']) :
            view('products.create', compact('input', 'categories'))->withErrors($result['message']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = $this->categoryRepository->all()['data'];
        $itemToEdit = $this->repository->findOneOrFail($id);

        return view('products.edit', compact('categories', 'itemToEdit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categories           = $this->categoryRepository->all()['data'];
        $itemToEdit           = $this->repository->findOneOrFail($id);
        $input                = $request->only('description', 'measurenment_unit', 'price', 'stock', 'category_id');
        $rules                = [
            'description'           => 'required|max:100|unique:products,id,{{ id }}',
            'measurenment_unit'     => 'required|max:100',
            'price'                 => 'required',
            'stock'                 => 'required',
            'category_id'           => 'required',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return  view('products.edit', compact('itemToEdit', 'categories'))->withErrors($validator->errors()->messages());
        }
        $result= $this->repository->update($id, $input);

        return $result['success'] ?
            redirect()->route('products.index')->with('info', $result['message']) :
            view('products.edit', compact('itemToEdit', 'categories'))->withErrors($result['message']);
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