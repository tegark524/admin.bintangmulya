<?php
// app/Http/Controllers/InstructorController.php
namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = Instructor::latest()->paginate(10);
        return view('instructors.index', compact('instructors'));
    }

    public function create()
    {
        return view('instructors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:instructors',
            'join_date' => 'required|date',
            'experience' => 'nullable|string'
        ]);

        Instructor::create($validated);

        return redirect()->route('instructors.index')
               ->with('success', 'Instruktur berhasil ditambahkan!');
    }

    public function edit(Instructor $instructor)
    {
        return view('instructors.edit', compact('instructor'));
    }

    public function update(Request $request, Instructor $instructor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:instructors,phone,'.$instructor->id,
            'join_date' => 'required|date',
            'experience' => 'nullable|string'
        ]);

        $instructor->update($validated);

        return redirect()->route('instructors.index')
               ->with('success', 'Data instruktur berhasil diperbarui!');
    }

    public function destroy(Instructor $instructor)
    {
        $instructor->delete();
        return back()->with('success', 'Instruktur berhasil dihapus!');
    }
}
