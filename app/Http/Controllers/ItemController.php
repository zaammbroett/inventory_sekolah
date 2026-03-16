<?php

class ItemController extends Controller
{

    public function index(Request $request)
    {

        $items = Item::with('category')
            ->when($request->search,function($query) use ($request){

                $query->where('name','like','%'.$request->search.'%');

            })
            ->get();

        return response()->json($items);

    }

    public function store(Request $request)
    {

        $photo = null;

        if($request->hasFile('photo')){

            $photo = $request->file('photo')->store('items','public');

        }

        $item = Item::create([
            'name'=>$request->name,
            'category_id'=>$request->category_id,
            'stock'=>$request->stock,
            'photo'=>$photo
        ]);

        return response()->json($item);

    }

    public function show($id)
    {
        return Item::with('category')->find($id);
    }

    public function update(Request $request,$id)
    {

        $item = Item::find($id);

        $item->update($request->all());

        return response()->json($item);

    }

    public function destroy($id)
    {

        Item::destroy($id);

        return response()->json([
            'message'=>'deleted'
        ]);

    }

}