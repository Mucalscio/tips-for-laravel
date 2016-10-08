<?php
namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;
use App\Model\Docs;
use Illuminate\Http\Request;
use Validator;
use Redirect;

class EditController extends Controller{

    public $create_rule = [
        'name' => 'required|max:255',
        'author' => 'required|max:64',
    ];

    public $edit_rule = [
        'name' => 'required|max:255',
        'author' => 'required|max:64',
    ];

    public function create_view()
    {
        return view('backend.docs.edit');
    }

    public function create(Request $request)
    {
        $data = $request->all();
        //dump($data);
        $validator = Validator::make($data, $this->create_rule);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            $warn = [
                'title' => '操作失败',
                'content' => $error
            ];
            return Redirect::to('backend/docs/create_view')->with('warn', $warn);
        }
        $num = Docs::where('name',$data['name'])->count();
        if( $num > 0 ) {
            $warn = [
                'title' => '操作失败',
                'content' => '该文档已经存在'
            ];
            return Redirect::to('backend/docs/create_view')->with('warn', $warn);
        }
        $doc = new Docs();
        $doc->name = $data['name'];
        $doc->author = $data['author'];
        $doc->save();
        $warn = [
            'title' => '操作成功',
            'content' => '文档已创建成功'
        ];
        //用save去插入数据,模型中会自动把自增的ID加上去
        return Redirect::to('backend/docs/edit_view/'.$doc->id)->with('warn', $warn);
    }

    public function edit_view($id)
    {
        $data['id'] = $id;
        $doc = Docs::where('id',$id)->first();
        $data['name'] = $doc->name;
        $data['author'] = $doc->author;
        return view('backend.docs.edit',$data);
    }

    public function edit($id, Request $request)
    {
        $data = $request->all();
        //dump($data);
        $validator = Validator::make($data, $this->edit_rule);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json( formatReturnData(-2, $error) );
        }
        $num = Docs::where('id',$data['id'])->count();
        if( $num > 0 ) {
            return response()->json( formatReturnData(-1, '该文档不存在') );
        }
        $doc = Docs::where('id',$data['id'])->first();
        $doc->name = $data['name'];
        $doc->author = $data['author'];
        $doc->save();
        return response()->json( formatReturnData(1, '修改成功') );
    }

}