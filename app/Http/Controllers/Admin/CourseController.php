<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::orderByDesc('created_at')->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.show', compact('course'));
    }

    public function validateCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->status = 'validated';
        $course->save();
        return redirect()->back()->with('success', 'Cours validé.');
    }

    public function rejectCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->status = 'rejected';
        $course->save();
        return redirect()->back()->with('success', 'Cours rejeté.');
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author_id' => 'required|exists:users,id',
        ]);
        $course = Course::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'author_id' => $validated['author_id'],
            'status' => 'pending',
        ]);
        return redirect()->route('admin.courses.index')->with('success', 'Cours créé avec succès.');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author_id' => 'required|exists:users,id',
        ]);
        $course->update($validated);
        return redirect()->route('admin.courses.index')->with('success', 'Cours modifié avec succès.');
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Cours supprimé.');
    }
}
