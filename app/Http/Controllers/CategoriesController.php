<?php

namespace App\Http\Controllers;

use App\Repository\classes\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->querysearch ?? '';
        $list  = $this->repository->collectionPaginate($this->repository->all(['products'], $query, 'description')['data']);

        return view('categories.index', compact('list', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only('description');

        $rules = [
            'description'     => 'required|max:100|unique:categories',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return redirect()->route('categories.index')->withErrors($validator->errors()->messages());
        }
        $result = $this->repository->create($input);

        return $result['success'] ?
            redirect()->route('categories.index')->with('info', $result['message']) :
            redirect()->route('categories.index')->withErrors($result['message']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->only('description');
        $rules = [
            'description'     => 'required|max:100|unique:categories,id,{{ id }}',
        ];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return redirect()->route('categories.index')->withErrors($validator->errors()->messages());
        }
        $result = $this->repository->update($id, $input);

        return $result['success'] ?
            redirect()->route('categories.index')->with('info', $result['message']) :
            redirect()->route('categories.index')->withErrors($result['message']);
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