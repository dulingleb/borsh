<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function menu()
    {
        return view('menu');
    }

    public function autocomplete(Request $request)
    {
        $dishes = Menu::where('title', 'LIKE', '%' . $request->q . '%')->get();
        $data = [];
        foreach ($dishes as $dish) {
            $data[] = ['text' => $this->replace_quotes($dish->title), 'value' => $dish->id, 'composition' => $dish->composition, 'price' => number_format($dish->price, '1', ',', ' '), 'weight' => $dish->weight];
        }

        return response()->json($data);
    }

    public function index()
    {
        $dishes = Menu::orderBy('title', 'ASC')->get();
        return view('index', compact('dishes'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:24|unique:menu,title',
            'composition' => 'nullable|string|max:128',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0'
        ], [
            'title.unique' => 'Такое блюдо уже есть',
            'title.max' => 'Максимум доступно 24 символа в названии'
        ]);

        Menu::create([
            'title' => $request->title,
            'composition' => $request->composition ?? null,
            'price' => $request->price,
            'weight' => $request->weight
        ]);
    }

    public function edit($id)
    {
        $dish = Menu::findOrFail($id);
        return view('edit', compact('dish'));
    }

    public function update(Request $request, $id)
    {
        $dish = Menu::findOrFail($id);

        $this->validate($request, [
            'title' => 'required|string|max:24|unique:menu,title,' . $id,
            'composition' => 'nullable|string|max:128',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0'
        ], [
            'title.unique' => 'Такое блюдо уже есть',
            'title.max' => 'Максимум доступно 24 символа в названии'
        ]);

        $dish->update([
            'title' => $request->title,
            'composition' => $request->composition ?? null,
            'price' => $request->price,
            'weight' => $request->weight
        ]);
    }

    public function destroy($id)
    {
        $dish = Menu::findOrFail($id);
        $dish->delete();
    }

    private function replace_quotes($text)
    {
        $text = htmlspecialchars_decode($text, ENT_QUOTES);
        $text = str_replace(array('«', '»'), '"', $text);
        return preg_replace_callback('/(([\"]{2,})|(?![^\W])(\"))|([^\s][\"]+(?![\w]))/u', function ($matches) {
            if (count($matches) == 3) {
                return '«»';
            } elseif (!empty($matches[1])) {
                return str_replace('"', '«', $matches[1]);
            } else {
                return str_replace('"', '»', $matches[4]);
            }
        }, $text);
    }
}
