<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Faker\Factory as Faker;

    class SettingController extends Controller
    {
        public function index()
        {
            $employees = User::where('role', 'karyawan')->orderBy('id', 'desc')->paginate(5);

            $faker = Faker::create();

            $data = [];
            foreach ($employees as $employee) {
                $data[] = [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'contact' => $employee->contact,
                    'email' => $employee->email
                ];
            }

            return view('settings', compact('data', 'employees'));
        }

        // public function store(Request $request)
        // {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'contact' => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,contact',
        //     'email' => 'required|string|max:255|unique:users,email',
        //     'password' => 'required|string|min:8',
        // ]);

        // User::create([
        //     'name' => $request->name,
        //     'contact' => $request->contact,  // Pastikan field contact ada di form atau request
        //     'role' => 'karyawan',
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        // ]);

        // return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
        // }

        public function store(Request $request)
        {
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'contact' => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,contact',
                'email' => 'required|string|max:255|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            // Menyimpan data
            $user = User::create([
                'name' => $request->name,
                'contact' => $request->contact,
                'role' => 'karyawan',
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // if ($user) {
            //     // Response success
            //     return response()->json(['success' => true]);
            // }

            // Response failure jika terjadi masalah
            return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
        }

        // public function update(Request $request, $id)
        // {
        // $user = User::findOrFail($id);

        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'contact' => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,contact,' . $user->id,
        //     'username' => 'required|string|max:255|unique:users,name,' . $user->id,
        //     'password' => 'nullable|string|min:8',
        // ]);

        // $user->update([
        //     'name' => $request->name,
        //     'contact' => $request->contact,
        //     'password' => $request->password ? bcrypt($request->password) : $user->password,
        // ]);

        // return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
        // }
        public function update(Request $request, $id)
{
    $request->validate([
        'kname' => 'required|string|max:255',
        'contact' => 'required|string|regex:/^[0-9]{10,15}$/|unique:users,contact',
        'email' => 'required|string|max:255|unique:users,email',
        'password' => 'nullable|string|min:6',
    ]);

    $karyawan = User::findOrFail($id);
    $karyawan->update([
        'name' => $request->kname,
        'contact' => $request->contact,
        'email' => $request->email,
        'password' => $request->password ? bcrypt($request->password) : $karyawan->password,
    ]);

    return redirect()->route('settings')->with('success', 'Data karyawan berhasil diperbarui!');
}


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role !== 'karyawan') {
            return redirect()->route('karyawan.index')->with('error', 'Hanya karyawan yang bisa dihapus.');
        }

        $user->delete();

        return redirect()->route('settings')->with('success', 'Karyawan berhasil dihapus.');
    }
    }
