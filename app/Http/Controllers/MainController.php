<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

use function Laravel\Prompts\table;

class MainController extends Controller
{
    public function getSidebar()
    {
          $id = Session::get('user_id');
        $user = DB::table('users')->where('id', $id)->select('users_role_id')->first();
        // print_r($user);  
        // exit;
        $data['nonparent'] = DB::table('menus')->where('menu_role', $user->users_role_id)->where('menu_issub', 1)->orderBy('menu_order')->get();
        $data['parent'] = DB::table('menus')->where('menu_role', $user->users_role_id)->where('menu_issub', 2)->orderBy('menu_order')->get();
        $data['issub'] = DB::table('menus')->where('menu_role', $user->users_role_id)->where('menu_issub', 3)->orderBy('menu_order')->get();
      return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
    public function index()
    {
        try {
            // session(['Rules' => $this->getRoles(auth()->user()->id)]);
            session(['user_id' => auth()->user()->id]);
            session(['user_name' => auth()->user()->username]);
            // $menu_id = str_replace(" ", "-", ucwords(str_replace("-", " ", $menu_id)));

            $role_menu = DB::table('v_role_menus')
                ->where(['menu_active' => 1, 'user_id' => auth()->user()->id])
                ->first();
            // print_r( $role_menu->menu_id);
            // exit;
            $data = [
                // 'sidebar' => $menu['sidebar'],
                // 'roles' => array_column(session()->get('Rules')->toArray(), 'menu_code'),
                'menu_id' => $role_menu->menu_id,
                // 'menu_code' => strtolower($menu_code),
            ];
            $temp = Configuration::where('config_tipe', 'app')->orderBy('config_order', 'ASC')->get();
            if ($temp != []) {
                foreach ($temp as $k => $v) {
                    session([$v->config_code => $v->config_value]);
                }
            }
            // print_r($data); exit;
            return view('layouts.main', $data);
        } catch (Exception $e) {
            $statusCode = $e->getMessage();

            if ($statusCode === 404) {
                return view('error.404');
            } else if ($statusCode === 401) {
                return view('error.401');
            }
            dd($e);
            return view('error.500');
        }
    }
   
    public function table(Request $request)
    {
        $data = DB::table('menus')->get();
        return DataTables::of($data)
            ->toJson();
    }
    public function getPage(Request $request)
    {
        $id = Session::get('user_id');
        $user = DB::table('users')->where('id', $id)->select('users_role_id')->first();
        $data               = $request->post();
        $operation = Menu::where('menu_id', $data['menu_id'])->where('menu_role', $user->users_role_id)->first();
        // print_r($user->users_role_id);
        // print_r($operation->menu_role);
        // if ($user->users_role_id == $operation->menu_role) {
            // print_r("true");
            // exit;
            $module             = $operation->menu_folder_path;
            // $fileView           = (count($module) == 1) ? 'index' : $module[1];

            $viewPath           = $module . '.' . 'index';
            // print_r($viewPath);
            // exit;
            $renderData['view']     = base64_encode(view($viewPath));
            $renderData['isLogin']  = (session()->get('user_id') != '') ? true : false;
            $renderData['menu_title'] = $operation->menu_title;
            $renderData['menu_id'] = $data['menu_id'];
            $renderData['url_path'] =  getenv('APP_URL') . '/' . strtolower($operation->menu_code);
            $renderData['breadcrumb'] = base64_encode($this->get_breadcrumb($operation));
            // print_r($renderData);
            // exit;
            return $this->responsePage($renderData);
        // } else {
        //     // print_r("false");
        //     //     exit;
        //     $response = [
        //         'success' => 'false',
        //         'status' => 'error Auth',
        //         'title' => 'Gagal!',
        //         'message' => 'Terjadi Error Pada Sistem'
        //     ];
        //     return response()->json($response);
        // }
    }
    public function responsePage($data, $status = '', string $message = '')
    {
        if ($data === null && $status === null) {
            $status = 404;
            $output = null;
        } elseif ($data === null && is_numeric($status)) {
            $output = null;
        } else {
            $status = empty($status)
                ? 200
                : (array_search($status, $this->codes)
                    ? $status
                    : 400
                );
            $output = $data;
        }
        $output['message'] = $data['message'] ?? $message;

        return response()->json($output, $status);
    }

    public function get_breadcrumb($value)
    {
        if (empty($value['menu_parent']) && empty($value['menu_module'])) {
            return '
            <ul class="breadcrumb breadcrumb-line fw-bold fs-7 my-1">
                <li class="breadcrumb-item text-gray-400">' . $value['menu_title'] . '</li>
            </ul>';
        } elseif (empty($value['menu_parent'])) {
            return '
            <ul class="breadcrumb breadcrumb-line fw-bold fs-7 my-1">
                <li class="breadcrumb-item text-gray-400">' . $value['menu_title'] . '</li>
                <li class="breadcrumb-item text-gray-400">' . $value['menu_module'] . '</li>
            </ul>';
        } else {
            $parent = Menu::find($value->menu_parent);

            return '
            <ul class="breadcrumb breadcrumb-line fw-bold fs-7 my-1">
                <li class="breadcrumb-item text-gray-400">' . $parent['menu_title'] . '</li>
                <li class="breadcrumb-item text-light">' . $value['menu_title'] . '</li>
            </ul>';
        }
    }
    public function createmenu(Request $request)
    {
        $data = $request->except('_token');
        
        try {
            $data['menu_id'] = Menu::generateMenuid();
            $data['menu_active'] = 1;
            $data['menu_issub'] = 1;

            $operation = Menu::create($data);
            return response()->json(['success' => true, 'data' => $operation], 200);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);

        }
    }
}
