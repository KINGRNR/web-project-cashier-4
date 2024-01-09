<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use Illuminate\Http\Request;
use App\Models\Menu;
use Exception;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index($menu_code = 'dashboard')
    {
        try {
            // session(['Rules' => $this->getRoles(auth()->user()->id)]);
            session(['user_id' => auth()->user()->id]);
            session(['user_name' => auth()->user()->username]);
            $menu_code = str_replace(" ", "-", ucwords(str_replace("-", " ", $menu_code)));

            $role_menu = DB::table('v_role_menus')
                ->where(['menu_code' => ucfirst($menu_code), 'menu_active' => 1, 'user_id' => auth()->user()->id])
                ->first();
            $data = [
                // 'sidebar' => $menu['sidebar'],
                // 'roles' => array_column(session()->get('Rules')->toArray(), 'menu_code'),
                'menu_id' => $role_menu->menu_id,
                'menu_code' => strtolower($menu_code),
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

    public function getPage(Request $request)
    {
        $data               = $request->post();
        $operation          = Menu::find($data['menu_id']);
        $module             = explode('.', $operation->menu_code);
        $fileView           = (count($module) == 1) ? 'index' : $module[1];
        $viewPath           = strtolower($module[0]) . '.' . $fileView;
        $renderData['view']     = base64_encode(view($viewPath));
        $renderData['isLogin']  = (session()->get('user_id') != '') ? true : false;
        $renderData['menu_title'] = $operation->menu_title;
        $renderData['menu_id'] = $data['menu_id'];
        $renderData['url_path'] =  getenv('APP_URL') . '/' . strtolower($operation->menu_code);
        $renderData['breadcrumb'] = base64_encode($this->get_breadcrumb($operation));
        // print_r($renderData);
        // exit;

        return $this->responsePage($renderData);
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


 
    
  
}
