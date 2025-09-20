<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $query = $request->input('query');

        $users = User::where('role', 0);

        if ($query) {
            $users->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            });
        }
        $users = $users->paginate(10);
        if ($query && $users->isEmpty()) {
            return view('admin.users.tables', compact('users'))->with('message', 'Không tìm thấy người dùng nào');
        }


        return view('admin.users.tables', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.users.form-elements');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $valid = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'password_confirm' => 'required|string|min:8|same:password',
        ]);

        $user = User::create([
            'name' => $valid['name'],
            'email' => $valid['email'],
            'password' => bcrypt($valid['password'])
        ]);

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('admin.users.edit-users', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Xác thực dữ liệu từ request
        $valid = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id, // Tránh trùng email với chính người dùng đang chỉnh sửa
            'password' => 'nullable|min:8|confirmed', // Kiểm tra mật khẩu nếu có
        ]);

        // Tìm người dùng theo id
        $user = User::findOrFail($id);

        // Cập nhật thông tin người dùng
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Nếu có mật khẩu mới, cập nhật mật khẩu
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Lưu thay đổi
        $user->save();

        // Quay lại trang danh sách người dùng với thông báo thành công
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Tìm người dùng theo ID
        $user = User::findOrFail($id);

        // Xóa người dùng
        $user->delete();

        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    /**
     * Hiển thị danh sách người dùng trong thùng rác (đã soft delete)
     */
    public function trash_show()
    {
        $users = User::onlyTrashed()->where('role', 0)->paginate(10);
        return view('admin.users.user_trash', compact('users'));
    }

    /**
     * Khôi phục người dùng đã bị xóa mềm
     */
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('admin.users.trash')->with('success', 'Khôi phục người dùng thành công');
    }

    /**
     * Xóa vĩnh viễn người dùng
     */
    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('admin.users.trash')->with('success', 'Đã xóa vĩnh viễn người dùng');
    }
}
