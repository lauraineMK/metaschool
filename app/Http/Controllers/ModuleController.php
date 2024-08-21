<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display the module list
     *
     * @return void
     */
    public function index()
    {
        $modules = Module::all();
        return response()->json($modules);
    }

    /**
     * Show details of a specific module by its id
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $module = Module::find($id);
        if (!$module) {
            return response()->json(['message' => 'Module not found'], 404);
        }
        return response()->json($module);
    }

    /**
     * Create a new module
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'section_id' => 'nullable|exists:sections,id',
            'level' => 'nullable|integer',
        ]);

        $module = Module::create($request->all());
        return response()->json($module, 201);
    }

    /**
     * Update an existing module by its id
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'course_id' => 'sometimes|required|exists:courses,id',
            'section_id' => 'nullable|exists:sections,id',
            'level' => 'nullable|integer',
        ]);

        $module = Module::find($id);
        if (!$module) {
            return response()->json(['message' => 'Module not found'], 404);
        }

        $module->update($request->all());
        return response()->json($module);
    }

    /**
     * Delete a module by its id
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        $module = Module::find($id);
        if (!$module) {
            return response()->json(['message' => 'Module not found'], 404);
        }

        $module->delete();
        return response()->json(['message' => 'Module deleted']);
    }
}
