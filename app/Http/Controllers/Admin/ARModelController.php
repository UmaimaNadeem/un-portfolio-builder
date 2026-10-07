<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResolvesActivePortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ArModel;
use Illuminate\Support\Facades\File;

class ARModelController extends Controller
{
    use ResolvesActivePortfolio;

    public function index()
    {
        $portfolio = $this->activePortfolio();
        $arModels = $portfolio
            ? ArModel::where('portfolio_id', $portfolio->id)->get()
            : ArModel::where('user_id', Auth::id())->get();

        return view('pages.admin.armodels.index', compact('arModels'));
    }

    public function create()
    {
        return view('pages.admin.armodels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gltf' => 'required|file|mimes:gltf,json|max:10240',  // Limit to .gltf or .json
            'bin' => 'required|file|mimes:bin|max:10240',
            'textures.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:10240'
        ]);        

        $data = $request->all();
        $userId = Auth::id();
        $portfolio = $this->activePortfolio();

        $data['user_id'] = $userId;
        $data['portfolio_id'] = $portfolio?->id;
        $armodel = ArModel::create($data);

        if ($request->hasFile('gltf') || $request->hasFile('bin') || $request->hasFile('textures')) {
            $armodelId = $armodel->id;
            $basePath = base_path("content/{$userId}/armodels/{$armodelId}");
            
            if (!File::exists($basePath)) {
                File::makeDirectory($basePath, 0777, true, true);
            }
            
            if ($request->hasFile('gltf')) {
                $gltfName = $request->file('gltf')->getClientOriginalName();
                $request->file('gltf')->move($basePath, $gltfName);
                $data['gltf'] = "content/{$userId}/armodels/{$armodelId}/{$gltfName}";
            }
            
            if ($request->hasFile('bin')) {
                $binName = $request->file('bin')->getClientOriginalName();
                $request->file('bin')->move($basePath, $binName);
                $data['bin'] = "content/{$userId}/armodels/{$armodelId}/{$binName}";
            }

            $texturePaths = [];
            if ($request->hasFile('textures')) {
                foreach ($request->file('textures') as $texture) {
                    $textureName = $texture->getClientOriginalName();
                    $texture->move($basePath, $textureName);
                    $texturePaths[] = "content/{$userId}/armodels/{$armodelId}/{$textureName}";
                }
                $data['textures'] = json_encode($texturePaths);
            }

            $armodel->update([
                'gltf' => $data['gltf'] ?? null,
                'bin' => $data['bin'] ?? null,
                'textures' => $data['textures'] ?? null,
            ]);
        }

        return back()->with('success', '3D Model uploaded successfully.');
    }

    public function show(ArModel $armodel)
    {
        return view('pages.admin.armodels.view', compact('armodel'));
    }

    public function edit(ArModel $armodel)
    {
        return view('pages.admin.armodels.edit', compact('armodel'));
    }

    public function update(Request $request, ArModel $armodel)
    {
        $request->validate([
            'gltf' => 'nullable|file|mimes:gltf',
            'bin' => 'nullable|file|mimes:bin',
            'textures.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp'
        ]);

        $data = $request->all();
        $userId = Auth::id();

        if ($request->hasFile('gltf') || $request->hasFile('bin') || $request->hasFile('textures')) {
            $armodelId = $armodel->id;
            $basePath = base_path("content/{$userId}/armodels/{$armodelId}");

            if ($request->hasFile('gltf')) {
                if ($armodel->gltf) {
                    File::delete(base_path($armodel->gltf));
                }
                $gltfName = $request->file('gltf')->getClientOriginalName();
                $request->file('gltf')->move($basePath, $gltfName);
                $data['gltf'] = "content/{$userId}/armodels/{$armodelId}/{$gltfName}";
            }

            if ($request->hasFile('bin')) {
                if ($armodel->bin) {
                    File::delete(base_path($armodel->bin));
                }
                $binName = $request->file('bin')->getClientOriginalName();
                $request->file('bin')->move($basePath, $binName);
                $data['bin'] = "content/{$userId}/armodels/{$armodelId}/{$binName}";
            }

            $texturePaths = [];
            if ($request->hasFile('textures')) {
                if ($armodel->textures) {
                    foreach (json_decode($armodel->textures) as $oldTexture) {
                        File::delete(base_path($oldTexture));
                    }
                }
                foreach ($request->file('textures') as $texture) {
                    $textureName = $texture->getClientOriginalName();
                    $texture->move($basePath, $textureName);
                    $texturePaths[] = "content/{$userId}/armodels/{$armodelId}/{$textureName}";
                }
                $data['textures'] = json_encode($texturePaths);
            }
        }

        $armodel->update($data);

        return redirect()->route('armodels.index')->with('success', 'AR Model updated successfully.');
    }

    public function destroy(ArModel $armodel)
    {
        if ($armodel->gltf) {
            File::delete(base_path($armodel->gltf));
        }
        if ($armodel->bin) {
            File::delete(base_path($armodel->bin));
        }
        if ($armodel->textures) {
            foreach (json_decode($armodel->textures) as $texture) {
                File::delete(base_path($texture));
            }
        }

        $armodel->delete();
        return redirect()->route('armodels.index')->with('success', 'AR Model deleted successfully.');
    }
}
