<?php
namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;
use App\Model\Docs;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Validator;

class ManageController extends Controller{

    public $delete_rule = [
        'id' => 'required|integer|min:1',
        'page' => 'required|integer|min:1',
    ];

    public function manage_view(Request $request)
    {
        $data['data'] = Docs::paginate(15);
        $data['page'] = empty($request->input('page')) ? 1 : $request->input('page') ;
        return view('backend.docs.manage',$data);
    }

    public function delete(Request $request)
    {
        $data = $request->all();
        $id = $request->input('id');
        $page = empty($request->input('page')) ? 1 : $request->input('page') ;
        $validator = Validator::make($data, $this->delete_rule);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $warn = [
                'title' => '操作失败',
                'content' => $error
            ];
            return Redirect::to('backend/docs/manage?page='.$page)->with('warn', $warn);
        }
        $res = DB::table('docs')->where('id',$id)->delete();
        if($res) {
            $warn = [
                'title' => '操作成功',
                'content' => '删除成功'
            ];
            return Redirect::to('backend/docs/manage?page='.$page)->with('warn', $warn);
        }
        $warn = [
            'title' => '操作失败',
            'content' => '删除失败'
        ];
        return Redirect::to('backend/docs/manage?page='.$page)->with('warn', $warn);
    }

}